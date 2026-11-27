<?php
/**
 * Plantilla de reserva (WordPress la necessita). Les pàgines de la web fan servir les seves pròpies.
 */
get_header();
?>

  <main>
    <section class="cap-pagina cap-pagina--noticies">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a></div>
        <h1><?php echo esc_html( is_search() ? 'Resultats de la cerca' : wp_get_document_title() ); ?></h1>
      </div>
    </section>
    <section class="seccio">
      <div class="contenidor contingut-lliure">
        <?php if ( have_posts() ) : ?>
          <ul>
          <?php while ( have_posts() ) : the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; ?>
          </ul>
        <?php else : ?>
          <p>No hi ha res per mostrar.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

<?php
get_footer();
