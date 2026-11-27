<?php
/**
 * Preguntes freqüents. Cada pregunta és al menú «Preguntes freqüents» del tauler;
 * els botons de filtre són els «Temes».
 */
get_header();

$kt_correu = kt_opcio( 'correu' );
?>

  <main>
    <section class="cap-pagina cap-pagina--faq">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / FAQ</div>
        <h1>Preguntes freqüents</h1>
        <p class="intro">Els dubtes més habituals de les famílies. Si no hi trobes la resposta, escriu-nos a <a href="mailto:<?php echo esc_attr( $kt_correu ); ?>" style="color: var(--groc);"><?php echo esc_html( $kt_correu ); ?></a>.</p>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor" style="max-width: 860px;">
        <input class="cercador" type="search" placeholder="🔍  Cerca una pregunta (p. ex. «mòbil», «preu», «ràdio»)">
        <?php $kt_temes = kt_temes_faq(); ?>
        <?php if ( $kt_temes ) : ?>
        <div class="faq-filtres">
          <button class="actiu" data-cat="totes">Totes</button>
          <?php foreach ( $kt_temes as $kt_t ) : ?>
          <button data-cat="<?php echo esc_attr( $kt_t->slug ); ?>"><?php echo esc_html( $kt_t->name ); ?></button>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="faq">
          <?php
          foreach ( kt_preguntes() as $kt_p ) :
            $kt_tema = get_the_terms( $kt_p, 'kt_tema' );
            $kt_cat  = $kt_tema && ! is_wp_error( $kt_tema ) ? $kt_tema[0]->slug : '';
          ?>
          <details data-cat="<?php echo esc_attr( $kt_cat ); ?>">
            <summary><?php echo esc_html( get_the_title( $kt_p ) ); ?></summary>
            <div><?php echo apply_filters( 'the_content', $kt_p->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
          </details>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();
