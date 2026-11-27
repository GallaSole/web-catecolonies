<?php
/**
 * Configuració del tema, estils, menús i funcions d'ajuda per a les plantilles.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_post_type_support( 'page', 'excerpt' );

	// L'editor s'assembla a la web: mateixes lletres i colors.
	add_theme_support( 'editor-styles' );
	add_editor_style( array(
		'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=DM+Sans:wght@400;500;700&display=swap',
		'assets/css/editor.css',
	) );

	register_nav_menus( array(
		'principal' => 'Menú principal (a dalt)',
		'peu'       => 'Menú del peu de pàgina',
	) );
} );

/* ---------- Estils i JavaScript ---------- */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'kt-fonts', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=DM+Sans:wght@400;500;700&display=swap', array(), null );
	wp_enqueue_style( 'kt-estil', get_theme_file_uri( 'assets/css/estil.css' ), array( 'kt-fonts' ), kt_versio_fitxer( 'assets/css/estil.css' ) );
	wp_enqueue_style( 'kt-wordpress', get_theme_file_uri( 'assets/css/wordpress.css' ), array( 'kt-estil' ), kt_versio_fitxer( 'assets/css/wordpress.css' ) );
	wp_enqueue_script( 'kt-main', get_theme_file_uri( 'assets/js/main.js' ), array(), kt_versio_fitxer( 'assets/js/main.js' ), array( 'in_footer' => true ) );

	// El tema no fa servir els estils de blocs de la portada de WordPress: la web té els seus.
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
} );

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

/** Versió d'un fitxer segons la data de modificació: així els navegadors no guarden còpies velles. */
function kt_versio_fitxer( $ruta ) {
	$fitxer = get_theme_file_path( $ruta );
	return file_exists( $fitxer ) ? (string) filemtime( $fitxer ) : KT_VERSIO;
}

/* ---------- Títol i descripció de cada pàgina ---------- */
add_filter( 'document_title_separator', function () {
	return '·';
} );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( is_front_page() ) {
		$parts = array( 'title' => get_bloginfo( 'name' ), 'tagline' => get_bloginfo( 'description' ) );
	} else {
		$parts['site'] = 'Catecolònies';
		unset( $parts['tagline'] );
	}
	return $parts;
} );

add_action( 'wp_head', function () {
	$descripcio = '';
	if ( is_front_page() ) {
		$descripcio = kt_opcio( 'descripcio_web' );
	} elseif ( is_home() ) {
		$pagina     = get_option( 'page_for_posts' );
		$descripcio = $pagina ? get_post_field( 'post_excerpt', $pagina ) : '';
	} elseif ( is_singular() ) {
		$descripcio = get_post_field( 'post_excerpt', get_queried_object_id() );
	}
	if ( $descripcio ) {
		echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( $descripcio ) ) . '">' . "\n";
	}
}, 2 );

/* ---------- Funcions d'ajuda per a les plantilles ---------- */

/** Adreça d'una imatge de la carpeta assets/img del tema. */
function kt_img( $fitxer ) {
	return get_theme_file_uri( 'assets/img/' . $fitxer );
}

/**
 * Adreça d'una imatge que pot ser externa (https://...) o del tema (img/fitxer.png).
 */
function kt_src( $valor ) {
	$valor = trim( (string) $valor );
	if ( '' === $valor ) {
		return '';
	}
	if ( preg_match( '#^(https?:)?//#', $valor ) || 0 === strpos( $valor, '/' ) ) {
		return $valor;
	}
	return get_theme_file_uri( 'assets/' . ltrim( $valor, './' ) );
}

/** Adreça d'una pàgina de la web pel seu nom curt (qui-som, faq, noticies...). */
function kt_url( $slug = '' ) {
	if ( '' === $slug || 'inici' === $slug ) {
		return home_url( '/' );
	}
	if ( 'noticies' === $slug && get_option( 'page_for_posts' ) ) {
		return get_permalink( get_option( 'page_for_posts' ) );
	}
	$pagina = get_page_by_path( $slug );
	return $pagina ? get_permalink( $pagina ) : home_url( '/' . $slug . '/' );
}

/** Adreça d'una notícia dins la pàgina de Notícies (s'obre en gran). */
function kt_url_noticia( $post = null ) {
	$post = get_post( $post );
	return kt_url( 'noticies' ) . '#' . $post->post_name;
}

/** Canvia {{web}} per l'adreça de la web (es fa servir als textos importats). */
function kt_enllacos( $html ) {
	return str_replace( '{{web}}', untrailingslashit( home_url() ), (string) $html );
}
add_filter( 'the_content', 'kt_enllacos', 1 );
add_filter( 'get_the_excerpt', 'kt_enllacos', 1 );

/** Llista de línies d'un camp de text (una per línia, sense línies buides). */
function kt_linies( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $text ) ) ) );
}

/** Data en català: «10 d'octubre de 2026». */
function kt_data( $post = null ) {
	$mesos = array( '', 'gener', 'febrer', 'març', 'abril', 'maig', 'juny', 'juliol', 'agost', 'setembre', 'octubre', 'novembre', 'desembre' );
	$t     = get_post_timestamp( $post );
	$dia   = (int) wp_date( 'j', $t );
	$mes   = $mesos[ (int) wp_date( 'n', $t ) ];
	$de    = preg_match( '/^[aeiouàèéíòóú]/u', $mes ) ? "d'" : 'de ';
	return $dia . ' ' . $de . $mes . ' de ' . wp_date( 'Y', $t );
}

/* ---------- Menús ---------- */

/** Pàgines del menú per defecte (si encara no s'ha creat cap menú). */
function kt_menu_defecte() {
	return array(
		array( 'Inici', kt_url( '' ) ),
		array( "Qui som i d'on venim", kt_url( 'qui-som' ) ),
		array( 'Inscripcions', kt_url( 'inscripcions' ) ),
		array( 'Mini-KT', kt_url( 'minikt' ) ),
		array( 'KT Fotos', kt_url( 'kt-fotos' ) ),
		array( 'Notícies', kt_url( 'noticies' ) ),
		array( 'FAQ', kt_url( 'faq' ) ),
		array( 'Documents', kt_url( 'documents' ) ),
	);
}

/** Elements d'un menú: [ [text, adreça, és_actiu], ... ]. */
function kt_elements_menu( $lloc ) {
	$llocs    = get_nav_menu_locations();
	$elements = array();
	if ( is_front_page() ) {
		$actual = home_url( '/' );
	} elseif ( is_home() || is_singular( 'post' ) ) {
		$actual = kt_url( 'noticies' );
	} elseif ( is_singular() ) {
		$actual = get_permalink();
	} else {
		$actual = '';
	}
	$actual = untrailingslashit( $actual );

	if ( ! empty( $llocs[ $lloc ] ) ) {
		$items = wp_get_nav_menu_items( $llocs[ $lloc ] );
		foreach ( (array) $items as $item ) {
			if ( $item->menu_item_parent ) {
				continue;
			}
			$elements[] = array( $item->title, $item->url );
		}
	}
	if ( ! $elements ) {
		$elements = kt_menu_defecte();
		if ( 'peu' === $lloc ) {
			array_shift( $elements );
		}
	}

	foreach ( $elements as &$e ) {
		$adreca = untrailingslashit( strtok( $e[1], '?#' ) );
		$e[2]   = '' !== $actual && $adreca === $actual;
	}
	return $elements;
}

function kt_menu_principal() {
	foreach ( kt_elements_menu( 'principal' ) as $e ) {
		printf( '<a href="%s"%s>%s</a>' . "\n", esc_url( $e[1] ), $e[2] ? ' class="actiu" aria-current="page"' : '', esc_html( $e[0] ) );
	}
}

function kt_menu_peu() {
	foreach ( kt_elements_menu( 'peu' ) as $e ) {
		printf( '<li><a href="%s">%s</a></li>' . "\n", esc_url( $e[1] ), esc_html( $e[0] ) );
	}
}

/* ---------- Notícies ---------- */

// A la pàgina de Notícies es mostren totes les notícies, sense pàgines.
add_action( 'pre_get_posts', function ( $q ) {
	if ( ! is_admin() && $q->is_main_query() && $q->is_home() ) {
		$q->set( 'posts_per_page', 60 );
	}
} );

// Una notícia sola s'obre dins de la pàgina de Notícies, igual que si hi cliques.
add_action( 'template_redirect', function () {
	if ( is_singular( 'post' ) && ! is_preview() && ! is_customize_preview() ) {
		wp_safe_redirect( kt_url_noticia( get_queried_object() ), 302 );
		exit;
	}
} );

add_filter( 'excerpt_more', function () {
	return '…';
} );

/**
 * Imatge d'una notícia: la imatge destacada o, si no n'hi ha, la del camp «Imatge des d'un enllaç».
 * Retorna array( 'src', 'gran', 'alt', 'logo' ).
 */
function kt_imatge_noticia( $post = null ) {
	$post = get_post( $post );
	$src  = '';
	$gran = '';
	$alt  = '';
	if ( has_post_thumbnail( $post ) ) {
		$src  = get_the_post_thumbnail_url( $post, 'medium_large' );
		$gran = get_the_post_thumbnail_url( $post, 'full' );
		$alt  = get_post_meta( get_post_thumbnail_id( $post ), '_wp_attachment_image_alt', true );
	} elseif ( kt_camp( 'kt_imatge_url', $post ) ) {
		$src = kt_src( kt_camp( 'kt_imatge_url', $post ) );
	}
	if ( kt_camp( 'kt_imatge_gran_url', $post ) ) {
		$gran = kt_src( kt_camp( 'kt_imatge_gran_url', $post ) );
	}
	if ( ! $alt ) {
		$alt = kt_camp( 'kt_imatge_alt', $post );
	}
	return array(
		'src'  => $src,
		'gran' => $gran,
		'alt'  => $alt ? $alt : get_the_title( $post ),
		'logo' => (bool) kt_camp( 'kt_imatge_logo', $post ),
	);
}

/** Categoria que surt a l'etiqueta de la notícia (no surt si és la categoria per defecte). */
function kt_xip_noticia( $post = null ) {
	$cats = get_the_category( get_post( $post )->ID );
	foreach ( $cats as $c ) {
		if ( (int) $c->term_id !== (int) get_option( 'default_category' ) ) {
			return $c->name;
		}
	}
	return '';
}

/** Resum de la targeta: l'extracte o el començament del text. */
function kt_resum_noticia( $post = null ) {
	$post = get_post( $post );
	if ( has_excerpt( $post ) ) {
		return kt_enllacos( $post->post_excerpt );
	}
	return esc_html( wp_trim_words( wp_strip_all_tags( strip_shortcodes( $post->post_content ) ), 30, '…' ) );
}

/**
 * Prepara un tros d'HTML fix de la web original: els enllaços «pagina.html» passen a les pàgines de
 * WordPress i les imatges «img/...» a la carpeta del tema.
 */
function kt_html_estatic( $html ) {
	$html = preg_replace_callback( '/href="([a-z0-9-]+)\.html(#[^"]*)?"/', function ( $m ) {
		$slug = 'index' === $m[1] ? '' : $m[1];
		$hash = isset( $m[2] ) ? $m[2] : '';
		return 'href="' . esc_url( kt_url( $slug ) . $hash ) . '"';
	}, $html );
	$html = preg_replace_callback( '/src="img\/([^"]+)"/', function ( $m ) {
		return 'src="' . esc_url( kt_img( $m[1] ) ) . '"';
	}, $html );
	return $html;
}

// Els apòstrofs es queden rectes (') com a la web original.
add_filter( 'run_wptexturize', '__return_false' );
