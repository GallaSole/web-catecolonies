<?php
/**
 * Tema de les Catecolònies.
 *
 * inc/setup.php        Configuració del tema, estils, menús i funcions d'ajuda.
 * inc/continguts.php   Tipus de contingut: preguntes, documents, vídeos i Mini-KT.
 * inc/camps.php        Camps extra de les notícies i dels altres continguts.
 * inc/opcions.php      Opcions de la web (Aparença → Personalitza → Les KT).
 * inc/ajuda.php        Guia ràpida al tauler i noms dels menús en català.
 * inc/importador.php   Omple la web amb el contingut actual la primera vegada.
 */

defined( 'ABSPATH' ) || exit;

define( 'KT_VERSIO', '1.0.0' );

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/continguts.php';
require_once get_template_directory() . '/inc/camps.php';
require_once get_template_directory() . '/inc/opcions.php';
require_once get_template_directory() . '/inc/ajuda.php';
require_once get_template_directory() . '/inc/importador.php';
