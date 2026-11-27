<?php
/**
 * Importador: la primera vegada que s'activa el tema, crea les pàgines, els menús i tot el contingut
 * que hi havia a la web estàtica (notícies, preguntes, documents, vídeos i Mini-KT).
 * Si ja existeix alguna cosa amb el mateix nom, no la toca.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_switch_theme', function () {
	if ( ! get_option( 'kt_importat' ) ) {
		kt_importa();
	}
} );

/* Si per algun motiu no s'ha importat, es pot fer des d'Eines → Contingut de les KT. */
add_action( 'admin_menu', function () {
	add_management_page( 'Contingut de les KT', 'Contingut de les KT', 'manage_options', 'kt-importa', function () {
		if ( isset( $_POST['kt_importa'] ) && check_admin_referer( 'kt_importa' ) ) {
			$fet = kt_importa();
			echo '<div class="notice notice-success"><p>' . esc_html( $fet ) . '</p></div>';
		}
		echo '<div class="wrap"><h1>Contingut de les KT</h1>';
		echo '<p>Crea les pàgines, els menús i el contingut inicial de la web (notícies, preguntes, documents, vídeos i Mini-KT).</p>';
		echo '<p>Només s\'afegeix el que falta: el que ja existeix no es modifica ni es duplica.</p>';
		echo '<form method="post">';
		wp_nonce_field( 'kt_importa' );
		submit_button( 'Crea el contingut que falti', 'primary', 'kt_importa' );
		echo '</form></div>';
	} );
} );

function kt_importa() {
	$fitxer = get_theme_file_path( 'inc/dades-inicials.json' );
	if ( ! file_exists( $fitxer ) ) {
		return 'No s\'ha trobat el fitxer de dades.';
	}
	$dades = json_decode( file_get_contents( $fitxer ), true );
	$creats = 0;

	/* ---------- Configuració general ---------- */
	update_option( 'blogname', 'Catecolònies Sant Martí' );
	update_option( 'blogdescription', 'Arenys de Munt' );
	update_option( 'timezone_string', 'Europe/Madrid' );
	update_option( 'date_format', 'j F Y' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'permalink_structure', '/noticies/%postname%/' );

	$general = get_term( (int) get_option( 'default_category' ), 'category' );
	if ( $general && ! is_wp_error( $general ) && in_array( $general->slug, array( 'uncategorized', 'sense-categoria' ), true ) ) {
		wp_update_term( $general->term_id, 'category', array( 'name' => 'General', 'slug' => 'general' ) );
	}

	// Treu el contingut d'exemple de WordPress (només si no s'ha tocat).
	foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page' ) as $slug => $tipus ) {
		$exemple = get_page_by_path( $slug, OBJECT, $tipus );
		if ( $exemple && $exemple->post_modified === $exemple->post_date ) {
			wp_delete_post( $exemple->ID, true );
		}
	}

	/* ---------- Pàgines ---------- */
	$pagines = array(
		'inici'        => array( 'Inici', 'index' ),
		'qui-som'      => array( "Qui som i d'on venim", 'qui-som' ),
		'inscripcions' => array( 'Inscripcions', 'inscripcions' ),
		'minikt'       => array( 'Mini-KT', 'minikt' ),
		'kt-fotos'     => array( 'KT Fotos', 'kt-fotos' ),
		'noticies'     => array( 'Notícies', 'noticies' ),
		'faq'          => array( 'Preguntes freqüents', 'faq' ),
		'documents'    => array( 'Documents', 'documents' ),
	);
	$ids    = array();
	$ordre  = 0;
	foreach ( $pagines as $slug => $p ) {
		$existent = get_page_by_path( $slug );
		if ( $existent ) {
			$ids[ $slug ] = $existent->ID;
			continue;
		}
		$ids[ $slug ] = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $p[0],
			'post_name'    => $slug,
			'post_excerpt' => isset( $dades['descripcions'][ $p[1] ] ) ? $dades['descripcions'][ $p[1] ] : '',
			'menu_order'   => $ordre++,
			'post_content' => '',
		) );
		$creats++;
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $ids['inici'] );
	update_option( 'page_for_posts', $ids['noticies'] );
	if ( get_post( $ids['noticies'] ) ) {
		wp_update_post( array( 'ID' => $ids['noticies'], 'post_excerpt' => 'Avisos, novetats i cròniques de les KT.' ) );
	}

	/* ---------- Notícies ---------- */
	foreach ( array_reverse( $dades['noticies'] ) as $n ) {
		if ( get_page_by_path( $n['slug'], OBJECT, 'post' ) ) {
			continue;
		}
		$cat = array();
		if ( $n['categoria'] ) {
			$term = term_exists( $n['categoria'], 'category' );
			if ( ! $term ) {
				$term = wp_insert_term( $n['categoria'], 'category' );
			}
			if ( ! is_wp_error( $term ) ) {
				$cat[] = (int) $term['term_id'];
			}
		}
		$id = wp_insert_post( wp_slash( array(
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'post_title'    => $n['titol'],
			'post_name'     => $n['slug'],
			'post_date'     => $n['data'],
			'post_excerpt'  => $n['resum'],
			'post_content'  => $n['contingut'],
			'post_category' => $cat,
		) ) );
		if ( is_wp_error( $id ) || ! $id ) {
			continue;
		}
		$creats++;
		$meta = array(
			'kt_imatge_url'      => $n['imatge'],
			'kt_imatge_gran_url' => $n['imatge_gran'],
			'kt_imatge_alt'      => $n['imatge_alt'],
			'kt_imatge_logo'     => $n['imatge_logo'] ? '1' : '',
			'kt_text_boto'       => 'Llegeix-la sencera →' === $n['text_boto'] ? '' : $n['text_boto'],
		);
		foreach ( $meta as $k => $v ) {
			if ( '' !== $v ) {
				update_post_meta( $id, $k, $v );
			}
		}
	}

	/* ---------- Preguntes freqüents ---------- */
	foreach ( $dades['faq']['temes'] as $t ) {
		if ( ! term_exists( $t['slug'], 'kt_tema' ) ) {
			wp_insert_term( $t['nom'], 'kt_tema', array( 'slug' => $t['slug'] ) );
		}
	}
	if ( ! get_posts( array( 'post_type' => 'kt_pregunta', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) {
		foreach ( $dades['faq']['preguntes'] as $i => $p ) {
			$id = wp_insert_post( wp_slash( array(
				'post_type'    => 'kt_pregunta',
				'post_status'  => 'publish',
				'post_title'   => $p['pregunta'],
				'post_content' => $p['resposta'],
				'menu_order'   => $i,
			) ) );
			if ( $id && ! is_wp_error( $id ) ) {
				wp_set_object_terms( $id, $p['tema'], 'kt_tema' );
				$creats++;
			}
		}
	}

	/* ---------- Documents ---------- */
	if ( ! get_posts( array( 'post_type' => 'kt_document', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) {
		foreach ( $dades['documents']['utils'] as $i => $d ) {
			kt_insereix( 'kt_document', $d['titol'], array(
				'kt_seccio'     => 'util',
				'kt_enllac'     => $d['enllac'],
				'kt_icona'      => $d['icona'],
				'kt_descripcio' => $d['descripcio'],
			), $i );
			$creats++;
		}
		foreach ( $dades['documents']['dossiers'] as $d ) {
			kt_insereix( 'kt_document', $d['titol'], array(
				'kt_seccio' => 'dossier',
				'kt_enllac' => $d['enllac'],
				'kt_any'    => $d['any'],
			) );
			$creats++;
		}
	}

	/* ---------- Vídeos de les KT Fotos ---------- */
	if ( ! get_posts( array( 'post_type' => 'kt_video', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) {
		foreach ( $dades['videos'] as $v ) {
			kt_insereix( 'kt_video', 'KT Fotos ' . $v['any'], array( 'kt_any' => $v['any'], 'kt_enllac' => $v['enllac'] ) );
			$creats++;
		}
	}

	/* ---------- Mini-KT ---------- */
	if ( ! get_posts( array( 'post_type' => 'kt_minikt', 'posts_per_page' => 1, 'post_status' => 'any' ) ) ) {
		foreach ( $dades['minikt'] as $m ) {
			$meta = array();
			foreach ( array( 'any', 'torns', 'resum', 'dates', 'preu', 'trobada', 'trobada_lloc', 'inscripcions', 'inscripcions_lloc', 'cartell', 'per_inscriure', 'que_portar' ) as $k ) {
				if ( ! empty( $m[ $k ] ) ) {
					$meta[ 'kt_' . $k ] = $m[ $k ];
				}
			}
			kt_insereix( 'kt_minikt', $m['titol'], $meta );
			$creats++;
		}
	}

	/* ---------- Menús ---------- */
	$llocs = get_theme_mod( 'nav_menu_locations', array() );
	$menus = array(
		'principal' => array( 'Menú principal', array( 'inici' => 'Inici', 'qui-som' => "Qui som i d'on venim", 'inscripcions' => 'Inscripcions', 'minikt' => 'Mini-KT', 'kt-fotos' => 'KT Fotos', 'noticies' => 'Notícies', 'faq' => 'FAQ', 'documents' => 'Documents' ) ),
		'peu'       => array( 'Menú del peu', array( 'qui-som' => "Qui som i d'on venim", 'inscripcions' => 'Inscripcions', 'minikt' => 'Mini-KT', 'kt-fotos' => 'KT Fotos', 'noticies' => 'Notícies', 'faq' => 'Preguntes freqüents', 'documents' => 'Documents' ) ),
	);
	foreach ( $menus as $lloc => $menu ) {
		if ( ! empty( $llocs[ $lloc ] ) && wp_get_nav_menu_object( $llocs[ $lloc ] ) ) {
			continue;
		}
		$existent = wp_get_nav_menu_object( $menu[0] );
		$menu_id  = $existent ? $existent->term_id : wp_create_nav_menu( $menu[0] );
		if ( is_wp_error( $menu_id ) ) {
			continue;
		}
		if ( ! $existent ) {
			foreach ( $menu[1] as $slug => $text ) {
				if ( empty( $ids[ $slug ] ) ) {
					continue;
				}
				wp_update_nav_menu_item( $menu_id, 0, array(
					'menu-item-title'     => $text,
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $ids[ $slug ],
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				) );
			}
		}
		$llocs[ $lloc ] = $menu_id;
	}
	set_theme_mod( 'nav_menu_locations', $llocs );

	flush_rewrite_rules();
	update_option( 'kt_importat', KT_VERSIO );

	return $creats ? "Fet! S'han creat {$creats} elements." : 'Ja hi era tot: no ha calgut crear res.';
}

/** Crea un element d'un tipus de contingut de les KT amb els seus camps. */
function kt_insereix( $tipus, $titol, $meta, $ordre = 0 ) {
	$id = wp_insert_post( wp_slash( array(
		'post_type'   => $tipus,
		'post_status' => 'publish',
		'post_title'  => $titol,
		'menu_order'  => $ordre,
	) ) );
	if ( $id && ! is_wp_error( $id ) ) {
		foreach ( $meta as $k => $v ) {
			update_post_meta( $id, $k, wp_slash( $v ) );
		}
	}
	return $id;
}
