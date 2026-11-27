<?php
/**
 * Tauler més senzill per a qui edita la web: les «Entrades» es diuen «Notícies», no hi ha comentaris
 * i a l'escriptori hi ha una guia ràpida.
 */

defined( 'ABSPATH' ) || exit;

/* «Entrades» → «Notícies» */
add_filter( 'post_type_labels_post', function ( $l ) {
	$l->name               = 'Notícies';
	$l->singular_name      = 'Notícia';
	$l->menu_name          = 'Notícies';
	$l->name_admin_bar     = 'Notícia';
	$l->all_items          = 'Totes les notícies';
	$l->add_new            = 'Afegeix-ne una';
	$l->add_new_item       = 'Nova notícia';
	$l->edit_item          = 'Edita la notícia';
	$l->new_item           = 'Nova notícia';
	$l->view_item          = 'Mostra la notícia';
	$l->search_items       = 'Cerca notícies';
	$l->not_found          = 'No hi ha cap notícia';
	$l->featured_image     = 'Imatge de la notícia';
	$l->set_featured_image = 'Tria la imatge de la notícia';
	return $l;
} );

add_action( 'admin_menu', function () {
	global $menu;
	foreach ( (array) $menu as $k => $item ) {
		if ( isset( $item[2] ) && 'edit.php' === $item[2] ) {
			$menu[ $k ][0] = 'Notícies'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
			$menu[ $k ][6] = 'dashicons-megaphone'; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		}
	}
	remove_menu_page( 'edit-comments.php' );
} );

/* Sense comentaris enlloc */
add_action( 'init', function () {
	foreach ( array( 'post', 'page' ) as $tipus ) {
		remove_post_type_support( $tipus, 'comments' );
		remove_post_type_support( $tipus, 'trackbacks' );
	}
} );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_action( 'admin_bar_menu', function ( $bar ) {
	$bar->remove_node( 'comments' );
}, 99 );

/* Guia ràpida a l'escriptori */
add_action( 'wp_dashboard_setup', function () {
	wp_add_dashboard_widget( 'kt_guia', 'Com editar la web de les KT', 'kt_guia_tauler' );

	// La guia, la primera de totes.
	global $wp_meta_boxes;
	$normal = $wp_meta_boxes['dashboard']['normal']['core'];
	$guia   = array( 'kt_guia' => $normal['kt_guia'] );
	unset( $normal['kt_guia'] );
	$wp_meta_boxes['dashboard']['normal']['core'] = array_merge( $guia, $normal ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
} );

function kt_guia_tauler() {
	$personalitza = function ( $seccio ) {
		return admin_url( 'customize.php?autofocus[section]=' . $seccio );
	};
	$tasques = array(
		array( '📣', 'Publicar una notícia', admin_url( 'post-new.php' ), 'Títol, text i una imatge destacada. L\'«Extracte» és el resum de la targeta. Surt sola a Notícies i a la portada.' ),
		array( '🔔', 'Canviar l\'avís de la portada', $personalitza( 'kt_portada' ), 'Per exemple: «Preinscripcions obertes!». També el text i la foto de dalt.' ),
		array( '📅', 'Canviar les dates de les colònies', $personalitza( 'kt_dates' ), 'El compte enrere de la portada es calcula sol.' ),
		array( '💶', 'Canviar preus, IBAN i fitxes', $personalitza( 'kt_inscripcions' ), 'Els imports a pagar es calculen sols.' ),
		array( '📄', 'Afegir el dossier o un document', admin_url( 'edit.php?post_type=kt_document' ), 'Posa l\'enllaç de Drive i l\'any. El més recent surt destacat.' ),
		array( '❓', 'Afegir o canviar una pregunta', admin_url( 'edit.php?post_type=kt_pregunta' ), 'Cada pregunta té un tema, que és el botó de filtre.' ),
		array( '🎬', 'Afegir el vídeo de les KT Fotos', admin_url( 'edit.php?post_type=kt_video' ), 'Enllaç de YouTube o Drive i l\'any. Recorda amagar l\'avís «Pròximament».' ),
		array( '🌱', 'Anunciar una Mini-KT', admin_url( 'edit.php?post_type=kt_minikt' ), 'La de l\'any més recent surt amb totes les dades.' ),
	);
	echo '<style>.kt-guia{margin:0;padding:0;list-style:none}.kt-guia li{display:flex;gap:10px;padding:9px 0;border-bottom:1px solid #f0f0f1}.kt-guia li:last-child{border:0}.kt-guia span{font-size:20px;line-height:1.2}.kt-guia a{font-weight:600}.kt-guia p{margin:2px 0 0;color:#646970}</style>';
	echo '<ul class="kt-guia">';
	foreach ( $tasques as $t ) {
		printf( '<li><span>%s</span><div><a href="%s">%s</a><p>%s</p></div></li>', esc_html( $t[0] ), esc_url( $t[2] ), esc_html( $t[1] ), esc_html( $t[3] ) );
	}
	echo '</ul>';
	echo '<p style="margin:12px 0 0;color:#646970">El disseny de la web (colors, menú, peu) no es pot espatllar des d\'aquí: només canvien els textos i les imatges.</p>';
}
