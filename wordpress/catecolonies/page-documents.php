<?php
/**
 * Documents. Cada document és al menú «Documents» del tauler.
 */
get_header();

$kt_utils    = kt_documents( 'util' );
$kt_dossiers = kt_documents( 'dossier' );
?>

  <main>
    <section class="cap-pagina cap-pagina--documents">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / Documents</div>
        <h1>Documents</h1>
        <p class="intro">Fitxes, normativa i els dossiers de les colònies, des del 2022 fins avui.</p>
      </div>
    </section>

    <?php if ( $kt_utils ) : ?>
    <section class="seccio">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">Per a les famílies</span>
          <h2>Documents útils</h2>
        </div>
        <div class="graella-3">
          <?php foreach ( $kt_utils as $kt_d ) : ?>
          <a class="caixa" style="text-decoration:none; color:inherit;" href="<?php echo esc_url( kt_camp( 'kt_enllac', $kt_d ) ); ?>" target="_blank" rel="noopener">
            <h3><?php echo esc_html( trim( kt_camp( 'kt_icona', $kt_d ) . ' ' . get_the_title( $kt_d ) ) ); ?></h3>
            <?php if ( kt_camp( 'kt_descripcio', $kt_d ) ) : ?>
            <p style="margin:0"><?php echo esc_html( kt_camp( 'kt_descripcio', $kt_d ) ); ?></p>
            <?php endif; ?>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( $kt_dossiers ) : ?>
    <section class="seccio seccio--blanca">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">Arxiu</span>
          <h2>Dossiers de cada any</h2>
          <p class="intro">Cada dossier recull els horaris, els contactes, les activitats, els menús i la llista del que cal portar.</p>
        </div>
        <div class="docs">
          <?php foreach ( $kt_dossiers as $kt_i => $kt_d ) : ?>
          <a class="doc<?php echo 0 === $kt_i ? ' doc--nou' : ''; ?>" href="<?php echo esc_url( kt_camp( 'kt_enllac', $kt_d ) ); ?>" target="_blank" rel="noopener"><b><?php echo esc_html( kt_camp( 'kt_any', $kt_d ) ); ?></b><span><?php echo esc_html( get_the_title( $kt_d ) . ( 0 === $kt_i ? ' · el més recent' : '' ) ); ?></span></a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php
    get_template_part( 'template-parts/segueix', null, array(
      'titol' => 'Com estar al dia',
      'text'  => 'Instagram té els avisos més freqüents. Per correu enviem només el més important. Per a qualsevol dubte, escriu-nos!',
      'radio' => false,
    ) );
    ?>
  </main>

<?php
get_footer();
