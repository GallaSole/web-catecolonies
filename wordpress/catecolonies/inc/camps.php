<?php
/**
 * Camps extra (caixes sota l'editor) per a les notícies i els continguts de les KT.
 */

defined( 'ABSPATH' ) || exit;

/** Definició dels camps de cada tipus de contingut. */
function kt_definicio_camps() {
	return array(
		'post'        => array(
			'titol'  => 'Imatge i botó de la targeta',
			'ajuda'  => 'El resum de la targeta és l\'«Extracte» (a la columna de la dreta). Si no n\'hi poses, se\'n fa un amb el començament del text.',
			'camps'  => array(
				'kt_imatge_url'      => array( 'tipus' => 'imatge', 'etiqueta' => 'Imatge des d\'un enllaç', 'ajuda' => 'Només si no hi ha «Imatge destacada». Pot ser un enllaç d\'Internet.' ),
				'kt_imatge_gran_url' => array( 'tipus' => 'imatge', 'etiqueta' => 'Imatge en gran (opcional)', 'ajuda' => 'La que surt quan s\'obre la notícia. Si està buit, es fa servir la mateixa.' ),
				'kt_imatge_logo'     => array( 'tipus' => 'casella', 'etiqueta' => 'La imatge és un logo: mostra-la sencera sobre fons blanc' ),
				'kt_text_boto'       => array( 'tipus' => 'text', 'etiqueta' => 'Text del botó', 'ajuda' => 'Per defecte: «Llegeix-la sencera →».' ),
			),
		),
		'kt_document' => array(
			'titol' => 'Dades del document',
			'camps' => array(
				'kt_seccio'     => array( 'tipus' => 'opcions', 'etiqueta' => 'On surt', 'opcions' => array( 'util' => 'Documents útils (a dalt)', 'dossier' => 'Dossiers de cada any' ) ),
				'kt_enllac'     => array( 'tipus' => 'url', 'etiqueta' => 'Enllaç al document', 'ajuda' => 'Per exemple, l\'enllaç de Google Drive (compartit amb «Qualsevol persona amb l\'enllaç»).' ),
				'kt_any'        => array( 'tipus' => 'nombre', 'etiqueta' => 'Any (només per als dossiers)', 'ajuda' => 'El dossier de l\'any més recent surt destacat.' ),
				'kt_icona'      => array( 'tipus' => 'text', 'etiqueta' => 'Icona (només per als documents útils)', 'ajuda' => 'Un emoji, per exemple 📝 💊 📋.' ),
				'kt_descripcio' => array( 'tipus' => 'text', 'etiqueta' => 'Descripció curta (només per als documents útils)' ),
			),
		),
		'kt_video'    => array(
			'titol' => 'Dades del vídeo',
			'camps' => array(
				'kt_any'    => array( 'tipus' => 'nombre', 'etiqueta' => 'Any de les colònies', 'ajuda' => 'El vídeo de l\'any més recent surt en gran.' ),
				'kt_enllac' => array( 'tipus' => 'url', 'etiqueta' => 'Enllaç del vídeo', 'ajuda' => 'De YouTube (https://youtu.be/...) o de Google Drive (https://drive.google.com/file/d/...).' ),
			),
		),
		'kt_minikt'   => array(
			'titol' => 'Dades de la Mini-KT',
			'ajuda' => 'La Mini-KT de l\'any més recent surt com a «L\'última Mini-KT», amb totes les dades. Les altres surten a la llista d\'anteriors amb el títol i el resum.',
			'camps' => array(
				'kt_any'               => array( 'tipus' => 'nombre', 'etiqueta' => 'Any' ),
				'kt_torns'             => array( 'tipus' => 'text', 'etiqueta' => 'Torn', 'ajuda' => 'Per exemple «2n torn». Si n\'hi ha més d\'una etiqueta, separa-les amb comes.' ),
				'kt_resum'             => array( 'tipus' => 'textarea', 'etiqueta' => 'Resum (per a la llista de Mini-KT anteriors)' ),
				'kt_dates'             => array( 'tipus' => 'text', 'etiqueta' => 'Dates', 'grup' => 'Dades de l\'última Mini-KT' ),
				'kt_preu'              => array( 'tipus' => 'text', 'etiqueta' => 'Preu' ),
				'kt_trobada'           => array( 'tipus' => 'text', 'etiqueta' => 'Trobada (dia i hora)' ),
				'kt_trobada_lloc'      => array( 'tipus' => 'text', 'etiqueta' => 'Lloc de trobada' ),
				'kt_inscripcions'      => array( 'tipus' => 'text', 'etiqueta' => 'Inscripcions (dies)' ),
				'kt_inscripcions_lloc' => array( 'tipus' => 'text', 'etiqueta' => 'Lloc de les inscripcions' ),
				'kt_cartell'           => array( 'tipus' => 'imatge', 'etiqueta' => 'Cartell' ),
				'kt_per_inscriure'     => array( 'tipus' => 'textarea', 'etiqueta' => 'Per inscriure\'s cal portar', 'ajuda' => 'Una cosa per línia.' ),
				'kt_que_portar'        => array( 'tipus' => 'textarea', 'etiqueta' => 'Què s\'ha de portar', 'ajuda' => 'Una cosa per línia.' ),
			),
		),
	);
}

/** Valor d'un camp. */
function kt_camp( $clau, $post = null ) {
	$post = get_post( $post );
	return $post ? get_post_meta( $post->ID, $clau, true ) : '';
}

add_action( 'add_meta_boxes', function ( $tipus ) {
	$def = kt_definicio_camps();
	if ( empty( $def[ $tipus ] ) ) {
		return;
	}
	add_meta_box( 'kt_camps', $def[ $tipus ]['titol'], 'kt_caixa_camps', $tipus, 'normal', 'high', array( '__back_compat_meta_box' => false ) );
} );

function kt_caixa_camps( $post ) {
	$def = kt_definicio_camps()[ $post->post_type ];
	wp_nonce_field( 'kt_camps', 'kt_camps_nonce' );
	if ( ! empty( $def['ajuda'] ) ) {
		echo '<p class="description" style="margin-bottom:12px">' . esc_html( $def['ajuda'] ) . '</p>';
	}
	echo '<table class="form-table kt-camps" role="presentation"><tbody>';
	foreach ( $def['camps'] as $clau => $c ) {
		$valor = get_post_meta( $post->ID, $clau, true );
		if ( ! empty( $c['grup'] ) ) {
			echo '<tr><th colspan="2"><h3 style="margin:10px 0 0">' . esc_html( $c['grup'] ) . '</h3></th></tr>';
		}
		echo '<tr><th scope="row"><label for="' . esc_attr( $clau ) . '">' . esc_html( $c['etiqueta'] ) . '</label></th><td>';
		switch ( $c['tipus'] ) {
			case 'casella':
				printf( '<input type="checkbox" id="%1$s" name="%1$s" value="1"%2$s>', esc_attr( $clau ), checked( $valor, '1', false ) );
				break;
			case 'textarea':
				printf( '<textarea id="%1$s" name="%1$s" rows="5" class="large-text">%2$s</textarea>', esc_attr( $clau ), esc_textarea( $valor ) );
				break;
			case 'opcions':
				printf( '<select id="%1$s" name="%1$s">', esc_attr( $clau ) );
				foreach ( $c['opcions'] as $v => $text ) {
					printf( '<option value="%s"%s>%s</option>', esc_attr( $v ), selected( $valor, $v, false ), esc_html( $text ) );
				}
				echo '</select>';
				break;
			case 'nombre':
				printf( '<input type="number" id="%1$s" name="%1$s" value="%2$s" class="small-text" style="width:7em">', esc_attr( $clau ), esc_attr( $valor ) );
				break;
			case 'imatge':
				printf( '<input type="text" id="%1$s" name="%1$s" value="%2$s" class="large-text"> ', esc_attr( $clau ), esc_attr( $valor ) );
				printf( '<p><button type="button" class="button kt-tria-imatge" data-camp="%s">Tria o puja una imatge</button></p>', esc_attr( $clau ) );
				if ( $valor ) {
					printf( '<p><img src="%s" alt="" style="max-width:220px;max-height:160px;border-radius:6px"></p>', esc_url( kt_src( $valor ) ) );
				}
				break;
			default:
				printf( '<input type="%3$s" id="%1$s" name="%1$s" value="%2$s" class="large-text">', esc_attr( $clau ), esc_attr( $valor ), 'url' === $c['tipus'] ? 'url' : 'text' );
		}
		if ( ! empty( $c['ajuda'] ) ) {
			echo '<p class="description">' . esc_html( $c['ajuda'] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

add_action( 'save_post', function ( $post_id, $post ) {
	$def = kt_definicio_camps();
	if ( empty( $def[ $post->post_type ] ) || empty( $_POST['kt_camps_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['kt_camps_nonce'] ) ), 'kt_camps' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( $def[ $post->post_type ]['camps'] as $clau => $c ) {
		$valor = isset( $_POST[ $clau ] ) ? wp_unslash( $_POST[ $clau ] ) : '';
		switch ( $c['tipus'] ) {
			case 'casella':
				$valor = $valor ? '1' : '';
				break;
			case 'textarea':
				$valor = sanitize_textarea_field( $valor );
				break;
			case 'url':
				$valor = esc_url_raw( trim( $valor ) );
				break;
			case 'imatge':
				$valor = trim( $valor );
				$valor = preg_match( '#^https?://#', $valor ) ? esc_url_raw( $valor ) : sanitize_text_field( $valor );
				break;
			case 'nombre':
				$valor = '' === trim( $valor ) ? '' : (string) absint( $valor );
				break;
			default:
				$valor = sanitize_text_field( $valor );
		}
		if ( '' === $valor ) {
			delete_post_meta( $post_id, $clau );
		} else {
			update_post_meta( $post_id, $clau, $valor );
		}
	}
}, 10, 2 );

/* Botó «Tria o puja una imatge» amb la biblioteca de mitjans. */
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_script( 'media-editor', <<<'JS'
jQuery(function ($) {
	$(document).on('click', '.kt-tria-imatge', function (e) {
		e.preventDefault();
		var camp = $('#' + $(this).data('camp'));
		var finestra = wp.media({ title: 'Tria una imatge', button: { text: 'Fes servir aquesta imatge' }, library: { type: 'image' }, multiple: false });
		finestra.on('select', function () {
			camp.val(finestra.state().get('selection').first().toJSON().url).trigger('change');
		});
		finestra.open();
	});
});
JS
	);
} );

/* Columnes útils a les llistes del tauler. */
foreach ( array( 'kt_document', 'kt_video', 'kt_minikt' ) as $kt_tipus ) {
	add_filter( "manage_{$kt_tipus}_posts_columns", function ( $cols ) use ( $kt_tipus ) {
		$nou = array();
		foreach ( $cols as $k => $v ) {
			$nou[ $k ] = $v;
			if ( 'title' === $k ) {
				if ( 'kt_document' === $kt_tipus ) {
					$nou['kt_seccio'] = 'On surt';
				}
				$nou['kt_any'] = 'Any';
			}
		}
		unset( $nou['date'] );
		return $nou;
	} );
	add_action( "manage_{$kt_tipus}_posts_custom_column", function ( $col, $id ) {
		if ( 'kt_any' === $col ) {
			echo esc_html( get_post_meta( $id, 'kt_any', true ) );
		} elseif ( 'kt_seccio' === $col ) {
			echo 'dossier' === get_post_meta( $id, 'kt_seccio', true ) ? 'Dossiers de cada any' : 'Documents útils';
		}
	}, 10, 2 );
}
