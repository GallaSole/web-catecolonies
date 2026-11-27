<?php
/**
 * Pàgina no trobada.
 */
get_header();
?>

  <main>
    <section class="cap-pagina cap-pagina--noticies">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a></div>
        <h1>Aquesta pàgina no existeix</h1>
        <p class="intro">Potser ha canviat de lloc. Torna a l'inici o mira les últimes notícies.</p>
      </div>
    </section>
    <section class="seccio">
      <div class="contenidor">
        <div class="hero__botons">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="boto boto--principal">Torna a l'inici</a>
          <a href="<?php echo esc_url( kt_url( 'noticies' ) ); ?>" class="boto boto--contorn">Notícies</a>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();
