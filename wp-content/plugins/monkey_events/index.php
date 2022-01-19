<?php
/**
 * Plugin Name: Posts - Events
 * Plugin URI: https://www.facebook.com/jesusMFC
 * Description: Este plugln crea files json in server
 * Version: 1.0.0
 * Author: Jesus Fuentes
 * Author URI: https://www.facebook.com/jesusMFC
 *
 * Text Domain: wpplugin
 * Domain path: /
 */

//const ARRPOSTTYPE = ['playlist_yt', 'playlist_sp'];
//const ARRPOSTTYPEGLOBAL = ['ranking'];
global $wp_session;
include('generate-interface/index.php');
include('spotify-api/index.php');
include('youtube-api/index.php');
include('generate-json-local/index.php');
include('generate-json-remote/index.php');

const ARRPOSTTYPE = ['playlist_yt', 'playlist_sp'];
const ARRPOSTTYPEGLOBAL = ['ranking', 'in_trend', 'page_artist_item'];

function get_artists_all(){
    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'date' =>'DESC',
        ),
    );

    $query = new WP_Query( $args );

    return $query;
}

//EJEMPLO DE ACCIONES LUEGO DE ACCIONES EN FORMULARIO
//add_action('save_post', 'add_data');
//add_action('wp_insert_post_data', 'add_data');
//add_action('post_updated', 'add_data');
//add_action('save_post', 'add_data');
//add_action('delete_post', 'add_data');

//ADMIN VISUAL
//add_action('admin_post_submit-form', '_handle_form_action'); // If the user is logged in
//add_action('admin_post_nopriv_submit-form', '_handle_form_action'); // If the user in not logged in
