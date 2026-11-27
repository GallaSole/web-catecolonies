<?php
/**
 * Pàgina nova qualsevol (les que es creïn des del tauler a Pàgines → Afegeix).
 */
get_header();
while ( have_posts() ) :
	the_post();
?>

  <main>
    <section class="cap-pagina cap-pagina--noticies">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / <?php the_title(); ?></div>
        <h1><?php the_title(); ?></h1>
        <?php if ( has_excerpt() ) : ?>
        <p class="intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
        <?php endif; ?>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor contingut-lliure">
        <?php the_content(); ?>
      </div>
    </section>
  </main>

<?php
endwhile;
get_footer();
