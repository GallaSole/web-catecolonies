<?php
/**
 * Una notícia sola. Normalment s'obre dins de la pàgina de Notícies; aquesta plantilla només es fa
 * servir per a la vista prèvia mentre s'escriu.
 */
get_header();
while ( have_posts() ) :
	the_post();
	$kt_im  = kt_imatge_noticia();
	$kt_xip = kt_xip_noticia();
?>

  <main>
    <section class="cap-pagina cap-pagina--noticies">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / <a href="<?php echo esc_url( kt_url( 'noticies' ) ); ?>">Notícies</a></div>
        <h1><?php the_title(); ?></h1>
        <p class="intro"><?php echo esc_html( ( $kt_xip ? $kt_xip . ' · ' : '' ) . kt_data() ); ?></p>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor contingut-lliure lector__text">
        <?php if ( $kt_im['src'] ) : ?>
        <p><img class="imatge-arrodonida" src="<?php echo esc_url( $kt_im['gran'] ? $kt_im['gran'] : $kt_im['src'] ); ?>" alt="<?php echo esc_attr( $kt_im['alt'] ); ?>"></p>
        <?php endif; ?>
        <?php the_content(); ?>
      </div>
    </section>
  </main>

<?php
endwhile;
get_footer();
