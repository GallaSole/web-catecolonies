<?php
/**
 * Caixa «No et perdis cap avís» amb els canals de contacte.
 * $args: titol, text, radio (bool).
 */
$args = wp_parse_args( $args ?? array(), array(
	'titol' => 'No et perdis cap avís',
	'text'  => 'Instagram és el canal més ràpid per saber quan s\'obren les preinscripcions, recordatoris i novetats durant les colònies.',
	'radio' => true,
) );
$kt_insta  = kt_opcio( 'instagram' );
$kt_correu = kt_opcio( 'correu' );
?>
<section class="seccio">
  <div class="contenidor">
    <div class="segueix">
      <div>
        <h2><?php echo esc_html( $args['titol'] ); ?></h2>
        <p><?php echo esc_html( $args['text'] ); ?></p>
      </div>
      <div class="segueix__canals">
        <?php if ( $kt_insta ) : ?>
        <a class="canal" href="<?php echo esc_url( 'https://www.instagram.com/' . $kt_insta . '/' ); ?>" target="_blank" rel="noopener"><span class="canal__icona">📸</span><span>@<?php echo esc_html( $kt_insta ); ?><small>Instagram</small></span></a>
        <?php endif; ?>
        <?php if ( $kt_correu ) : ?>
        <a class="canal" href="mailto:<?php echo esc_attr( $kt_correu ); ?>"><span class="canal__icona">✉️</span><span><?php echo esc_html( $kt_correu ); ?><small>Correu electrònic</small></span></a>
        <?php endif; ?>
        <?php if ( $args['radio'] ) : ?>
        <a class="canal" href="https://www.radioarenysmunt.cat" target="_blank" rel="noopener"><span class="canal__icona">📻</span><span>Ràdio Arenys de Munt<small>107 FM · durant les colònies</small></span></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
