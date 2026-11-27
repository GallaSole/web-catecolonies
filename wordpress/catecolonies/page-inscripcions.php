<?php
/**
 * Pàgina d'Inscripcions. Els preus, l'IBAN, el cartell i els enllaços es canvien a
 * Aparença → Personalitza → Les KT → Inscripcions i preus.
 */
get_header();

$kt_senyal  = (float) kt_opcio( 'paga_senyal' );
$kt_preu    = (float) kt_opcio( 'preu_infant' );
$kt_germans = (float) kt_opcio( 'preu_germans' );
$kt_fitxa   = kt_opcio( 'enllac_fitxa' );
$kt_medic   = kt_opcio( 'enllac_medicaments' );
$kt_cartell = kt_opcio( 'cartell_inscripcions' );
?>

  <main>
    <section class="cap-pagina cap-pagina--inscripcions">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / Inscripcions</div>
        <h1>Inscripcions</h1>
        <p class="intro">Tot el que cal saber per venir de colònies!</p>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">El procés</span>
          <h2>Quatre passos fins a l'1 d'agost</h2>
        </div>
        <div class="passos">
          <div class="pas">
            <h3>Preinscripció</h3>
            <p>Entre febrer i març, omplir el formulari. Hi poses les dades de l'infant i el comprovant de pagament de <?php echo esc_html( kt_euros( $kt_senyal ) ); ?>.</p>
          </div>
          <div class="pas">
            <h3>Inscripció</h3>
            <p>Entre finals de maig i principis de juny, al Centre Moral. Entregues la fitxa, els documents necessaris i el comprovant del pagament complet.</p>
            <p class="pas__destacat">IMPORT A PAGAR: <b>TOTAL - <?php echo esc_html( kt_euros( $kt_senyal ) ); ?></b> de la preinscripció</p>
          </div>
          <div class="pas">
            <h3>Reunió i visita</h3>
            <p>Reunió informativa per a famílies al Centre Moral i, abans de l'estiu, depenent del torn, el monitor us visita a casa.</p>
          </div>
          <div class="pas">
            <h3>Dossier</h3>
            <p>A mitjans de juliol publiquem el dossier amb horaris, activitats, menús i la llista del que cal portar.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="seccio seccio--blanca">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <h2>Preus</h2>
          <p class="intro">Preus de l'última edició. Poden canviar lleugerament cada any.</p>
        </div>
        <div class="preus preus--2">
          <div class="preu preu--destacat">
            <h3>1 infant</h3>
            <div class="preu__xifra"><?php echo esc_html( kt_euros( $kt_preu ) ); ?></div>
            <ul class="preu__llista">
              <li>S'han de pagar <b><?php echo esc_html( kt_euros( $kt_senyal ) ); ?></b> en fer la preinscripció (entre febrer i març).</li>
              <li>S'han de pagar <b><?php echo esc_html( kt_euros( $kt_preu - $kt_senyal ) ); ?></b> en fer la inscripció (entre maig i juny).</li>
            </ul>
          </div>
          <div class="preu preu--germans">
            <h3>Germans</h3>
            <div class="preu__xifra"><?php echo esc_html( kt_euros( $kt_germans ) ); ?></div>
            <p>Per infant, quan s'hi inscriuen dos o més germans.</p>
            <ul class="preu__llista" style="margin-top: 10px;">
              <li>S'han de pagar <b><?php echo esc_html( kt_euros( $kt_senyal ) ); ?></b> en fer la preinscripció (entre febrer i març).</li>
              <li>S'han de pagar <b><?php echo esc_html( kt_euros( $kt_germans - $kt_senyal ) ); ?></b> en fer la inscripció (entre maig i juny).</li>
            </ul>
          </div>
        </div>

        <div class="dues-col" style="margin-top: 40px; align-items: start;">
          <div class="caixa">
            <h3>💳 Com es paga?</h3>
            <p>Per transferència, <b>un pagament per participant</b>. Al concepte hi has de posar el nom de l'infant i el torn.</p>
            <p style="margin:0">IBAN: <span class="codi"><?php echo esc_html( kt_opcio( 'iban' ) ); ?></span></p>
          </div>
          <div class="caixa">
            <h3>↩️ Devolucions</h3>
            <p style="margin:0">Si un infant no pot venir, es retorna l'import pagat excepte els <?php echo esc_html( kt_euros( $kt_senyal ) ); ?> de la preinscripció. Cal demanar-ho com a mínim abans de <?php echo esc_html( kt_opcio( 'data_devolucio' ) ); ?>.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor dues-col" style="align-items: start;">
        <div>
          <span class="etiqueta">Documentació</span>
          <h2>Què cal portar el dia de la inscripció?</h2>
          <ul class="llista-check">
            <li>Fitxa d'inscripció omplerta</li>
            <li>Comprovant de la transferència (un per participant)</li>
            <li>Fotocòpia del DNI de l'infant (o del llibre de família si no en té)</li>
            <li>Fotocòpia de la targeta sanitària</li>
            <li>Fotocòpia del carnet de vacunes (o declaració signada de no vacunació)</li>
            <li>Acceptació de la normativa interna (el full es troba al final del document de Fitxa d'inscripció)</li>
          </ul>
          <div class="hero__botons">
            <?php if ( $kt_fitxa ) : ?>
            <a href="<?php echo esc_url( $kt_fitxa ); ?>" target="_blank" rel="noopener" class="boto boto--principal">Fitxa d'inscripció</a>
            <?php endif; ?>
            <?php if ( $kt_medic ) : ?>
            <a href="<?php echo esc_url( $kt_medic ); ?>" target="_blank" rel="noopener" class="boto boto--principal">Autorització de medicaments</a>
            <?php endif; ?>
          </div>
        </div>
        <?php if ( $kt_cartell ) : ?>
        <img class="imatge-arrodonida" src="<?php echo esc_url( $kt_cartell ); ?>" alt="Cartell informatiu de les inscripcions">
        <?php endif; ?>
      </div>
    </section>

    <section class="seccio" style="padding-top: 0;">
      <div class="contenidor">
        <div class="avis">
          <div class="avis__icona">💊</div>
          <div>
            <h3>Medicació</h3>
            <p>En cas que l'infant prengui una medicació específica, s'ha de donar al monitor l'<a href="<?php echo esc_url( $kt_medic ); ?>" target="_blank" rel="noopener" style="color: var(--mari-fosc); font-weight: 700;">Autorització de medicaments</a>.</p>
          </div>
          <a href="<?php echo esc_url( kt_url( 'faq' ) ); ?>" class="boto boto--principal">Més dubtes? FAQ</a>
        </div>
      </div>
    </section>
  </main>

<?php
get_footer();
