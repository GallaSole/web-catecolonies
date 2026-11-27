<?php
/**
 * Tipus de contingut propis de les KT: preguntes freqüents, documents, vídeos de les KT Fotos i Mini-KT.
 * Cadascun surt com un apartat al menú del tauler de WordPress.
 */

defined( 'ABSPATH' ) || exit;

function kt_etiquetes( $plural, $singular, $nou ) {
	return array(
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'all_items'          => 'Tots',
		'add_new'            => 'Afegeix-ne',
		'add_new_item'       => $nou,
		'edit_item'          => 'Edita',
		'new_item'           => $nou,
		'view_item'          => 'Mostra',
		'search_items'       => 'Cerca',
		'not_found'          => 'No n\'hi ha cap',
		'not_found_in_trash' => 'No n\'hi ha cap a la paperera',
	);
}

add_action( 'init', function () {
	$comu = array(
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'rewrite'             => false,
	);

	register_post_type( 'kt_pregunta', $comu + array(
		'labels'        => kt_etiquetes( 'Preguntes freqüents', 'Pregunta', 'Nova pregunta' ),
		'menu_icon'     => 'dashicons-editor-help',
		'menu_position' => 6,
		'supports'      => array( 'title', 'editor', 'page-attributes' ),
	) );

	register_taxonomy( 'kt_tema', 'kt_pregunta', array(
		'labels'            => array(
			'name'          => 'Temes',
			'singular_name' => 'Tema',
			'menu_name'     => 'Temes (filtres)',
			'add_new_item'  => 'Afegeix un tema',
			'all_items'     => 'Tots els temes',
		),
		'public'            => false,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'rewrite'           => false,
	) );

	register_post_type( 'kt_document', $comu + array(
		'labels'        => kt_etiquetes( 'Documents', 'Document', 'Nou document' ),
		'menu_icon'     => 'dashicons-media-document',
		'menu_position' => 7,
		'supports'      => array( 'title', 'page-attributes' ),
	) );

	register_post_type( 'kt_video', $comu + array(
		'labels'        => kt_etiquetes( 'Vídeos KT Fotos', 'Vídeo', 'Nou vídeo' ),
		'menu_icon'     => 'dashicons-video-alt3',
		'menu_position' => 8,
		'supports'      => array( 'title' ),
	) );

	register_post_type( 'kt_minikt', $comu + array(
		'labels'        => kt_etiquetes( 'Mini-KT', 'Mini-KT', 'Nova Mini-KT' ),
		'menu_icon'     => 'dashicons-palmtree',
		'menu_position' => 9,
		'supports'      => array( 'title' ),
	) );
} );

/* ---------- Consultes que fan servir les plantilles ---------- */

function kt_preguntes() {
	return get_posts( array(
		'post_type'      => 'kt_pregunta',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	) );
}

function kt_temes_faq() {
	$temes = get_terms( array( 'taxonomy' => 'kt_tema', 'hide_empty' => true, 'orderby' => 'term_id' ) );
	return is_wp_error( $temes ) ? array() : $temes;
}

function kt_documents( $seccio ) {
	$args = array(
		'post_type'      => 'kt_document',
		'posts_per_page' => -1,
		'meta_query'     => array( array( 'key' => 'kt_seccio', 'value' => $seccio ) ),
	);
	if ( 'dossier' === $seccio ) {
		$args['meta_key'] = 'kt_any';
		$args['orderby']  = array( 'meta_value_num' => 'DESC', 'date' => 'DESC' );
	} else {
		$args['orderby'] = array( 'menu_order' => 'ASC', 'date' => 'ASC' );
	}
	return get_posts( $args );
}

function kt_videos() {
	return get_posts( array(
		'post_type'      => 'kt_video',
		'posts_per_page' => -1,
		'meta_key'       => 'kt_any',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
	) );
}

function kt_minikts() {
	return get_posts( array(
		'post_type'      => 'kt_minikt',
		'posts_per_page' => -1,
		'meta_key'       => 'kt_any',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
	) );
}

/** Identificador d'un vídeo a partir de l'enllaç: [ 'youtube' | 'drive', id ]. */
function kt_video_id( $enllac ) {
	$enllac = trim( (string) $enllac );
	if ( preg_match( '~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([\w-]{6,})~', $enllac, $m ) ) {
		return array( 'youtube', $m[1] );
	}
	if ( preg_match( '~drive\.google\.com/(?:file/d/|open\?id=)([\w-]{10,})~', $enllac, $m ) ) {
		return array( 'drive', $m[1] );
	}
	if ( preg_match( '~^[\w-]{11}$~', $enllac ) ) {
		return array( 'youtube', $enllac );
	}
	return array( '', '' );
}
