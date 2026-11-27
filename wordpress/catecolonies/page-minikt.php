<?php
/**
 * Mini-KT. Cada Mini-KT és al menú «Mini-KT» del tauler. La de l'any més recent surt amb totes
 * les dades; les altres surten a la llista d'anteriors.
 */
get_header();

$kt_totes  = kt_minikts();
$kt_ultima = $kt_totes ? array_shift( $kt_totes ) : null;
$kt_medic  = kt_opcio( 'enllac_medicaments' );

/** Etiquetes de torn d'una Mini-KT. */
function kt_xips_minikt( $post ) {
	$out = array();
	foreach ( array_filter( array_map( 'trim', explode( ',', (string) kt_camp( 'kt_torns', $post ) ) ) ) as $t ) {
		$out[] = '<span class="xip">' . esc_html( $t ) . '</span>';
	}
	return implode( ' ', $out );
}
?>

  <main>
    <section class="cap-pagina cap-pagina--minikt">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / Mini-KT</div>
        <h1>Mini-KT</h1>
        <p class="intro">Una escapada curta durant el curs per retrobar-nos amb els monitors i fer més curta l'espera fins a l'agost.</p>
      </div>
    </section>

    <!-- QUÈ SÓN -->
    <section class="seccio">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">Què són?</span>
          <p class="intro">Alguns anys, els monitors d'un torn organitzen pel seu compte les Mini-KT: una sortida curta, normalment per Setmana Santa o a la primavera, perquè infants i monitors no perdin el vincle durant l'any.</p>
        </div>

        <div class="comparativa">
          <div class="comparativa__col">
            <span class="comparativa__nom">Catecolònies</span>
            <dl>
              <div><dt>Quan</dt><dd>De l'1 al 10 d'agost, cada any</dd></div>
              <div><dt>Qui</dt><dd>Els quatre torns alhora</dd></div>
              <div><dt>Durada</dt><dd>10 dies</dd></div>
              <div><dt>Inscripció</dt><dd>Preinscripció al febrer-març i inscripció al maig-juny</dd></div>
            </dl>
          </div>
          <div class="comparativa__col comparativa__col--mini">
            <span class="comparativa__nom">Mini-KT</span>
            <dl>
              <div><dt>Quan</dt><dd>Alguns anys, normalment per Setmana Santa</dd></div>
              <div><dt>Qui</dt><dd>Un sol torn, que l'organitza pel seu compte</dd></div>
              <div><dt>Durada</dt><dd>1 o 2 dies (sortida, ruta o una nit fora)</dd></div>
              <div><dt>Inscripció</dt><dd>Pròpia i a part, amb el seu preu i el seu full</dd></div>
            </dl>
          </div>
        </div>
        <p class="nota">No cada any hi ha Mini-KT ni la fa sempre el mateix torn. Quan n'hi ha, ho anunciem en aquesta pàgina i a Instagram.</p>
      </div>
    </section>

    <?php if ( $kt_ultima ) : ?>
    <!-- ÚLTIMA MINI-KT -->
    <section class="seccio seccio--blanca">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">L'última Mini-KT</span>
          <h2><?php echo esc_html( trim( 'Mini-KT ' . kt_camp( 'kt_torns', $kt_ultima ) ) . ' · ' . kt_camp( 'kt_any', $kt_ultima ) ); ?></h2>
        </div>

        <div class="minikt">
          <?php if ( kt_camp( 'kt_cartell', $kt_ultima ) ) : ?>
          <img class="minikt__cartell" src="<?php echo esc_url( kt_src( kt_camp( 'kt_cartell', $kt_ultima ) ) ); ?>" alt="Cartell de la <?php echo esc_attr( get_the_title( $kt_ultima ) . ' ' . kt_camp( 'kt_any', $kt_ultima ) ); ?>">
          <?php endif; ?>
          <div>
            <div class="minikt__dades">
              <?php
              $kt_dades = array(
                array( 'Dates', kt_camp( 'kt_dates', $kt_ultima ), '' ),
                array( 'Preu', kt_camp( 'kt_preu', $kt_ultima ), '' ),
                array( 'Trobada', kt_camp( 'kt_trobada', $kt_ultima ), kt_camp( 'kt_trobada_lloc', $kt_ultima ) ),
                array( 'Inscripcions', kt_camp( 'kt_inscripcions', $kt_ultima ), kt_camp( 'kt_inscripcions_lloc', $kt_ultima ) ),
              );
              foreach ( $kt_dades as $kt_d ) :
                if ( ! $kt_d[1] ) {
                  continue;
                }
              ?>
              <div><span><?php echo esc_html( $kt_d[0] ); ?></span><b><?php echo esc_html( $kt_d[1] ); ?></b><?php echo $kt_d[2] ? '<small>' . esc_html( $kt_d[2] ) . '</small>' : ''; ?></div>
              <?php endforeach; ?>
            </div>

            <?php $kt_insc = kt_linies( kt_camp( 'kt_per_inscriure', $kt_ultima ) ); $kt_portar = kt_linies( kt_camp( 'kt_que_portar', $kt_ultima ) ); ?>
            <?php if ( $kt_insc || $kt_portar ) : ?>
            <div class="dues-col minikt__llistes">
              <?php if ( $kt_insc ) : ?>
              <div>
                <h3>Per inscriure's</h3>
                <ul class="llista-check">
                  <?php foreach ( $kt_insc as $kt_l ) : ?>
                  <li><?php echo esc_html( $kt_l ); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
              <?php if ( $kt_portar ) : ?>
              <div>
                <h3>Què s'ha de portar?</h3>
                <ul class="minikt__motxilla">
                  <?php foreach ( $kt_portar as $kt_l ) : ?>
                  <li><?php echo esc_html( $kt_l ); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <?php endif; ?>
            </div>
            <?php endif; ?>
            <p class="pas__destacat minikt__avis">Si l'infant pren algun medicament, el dia de la sortida s'ha de portar el medicament i l'<a href="<?php echo esc_url( $kt_medic ); ?>" target="_blank" rel="noopener">Autorització de medicaments</a>.</p>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php if ( $kt_totes ) : ?>
    <!-- MINI-KT ANTERIORS -->
    <section class="seccio">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <h2>Mini-KT anteriors</h2>
        </div>
        <div class="linia-mini">
          <?php foreach ( $kt_totes as $kt_m ) : ?>
          <article class="fita-mini">
            <div class="fita-mini__any"><?php echo esc_html( kt_camp( 'kt_any', $kt_m ) ); ?></div>
            <div class="fita-mini__cos">
              <?php echo kt_xips_minikt( $kt_m ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
              <h3><?php echo esc_html( get_the_title( $kt_m ) ); ?></h3>
              <?php if ( kt_camp( 'kt_resum', $kt_m ) ) : ?>
              <p><?php echo esc_html( kt_camp( 'kt_resum', $kt_m ) ); ?></p>
              <?php endif; ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </main>

<?php
get_footer();
