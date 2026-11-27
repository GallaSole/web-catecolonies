<?php
/**
 * KT Fotos. Cada vídeo és al menú «Vídeos KT Fotos» del tauler; el de l'any més recent surt en gran.
 * L'avís «Pròximament» es canvia a Aparença → Personalitza → Les KT → KT Fotos.
 */
get_header();

$kt_videos = kt_videos();
$kt_gran   = $kt_videos ? array_shift( $kt_videos ) : null;
?>

  <main>
    <section class="cap-pagina cap-pagina--kt-fotos">
      <div class="contenidor">
        <div class="molla"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inici</a> / KT Fotos</div>
        <h1>KT Fotos</h1>
        <p class="intro">Cada tardor ens retrobem per reviure els 10 dies màgics de l'estiu. Aquí tens el recull de vídeos de totes les edicions.</p>
      </div>
    </section>

    <section class="seccio">
      <div class="contenidor">

        <?php if ( kt_opcio( 'proper_mostrar' ) ) : ?>
        <!-- PRÒXIM VÍDEO -->
        <div class="video-proper">
          <div class="video-proper__any"><?php echo esc_html( kt_opcio( 'proper_any' ) ); ?></div>
          <div>
            <span class="etiqueta">Pròximament</span>
            <h2><?php echo esc_html( kt_opcio( 'proper_titol' ) ); ?></h2>
          </div>
        </div>
        <?php endif; ?>

        <?php if ( $kt_gran ) : list( $kt_font, $kt_id ) = kt_video_id( kt_camp( 'kt_enllac', $kt_gran ) ); $kt_any = kt_camp( 'kt_any', $kt_gran ); ?>
        <!-- VÍDEO DESTACAT (el de l'any més recent) -->
        <div class="capcalera-seccio"<?php echo kt_opcio( 'proper_mostrar' ) ? ' style="margin-top: 70px;"' : ''; ?>>
          <span class="etiqueta">L'últim vídeo</span>
          <h2><?php echo esc_html( get_the_title( $kt_gran ) ); ?></h2>
        </div>
        <div class="video video--gran" data-video-<?php echo 'drive' === $kt_font ? 'drive' : 'youtube'; ?>="<?php echo esc_attr( $kt_id ); ?>">
          <button class="video__portada video__portada--color" aria-label="Reprodueix el vídeo de les <?php echo esc_attr( get_the_title( $kt_gran ) ); ?>">
            <span class="video__any-gran"><?php echo esc_html( $kt_any ); ?></span>
            <span class="video__play" aria-hidden="true"></span>
          </button>
        </div>
        <?php endif; ?>

        <?php if ( $kt_videos ) : ?>
        <!-- ARXIU -->
        <div class="capcalera-seccio" style="margin-top: 80px;">
          <span class="etiqueta">Arxiu</span>
          <h2>Tots els vídeos</h2>
          <p class="intro">Tria un any i torna a viure aquell estiu.</p>
        </div>
        <div class="videos">
          <?php foreach ( $kt_videos as $kt_v ) : list( $kt_font, $kt_id ) = kt_video_id( kt_camp( 'kt_enllac', $kt_v ) ); $kt_any = kt_camp( 'kt_any', $kt_v ); $kt_enllac = kt_camp( 'kt_enllac', $kt_v ); ?>
          <article class="video-targeta">
            <div class="video" data-video-<?php echo 'drive' === $kt_font ? 'drive' : 'youtube'; ?>="<?php echo esc_attr( $kt_id ); ?>">
              <?php if ( 'youtube' === $kt_font ) : ?>
              <button class="video__portada" aria-label="Reprodueix el vídeo de les KT Fotos <?php echo esc_attr( $kt_any ); ?>">
                <img src="<?php echo esc_url( 'https://img.youtube.com/vi/' . $kt_id . '/hqdefault.jpg' ); ?>" alt="" loading="lazy">
                <span class="video__play" aria-hidden="true"></span>
              </button>
              <?php else : ?>
              <button class="video__portada video__portada--color" aria-label="Reprodueix el vídeo de les KT Fotos <?php echo esc_attr( $kt_any ); ?>">
                <span class="video__any-gran"><?php echo esc_html( $kt_any ); ?></span>
                <span class="video__play" aria-hidden="true"></span>
              </button>
              <?php endif; ?>
            </div>
            <div class="video-targeta__peu"><b><?php echo esc_html( $kt_any ); ?></b><a href="<?php echo esc_url( $kt_enllac ); ?>" target="_blank" rel="noopener"><?php echo 'youtube' === $kt_font ? 'Obre a YouTube ↗' : 'Obre el vídeo ↗'; ?></a></div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
  </main>

<?php
get_footer();
