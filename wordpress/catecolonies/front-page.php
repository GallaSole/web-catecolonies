<?php
/**
 * Portada. Els textos de la capçalera, l'avís i les dates es canvien a Aparença → Personalitza → Les KT.
 * Les últimes notícies surten soles.
 */
get_header();

$kt_hero_img  = kt_opcio( 'hero_imatge' ) ? kt_opcio( 'hero_imatge' ) : kt_img( 'kt-placa-esglesia.jpg' );
$kt_avis_link = kt_opcio( 'avis_boto_enllac' ) ? kt_opcio( 'avis_boto_enllac' ) : kt_url( 'inscripcions' );
?>

  <main>
    <!-- ===== PORTADA ===== -->
    <section class="hero">
      <div class="contenidor">
        <div>
          <span class="etiqueta"><?php echo esc_html( kt_opcio( 'hero_etiqueta' ) ); ?></span>
          <h1><?php echo esc_html( kt_opcio( 'hero_titol' ) ); ?> <span><?php echo esc_html( kt_opcio( 'hero_titol_destacat' ) ); ?></span></h1>
          <p class="intro"><?php echo esc_html( kt_opcio( 'hero_intro' ) ); ?></p>
          <div class="hero__botons">
            <a href="<?php echo esc_url( kt_url( 'inscripcions' ) ); ?>" class="boto boto--principal">Com m'hi apunto? →</a>
            <a href="<?php echo esc_url( kt_url( 'qui-som' ) ); ?>" class="boto boto--contorn">Coneix-nos</a>
          </div>
        </div>
        <div class="hero__imatge">
          <img src="<?php echo esc_url( $kt_hero_img ); ?>" alt="Les Catecolònies a la plaça de l'Església d'Arenys de Munt">
          <div class="adhesiu"><div><small>des de</small><b>1984</b></div></div>
        </div>
      </div>
    </section>

    <!-- ===== COMPTE ENRERE + AVÍS ===== -->
    <section class="seccio" style="padding-top: 0;">
      <div class="contenidor">
        <div class="compte" data-compte data-inici="<?php echo esc_attr( kt_opcio( 'data_sortida' ) . 'T' . kt_opcio( 'hora_sortida' ) ); ?>" data-final="<?php echo esc_attr( kt_opcio( 'data_tornada' ) ); ?>" data-text="<?php echo esc_attr( kt_opcio( 'text_compte' ) ); ?>">
          <div>
            <span class="etiqueta">Compte enrere</span>
            <h2 data-compte-titol>Falten pocs dies per a les KT!</h2>
            <p data-compte-text><?php echo esc_html( kt_opcio( 'text_compte' ) ); ?></p>
          </div>
          <div class="compte__caselles">
            <div class="casella casella--dies"><b data-dies>–</b><span>dies</span></div>
            <div class="casella"><b data-hores>–</b><span>hores</span></div>
            <div class="casella"><b data-minuts>–</b><span>minuts</span></div>
            <div class="casella"><b data-segons>–</b><span>segons</span></div>
          </div>
        </div>

        <?php if ( kt_opcio( 'avis_mostrar' ) ) : ?>
        <div class="avis">
          <div class="avis__icona"><?php echo esc_html( kt_opcio( 'avis_icona' ) ); ?></div>
          <div>
            <h3><?php echo esc_html( kt_opcio( 'avis_titol' ) ); ?></h3>
            <p><?php echo esc_html( kt_opcio( 'avis_text' ) ); ?></p>
          </div>
          <?php if ( kt_opcio( 'avis_boto_text' ) ) : ?>
          <a href="<?php echo esc_url( $kt_avis_link ); ?>" class="boto boto--principal"><?php echo esc_html( kt_opcio( 'avis_boto_text' ) ); ?></a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- ===== TORNS ===== -->
    <section class="seccio seccio--blanca" id="torns">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <span class="etiqueta">Els torns</span>
          <h2>Un torn per a cada edat</h2>
          <p class="intro">Cada torn té la seva casa, el seu equip de monitors i la seva cuina. Comencem a 4t de Primària i arribem fins a 1r de Batxillerat.</p>
        </div>

        <div class="torns">
          <article class="torn">
            <div class="torn__num">1r</div>
            <h3>Primer torn</h3>
            <p>4t i 5è de Primària</p>
          </article>
          <article class="torn">
            <div class="torn__num">2n</div>
            <h3>Segon torn</h3>
            <p>6è de Primària i 1r d'ESO</p>
          </article>
          <article class="torn">
            <div class="torn__num">3r</div>
            <h3>Tercer torn</h3>
            <p>2n i 3r d'ESO</p>
          </article>
          <article class="torn">
            <div class="torn__num">4t</div>
            <h3>Quart torn</h3>
            <p>4t d'ESO i 1r de Batxillerat</p>
          </article>
        </div>
      </div>
    </section>

    <!-- ===== ÚLTIMES NOTÍCIES (surten soles) ===== -->
    <?php
    $kt_ultimes = get_posts( array( 'posts_per_page' => 3, 'post_status' => 'publish' ) );
    if ( $kt_ultimes ) :
    ?>
    <section class="seccio">
      <div class="contenidor">
        <div class="capcalera-seccio" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:20px;">
          <div>
            <span class="etiqueta">Què ha passat</span>
            <h2>Últimes notícies</h2>
          </div>
          <a href="<?php echo esc_url( kt_url( 'noticies' ) ); ?>" class="boto boto--contorn">Totes les notícies</a>
        </div>
        <div class="graella-3">
          <?php foreach ( $kt_ultimes as $kt_n ) : $kt_im = kt_imatge_noticia( $kt_n ); ?>
          <article class="targeta">
            <?php if ( $kt_im['src'] ) : ?>
            <img class="targeta__imatge<?php echo $kt_im['logo'] ? ' targeta__imatge--logo' : ''; ?>" src="<?php echo esc_url( $kt_im['src'] ); ?>" alt="<?php echo esc_attr( $kt_im['alt'] ); ?>">
            <?php endif; ?>
            <div class="targeta__cos">
              <div class="targeta__data"><?php echo esc_html( kt_data( $kt_n ) ); ?></div>
              <h3><?php echo esc_html( get_the_title( $kt_n ) ); ?></h3>
              <p><?php echo wp_kses_post( kt_resum_noticia( $kt_n ) ); ?></p>
              <a href="<?php echo esc_url( kt_url_noticia( $kt_n ) ); ?>" class="targeta__enllac">Llegeix-ne més →</a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ===== CALENDARI DE L'ANY ===== -->
    <section class="seccio seccio--fosca">
      <div class="contenidor">
        <div class="capcalera-seccio">
          <h2>Dates destacades</h2>
        </div>
        <div class="calendari">
          <div class="mes">
            <div class="mes__quan">Febrer – març</div>
            <h3>Preinscripció en línia</h3>
            <p>Dades de l'infant i comprovant de la paga i senyal de <?php echo esc_html( kt_euros( kt_opcio( 'paga_senyal' ) ) ); ?>.</p>
          </div>
          <div class="mes mes--collabora">
            <div class="mes__quan">Principis de maig</div>
            <h3>KT Flors</h3>
            <p>Venda de flors per al Dia de la Mare a la plaça de l'Església.</p>
            <span class="mes__xip">Col·labora amb les KT</span>
          </div>
          <div class="mes">
            <div class="mes__quan">Finals de maig – juny</div>
            <h3>Inscripcions i reunió</h3>
            <p>Al Centre Moral: entrega de documents i reunió informativa per a famílies.</p>
          </div>
          <div class="mes">
            <div class="mes__quan">Mitjans de juliol</div>
            <h3>Dossier de l'any</h3>
            <p>Horaris, contactes, activitats, menús i què cal portar.</p>
          </div>
          <div class="mes mes--destacat">
            <div class="mes__quan">1 – 10 d'agost</div>
            <h3>Catecolònies!</h3>
            <p>Deu dies, quatre torns, quatre cases.</p>
          </div>
          <div class="mes mes--collabora">
            <div class="mes__quan">Tardor</div>
            <h3>KT Fotos</h3>
            <p>Les fotos i diapos de tots els torns, a Arenys de Munt.</p>
            <span class="mes__xip">Col·labora amb les KT</span>
          </div>
          <div class="mes mes--collabora">
            <div class="mes__quan">Per Nadal</div>
            <h3>KT Quina</h3>
            <p>La quina nadalenca de les KT, a la Sala Municipal.</p>
            <span class="mes__xip">Col·labora amb les KT</span>
          </div>
          <div class="mes mes--collabora">
            <div class="mes__quan">Cap d'any</div>
            <h3>Barra de les KT</h3>
            <p>Després de les campanades, la barra de les KT a la plaça de l'Església.</p>
            <span class="mes__xip">Col·labora amb les KT</span>
          </div>
        </div>
        <p class="calendari__nota">Les KT FLORS, les KT FOTOS, la KT QUINA i la BARRA DE CAP D'ANY són activitats per col·laborar amb les colònies: el que s'hi recull ajuda a fer-les possibles.</p>
      </div>
    </section>

    <!-- ===== SEGUEIX-NOS ===== -->
    <?php get_template_part( 'template-parts/segueix' ); ?>
  </main>

<?php
get_footer();
