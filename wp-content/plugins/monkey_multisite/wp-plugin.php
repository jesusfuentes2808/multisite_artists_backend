<?php
/**
 * Plugin Name: New Posts - Multisite
 * Plugin URI: https://www.facebook.com/jesusMFC
 * Description: Este plugln adiciona nuevos tipos de datos
 * Version: 1.0.0
 * Author: Jesus Fuentes
 * Author URI: https://www.facebook.com/jesusMFC
 *
 * Text Domain: wpplugin
 * Domain path: /
 */
defined( 'ABSPATH' ) or die( 'No inicalizado' );
define('PLUGIN_FILE_URL', __FILE__);

include('filter-table.php');

function register_post_contact_user_type() {

    $labels = array(
        'name' => __( 'Contacto - Usuarios'),
        'singular_name' => __( 'Contacto - Usuarios'),
        'add_new' => __( 'Nueva Contacto - Usuarios'),
        'add_new_item' => __( 'Agregar Contacto - Usuarios'),
        'edit_item' => __( 'Actualizar Contacto - Usuarios'),
        'new_item' => __( 'Nueva Contacto - Usuarios'),
        'view_item' => __( 'Ver Contacto - Usuarios'),
        'search_items' => __( 'Buscar Contacto - Usuarios'),
        'not_found' =>  __( 'Contacto - Usuarios no encontradas'),
        'not_found_in_trash' => __( 'Contacto - Usuarios no encontradas en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'contact_user' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-id-alt',
    );

    register_post_type( 'contact_user', $args );
}

function register_post_in_trend_type() {

    $labels = array(
        'name' => __( 'Tendencias Global'),
        'singular_name' => __( 'Tendencias'),
        'add_new' => __( 'Nueva Tendencias'),
        'add_new_item' => __( 'Agregar Tendencias'),
        'edit_item' => __( 'Actualizar Tendencias'),
        'new_item' => __( 'Nueva Tendencias'),
        'view_item' => __( 'Ver Tendencias'),
        'search_items' => __( 'Buscar Tendencias'),
        'not_found' =>  __( 'Tendencias no encontradas'),
        'not_found_in_trash' => __( 'Tendencias no encontradas en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'in_trend' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-site',
    );

    register_post_type( 'in_trend', $args );
}

function register_post_ranking_type() {

    $labels = array(
        'name' => __( 'Ranking Global'),
        'singular_name' => __( 'Ranking'),
        'add_new' => __( 'Nueva Ranking'),
        'add_new_item' => __( 'Agregar Ranking'),
        'edit_item' => __( 'Actualizar Ranking'),
        'new_item' => __( 'Nueva Ranking'),
        'view_item' => __( 'Ver Ranking'),
        'search_items' => __( 'Buscar Ranking'),
        'not_found' =>  __( 'Ranking no encontradas'),
        'not_found_in_trash' => __( 'Ranking no encontradas en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'ranking' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-site',
    );

    register_post_type( 'ranking', $args );
}


function register_post_page_artist_type() {

    $labels = array(
        'name' => __( 'Página Artista'),
        'singular_name' => __( 'Página Artista'),
        'add_new' => __( 'Nueva Página Artista'),
        'add_new_item' => __( 'Agregar Página Artista'),
        'edit_item' => __( 'Actualizar Página Artista'),
        'new_item' => __( 'Nueva Página Artista'),
        'view_item' => __( 'Ver Página Artista'),
        'search_items' => __( 'Buscar Página Artista'),
        'not_found' =>  __( 'Página Artista no encontradas'),
        'not_found_in_trash' => __( 'Página Artista no encontradas en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'page_artist' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-networking',
    );

    register_post_type( 'page_artist', $args );
}

function register_post_page_artist_week_type() {

    $labels = array(
        'name' => __( 'Global Artista Semana'),
        'singular_name' => __( 'Global Artista Semana'),
        'add_new' => __( 'Nueva Global Artista Semana'),
        'add_new_item' => __( 'Agregar Global Artista Semana'),
        'edit_item' => __( 'Actualizar Global Artista Semana'),
        'new_item' => __( 'Nueva Global Artista Semana'),
        'view_item' => __( 'Ver Global Artista Semana'),
        'search_items' => __( 'Buscar Global Artista Semana'),
        'not_found' =>  __( 'Global Artista Semana no encontradas'),
        'not_found_in_trash' => __( 'Global Artista Semana no encontradas en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'page_artist_week' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-site',
    );

    register_post_type( 'page_artist_week', $args );
}

function register_post_page_artist_items_type() {

    $labels = array(
        'name' => __( 'Artista Semana Item '),
        'singular_name' => __( 'Artista Semana Item '),
        'add_new' => __( 'Nueva Artista Semana Item '),
        'add_new_item' => __( 'Agregar Artista Semana Item '),
        'edit_item' => __( 'Actualizar Artista Semana Item '),
        'new_item' => __( 'Nueva Artista Semana Item '),
        'view_item' => __( 'Ver Artista Semana Item '),
        'search_items' => __( 'Buscar Artista Semana Item '),
        'not_found' =>  __( 'Artista Semana Item  no encontrados'),
        'not_found_in_trash' => __( 'Artista Semana Item  no encontrados en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'page_artist_item' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-site',
    );

    register_post_type( 'page_artist_item', $args );
}


function register_post_playlist_yt_type() {

    $labels = array(
        'name' => __( 'Playlist YT'),
        'singular_name' => __( 'Playlist YT'),
        'add_new' => __( 'Nueva Playlist YT'),
        'add_new_item' => __( 'Agregar Playlist YT'),
        'edit_item' => __( 'Actualizar Playlist YT'),
        'new_item' => __( 'Nueva Playlist YT'),
        'view_item' => __( 'Ver Playlist YT'),
        'search_items' => __( 'Buscar Playlist YT'),
        'not_found' =>  __( 'Playlist YT no encontrados'),
        'not_found_in_trash' => __( 'Playlist YT no encontrados en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'playlist_yt' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-youtube',
    );

    register_post_type( 'playlist_yt', $args );
}


function register_post_playlist_sp_type() {

    $labels = array(
        'name' => __( 'Playlist SP'),
        'singular_name' => __( 'Playlist SP'),
        'add_new' => __( 'Nueva Playlist SP'),
        'add_new_item' => __( 'Agregar Playlist SP'),
        'edit_item' => __( 'Actualizar Playlist SP'),
        'new_item' => __( 'Nueva Playlist SP'),
        'view_item' => __( 'Ver Playlist SP'),
        'search_items' => __( 'Buscar Playlist SP'),
        'not_found' =>  __( 'Playlist SP no encontrados'),
        'not_found_in_trash' => __( 'Playlist SP no encontrados en Basurero'),
    );

    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'rewrite'   => array( 'slug' => 'playlist_sp' ),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-spotify',
    );

    register_post_type( 'playlist_sp', $args );
}


add_action( 'init', 'register_post_page_artist_type' );
add_action( 'init', 'register_post_playlist_yt_type' );
add_action( 'init', 'register_post_playlist_sp_type' );
add_action( 'init', 'register_post_in_trend_type' );
add_action( 'init', 'register_post_ranking_type' );
add_action( 'init', 'register_post_page_artist_week_type' );
add_action( 'init', 'register_post_page_artist_items_type' );
add_action( 'init', 'register_post_contact_user_type' );













/*
function register_genre_taxonomy() {

    $labels = array(
        'name' => __( 'Generos'),
        'singular_name' => __( 'Genero', 'tutsplus' ),
        'search_items' => __( 'Buscar Generos'),
        'all_items' => __( 'Todos los Generos'),
        'edit_item' => __( 'Editar Genero'),
        'update_item' => __( 'Actualizar Generos'),
        'add_new_item' => __( 'Agregar nuevo Genero'),
        'new_item_name' => __( 'Nuevo nombre de Genero'),
        'menu_name' => __( 'Generos'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'generos' ),
        'show_admin_column' => true,
        'show_in_rest' => true

    );

    register_taxonomy( 'genre', array( 'song' ), $args);

}

add_action( 'init', 'register_genre_taxonomy' );*/

add_action( 'current_screen', function() {

    $custom_post_type = 'contact_user';

    $screen = get_current_screen();

    global $pagenow;

    if ( ! in_array( $pagenow, array( 'post-new.php' ), true )
         && 'post' === $screen->base
         && $custom_post_type === $screen->post_type ) {

        add_action( 'admin_footer', 'hide_batch_update_buttons' );
    }

    if ( ! in_array( $pagenow, array( 'post.php' ), true )
         && 'post' === $screen->base
         && $custom_post_type === $screen->post_type ) {

        add_action( 'admin_footer', 'hide_batch_update_buttons' );
    }

});

function hide_batch_update_buttons() {
	?>
	<script type="text/javascript">
	(function( $ ) {
		'use strict';
		// Remove the update buttons so batches can't be edited.
        setTimeout(() => {
            jQuery('#submitdiv .edit-post-status').remove();
            jQuery('#submitdiv .edit-visibility').remove();
            jQuery('#submitdiv .edit-timestamp').remove();
            jQuery('#minor-publishing-actions').remove();
            jQuery('#major-publishing-actions').remove();
            jQuery(".editor-post-publish-button__button").remove();

            // Add the "Add New" button in the right-hand column
            jQuery('.wrap .page-title-action').clone().appendTo('#side-sortables');
        }, 2000);

        console.log("DELETE DELETE");
	})( jQuery );
	</script>
	<?php
}







