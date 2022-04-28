<?php
/**
* Plugin Name: Instituciones imágenes
* Plugin URI: https://www.facebook.com/jesusMFC
* Description: Manejar imágenes de instituciones
* Version: 1.0.0
* Author: Jesus Fuentes
* Author URI: https://www.facebook.com/jesusMFC
*
* Text Domain: wpplugin
* Domain path: /
*/

//Generar HTML
include 'activation/create_image_institution_country_table.php';
include 'query/sql-intuciones-pais.php';
include 'display/table.php';


register_activation_hook( __FILE__, 'create_image_institution_country_table' );

function ok(){

}

add_action('init', 'ok');




