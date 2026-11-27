<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- ===== CAPÇALERA ===== -->
  <header class="capcalera">
    <div class="contenidor">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="Catecolònies Sant Martí d'Arenys de Munt – Inici">
        <img class="logo__img" src="<?php echo esc_url( kt_img( 'logo.png' ) ); ?>" alt="Catecolònies Sant Martí d'Arenys de Munt">
      </a>
      <?php $kt_insta = kt_opcio( 'instagram' ); ?>
      <?php if ( $kt_insta ) : ?>
      <a class="insta" href="<?php echo esc_url( 'https://www.instagram.com/' . $kt_insta . '/' ); ?>" target="_blank" rel="noopener" aria-label="Instagram de les Catecolònies (@<?php echo esc_attr( $kt_insta ); ?>)">
        <svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.3" cy="6.7" r="1.2" fill="currentColor"/></svg>
      </a>
      <?php endif; ?>
      <button class="boto-menu" aria-label="Obrir el menú" aria-expanded="false"><span></span><span></span><span></span></button>
      <nav class="menu">
        <?php kt_menu_principal(); ?>
      </nav>
    </div>
  </header>
