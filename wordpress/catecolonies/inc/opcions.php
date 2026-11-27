<?php
/**
 * Opcions de la web: Aparença → Personalitza → «Les KT».
 * Cada opció té un valor per defecte, que és el que hi havia a la web estàtica.
 */

defined( 'ABSPATH' ) || exit;

function kt_definicio_opcions() {
	return array(
		'kt_portada'      => array(
			'titol'  => 'Portada',
			'opcions' => array(
				'avis_mostrar'       => array( 'checkbox', 'Mostra l\'avís de la portada', true ),
				'avis_icona'         => array( 'text', 'Avís: icona (emoji)', '📣' ),
				'avis_titol'         => array( 'text', 'Avís: títol', 'Pròximament: PREINSCRIPCIONS 2027' ),
				'avis_text'          => array( 'textarea', 'Avís: text', 'Normalment s\'obren entre febrer i març. Ho anunciarem aquí, per correu a les famílies i a Instagram.' ),
				'avis_boto_text'     => array( 'text', 'Avís: text del botó', 'Com funciona?' ),
				'avis_boto_enllac'   => array( 'url', 'Avís: enllaç del botó (buit = pàgina d\'Inscripcions)', '' ),
				'hero_etiqueta'      => array( 'text', 'Capçalera: etiqueta petita', 'Colònies educatives · Arenys de Munt' ),
				'hero_titol'         => array( 'text', 'Capçalera: títol', 'Deu dies d\'estiu que' ),
				'hero_titol_destacat' => array( 'text', 'Capçalera: final del títol (en color)', 'no s\'obliden' ),
				'hero_intro'         => array( 'textarea', 'Capçalera: text', 'Cada any, de l\'1 al 10 d\'agost, centenars d\'infants i joves d\'Arenys de Munt marxen de colònies. Quatre torns i una gran família de voluntaris que ho fa possible.' ),
				'hero_imatge'        => array( 'image', 'Capçalera: foto', '' ),
			),
		),
		'kt_dates'        => array(
			'titol'   => 'Dates de les colònies',
			'opcions' => array(
				'data_sortida' => array( 'date', 'Dia de sortida (per al compte enrere)', '2027-08-01' ),
				'hora_sortida' => array( 'text', 'Hora de sortida (hh:mm)', '09:00' ),
				'data_tornada' => array( 'date', 'Últim dia de colònies', '2027-08-10' ),
				'text_compte'  => array( 'text', 'Text sota el compte enrere', 'Sortim l\'1 d\'agost. Ja tens la motxilla a punt?' ),
			),
		),
		'kt_inscripcions' => array(
			'titol'   => 'Inscripcions i preus',
			'opcions' => array(
				'preu_infant'         => array( 'number', 'Preu per a 1 infant (€)', 390 ),
				'preu_germans'        => array( 'number', 'Preu per infant si hi van germans (€)', 360 ),
				'paga_senyal'         => array( 'number', 'Paga i senyal de la preinscripció (€)', 50 ),
				'iban'                => array( 'text', 'IBAN per a les transferències', 'ES15 2100 6247 58 1300237350' ),
				'data_devolucio'      => array( 'text', 'Devolucions: cal demanar-les abans de…', 'l\'1 de juliol' ),
				'cartell_inscripcions' => array( 'image', 'Cartell de les inscripcions', 'https://blogger.googleusercontent.com/img/a/AVvXsEgsOmJWb1uGZullb760x3FHe8mgBqVJEDYag6UN-encf8pZTOf3EGAkjhPBZEFNn771vseQvzJcDiZx3_5aWxRgZjwGFYzy6k5JzGzApRiA2CU3sb0_qKC3q2bpkHA3C66R7-xa9FIWo2IJuYprojxQzKL5LPtXIkLuXNh5AS8mZd9LqrAOettyIzDSJTBl=w800' ),
				'enllac_fitxa'        => array( 'url', 'Enllaç de la fitxa d\'inscripció', 'https://docs.google.com/document/d/19d5G04wiaagC9Ot5QAqKRNqQz_BzOxj5FK9eQtoxvEY/edit?usp=drive_link' ),
				'enllac_medicaments'  => array( 'url', 'Enllaç de l\'autorització de medicaments', 'https://drive.google.com/file/d/12u2qekcJjeS2Bjda0e7kHbCIXMLGv95T/view' ),
			),
		),
		'kt_ktfotos'      => array(
			'titol'   => 'KT Fotos',
			'opcions' => array(
				'proper_mostrar' => array( 'checkbox', 'Mostra l\'avís «Pròximament» del vídeo nou', true ),
				'proper_any'     => array( 'text', 'Any del vídeo que arriba', '2026' ),
				'proper_titol'   => array( 'text', 'Text de l\'avís', 'El vídeo de les KT 2026 arriba aviat' ),
			),
		),
		'kt_contacte'     => array(
			'titol'   => 'Contacte i xarxes',
			'opcions' => array(
				'correu'         => array( 'email', 'Correu de les KT', 'catecolonies@gmail.com' ),
				'instagram'      => array( 'text', 'Usuari d\'Instagram (sense @)', 'ktcolonies' ),
				'blog_antic'     => array( 'url', 'Enllaç del blog antic', 'https://catecolonies.blogspot.com/' ),
				'descripcio_web' => array( 'textarea', 'Descripció de la web (per als cercadors)', 'Colònies educatives d\'Arenys de Munt des de 1984. De l\'1 al 10 d\'agost, quatre torns i una gran família de voluntaris.' ),
			),
		),
	);
}

/** Valor d'una opció de la web. */
function kt_opcio( $clau ) {
	static $defecte = null;
	if ( null === $defecte ) {
		$defecte = array();
		foreach ( kt_definicio_opcions() as $seccio ) {
			foreach ( $seccio['opcions'] as $k => $o ) {
				$defecte[ $k ] = $o[2];
			}
		}
	}
	return get_theme_mod( $clau, isset( $defecte[ $clau ] ) ? $defecte[ $clau ] : '' );
}

/** Imports en euros sense decimals innecessaris: 390 €, 12,50 €. */
function kt_euros( $valor ) {
	$valor = (float) $valor;
	return ( floor( $valor ) == $valor ? number_format( $valor, 0, ',', '.' ) : number_format( $valor, 2, ',', '.' ) ) . ' €';
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_panel( 'kt_panel', array(
		'title'       => 'Les KT',
		'description' => 'Textos, dates i preus que canvien cada any. Els canvis es veuen a la dreta abans de publicar-los.',
		'priority'    => 1,
	) );

	$prioritat = 0;
	foreach ( kt_definicio_opcions() as $id_seccio => $seccio ) {
		$wp_customize->add_section( $id_seccio, array(
			'title'    => $seccio['titol'],
			'panel'    => 'kt_panel',
			'priority' => ++$prioritat,
		) );
		foreach ( $seccio['opcions'] as $clau => $o ) {
			list( $tipus, $etiqueta, $defecte ) = $o;
			$sanejar = array(
				'checkbox' => function ( $v ) { return (bool) $v; },
				'textarea' => 'sanitize_textarea_field',
				'url'      => 'esc_url_raw',
				'image'    => 'esc_url_raw',
				'email'    => 'sanitize_email',
				'number'   => function ( $v ) { return '' === $v ? '' : (float) str_replace( ',', '.', $v ); },
			);
			$wp_customize->add_setting( $clau, array(
				'default'           => $defecte,
				'sanitize_callback' => isset( $sanejar[ $tipus ] ) ? $sanejar[ $tipus ] : 'sanitize_text_field',
			) );
			if ( 'image' === $tipus ) {
				$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $clau, array(
					'label'   => $etiqueta,
					'section' => $id_seccio,
				) ) );
			} else {
				$wp_customize->add_control( $clau, array(
					'label'   => $etiqueta,
					'section' => $id_seccio,
					'type'    => $tipus,
				) );
			}
		}
	}
} );
