<?php
/**
 * Pàgina de Notícies. Cada notícia és una «Entrada» del tauler (menú Notícies).
 * Quan cliques una targeta, la notícia s'obre en gran (js/main.js).
 */
get_header();

$kt_pagina = get_option( 'page_for_posts' );
$kt_intro  = $kt_pagina && has_excerpt( $kt_pagina ) ? get_the_excerpt( $kt_pagina ) : 'Avisos, novetats i cròniques de les KT.';
?>

  <main>
    <section class="cap-pagina cap-pagina--noticies">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / Notícies</div>
        <h1>Notícies</h1>
        <p class="intro"><?php echo esc_html( $kt_intro ); ?></p>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor">
        <div class="graella-3 noticies">
          <?php
          while ( have_posts() ) :
            the_post();
            $kt_im   = kt_imatge_noticia();
            $kt_xip  = kt_xip_noticia();
            $kt_boto = kt_camp( 'kt_text_boto' ) ? kt_camp( 'kt_text_boto' ) : 'Llegeix-la sencera →';
          ?>
          <article class="targeta" id="<?php echo esc_attr( get_post_field( 'post_name' ) ); ?>"<?php echo $kt_im['gran'] ? ' data-imatge-gran="' . esc_url( $kt_im['gran'] ) . '"' : ''; ?>>
            <?php if ( $kt_im['src'] ) : ?>
            <img class="targeta__imatge<?php echo $kt_im['logo'] ? ' targeta__imatge--logo' : ''; ?>" src="<?php echo esc_url( $kt_im['src'] ); ?>" alt="<?php echo esc_attr( $kt_im['alt'] ); ?>">
            <?php endif; ?>
            <div class="targeta__cos">
              <?php if ( $kt_xip ) : ?>
              <div><span class="xip"><?php echo esc_html( $kt_xip ); ?></span></div>
              <?php endif; ?>
              <div class="targeta__data"><?php echo esc_html( kt_data() ); ?></div>
              <h3><?php the_title(); ?></h3>
              <p><?php echo wp_kses_post( kt_resum_noticia() ); ?></p>
              <button class="targeta__llegeix" type="button"><?php echo esc_html( $kt_boto ); ?></button>
            </div>
            <div class="noticia-completa" hidden>
              <?php the_content(); ?>
            </div>
          </article>
          <?php endwhile; ?>
        </div>
        <?php if ( ! have_posts() ) : ?>
        <p class="intro">Encara no hi ha cap notícia.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- ===== LECTOR DE NOTÍCIES: aquí s'obre la notícia en gran ===== -->
  <dialog class="lector" aria-labelledby="lector-titol">
    <button class="lector__tanca" type="button" aria-label="Tanca la notícia">✕</button>
    <div class="lector__portada"></div>
    <div class="lector__cos">
      <div class="lector__meta"></div>
      <h2 id="lector-titol"></h2>
      <div class="lector__text"></div>
      <?php if ( kt_opcio( 'blog_antic' ) ) : ?>
      <a class="lector__blog" href="<?php echo esc_url( kt_opcio( 'blog_antic' ) ); ?>" target="_blank" rel="noopener">Notícies anteriors al blog antic →</a>
      <?php endif; ?>
    </div>
  </dialog>

<?php
get_footer();
