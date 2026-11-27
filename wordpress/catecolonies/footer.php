
  <!-- ===== PEU DE PÀGINA ===== -->
  <!-- Silueta de les serres del Corredor i Montalt -->
  <svg class="serralada" viewBox="0 0 1440 90" preserveAspectRatio="none" aria-hidden="true">
    <path fill="#1d5480" d="M0 90 L0 55 L120 30 L220 48 L340 12 L460 44 L560 26 L680 50 L800 18 L930 46 L1040 28 L1160 52 L1280 22 L1440 46 L1440 90 Z"/>
    <path fill="#0b2740" d="M0 90 L0 70 L160 50 L300 66 L420 44 L560 68 L720 46 L860 70 L1000 52 L1140 72 L1300 50 L1440 66 L1440 90 Z"/>
  </svg>
  <footer class="peu">
    <div class="contenidor">
      <div class="peu__graella">
        <div>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="Catecolònies – Inici">
            <img class="logo__img" src="<?php echo esc_url( kt_img( 'logo-blanc.png' ) ); ?>" alt="Catecolònies Sant Martí d'Arenys de Munt">
          </a>
        </div>
        <div>
          <h4>La web</h4>
          <ul>
            <?php kt_menu_peu(); ?>
          </ul>
        </div>
        <div>
          <h4>Contacte</h4>
          <ul>
            <?php if ( kt_opcio( 'correu' ) ) : ?>
            <li><a href="mailto:<?php echo esc_attr( kt_opcio( 'correu' ) ); ?>"><?php echo esc_html( kt_opcio( 'correu' ) ); ?></a></li>
            <?php endif; ?>
            <?php if ( kt_opcio( 'instagram' ) ) : ?>
            <li><a href="<?php echo esc_url( 'https://www.instagram.com/' . kt_opcio( 'instagram' ) . '/' ); ?>" target="_blank" rel="noopener">Instagram @<?php echo esc_html( kt_opcio( 'instagram' ) ); ?></a></li>
            <?php endif; ?>
            <?php if ( kt_opcio( 'blog_antic' ) ) : ?>
            <li><a href="<?php echo esc_url( kt_opcio( 'blog_antic' ) ); ?>" target="_blank" rel="noopener">Blog antic</a></li>
            <?php endif; ?>
          </ul>
        </div>
        <div>
          <h4>Amb el suport de</h4>
          <div class="suport">
            <a class="suport__logo" href="https://www.arenysdemunt.cat" target="_blank" rel="noopener"><img src="<?php echo esc_url( kt_img( 'logo-ajuntament-arenys.png' ) ); ?>" alt="Ajuntament d'Arenys de Munt"></a>
            <span class="suport__logo"><img src="<?php echo esc_url( kt_img( 'logo-fundacio-esplai-girona.png' ) ); ?>" alt="Fundació Esplai Girona – Mare de Déu del Mont"></span>
          </div>
        </div>
      </div>
      <div class="peu__final">
        <span>© <span data-any-actual><?php echo esc_html( wp_date( 'Y' ) ); ?></span> C.E. Catecolònies Sant Martí</span>
      </div>
    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>
