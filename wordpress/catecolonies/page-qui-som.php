<?php
/**
 * Pàgina «Qui som i d'on venim».
 */
get_header();
?>

  <main>
<?php
$kt_html = file_get_contents( __DIR__ . '/template-parts/qui-som.html' );
echo kt_html_estatic( $kt_html ); // phpcs:ignore WordPress.Security.EscapeOutput
?>
  </main>

<?php
get_footer();
