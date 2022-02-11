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
//define('DATA_ARTISTS', get_artists_all_columns());
//var_dump(DATA_ARTISTS);

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


//Registrar columna
//add_filter('manage_posts_columns', 'my_columns');


add_filter('manage_edit-playlist_yt_columns', 'my_columns');
function my_columns($columns) {
    var_dump("HOLA");
    $columns['pagina_artista_id'] = 'Artista';
    return $columns;
}


function test() {
    global $dataArtistStart;
    //$dataArtistStart = get_artists_all_columns();

}
add_action( 'after_setup_theme', 'test' );

//$dataArtistStart = get_artists_all_columns();
//get_post_meta($item->ID, 'url');
add_action('manage_posts_custom_column',  'my_show_columns');
function my_show_columns($name) {
    global $post;

    $posts_query = get_artists_all_columns();

    $listArtists = array_map(function ($item) {
        $arr['id'] = $item->ID;
        $arr['name'] = $item->ID . ' | ' . $item->post_title;
        return $arr;
    }, $posts_query);


    switch ($name) {
        case 'pagina_artista_id':
            $artistId = get_post_meta($post->ID, 'pagina_artista_id')[0];
            //var_dump($artistId );

            $artistSearch = array_search($artistId, array_column($listArtists, 'id'));
            $views = $listArtists[$artistSearch]['name'];

            echo $views;
    }
}


function get_artists_all_columns(){
    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'date' =>'DESC',
        )
    );

    $query = new WP_Query( $args );


    $posts_query = $query->posts;

    return $posts_query ;
}


add_filter("manage_edit-playlist_yt_sortable_columns", 'concerts_sort');
function concerts_sort($columns) {
    $custom = array(
        'pagina_artista_id' 	=> 'pagina_artista_id',
    );
    return wp_parse_args($custom, $columns);
}


add_filter( 'request', 'city_column_orderby' );
function city_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'pagina_artista_id' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'pagina_artista_id',
            //'orderby' => 'meta_value_num', // does not work
            'orderby' => 'meta_value'
            //'order' => 'asc' // don't use this; blocks toggle UI
        ) );
    }
    return $vars;
}


//add_filter( 'parse_query', 'prefix_parse_filter' );
add_filter( 'parse_query', 'prefix_parse_filter' );
function  prefix_parse_filter($query) {

    global $pagenow;
    $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    $typeQuery = $query->query['post_type'];

    //var_dump("IS_MAIN_QUERY");
    //var_dump($query->is_main_query());


    //MAIN
    /*$query->set('meta_query', array(
        array(
            'key' => 'pagina_artista_id',
            'compare' => '=',
            'value' => 18
        )
    ));*/

    //var_dump($query);
    /*var_dump( is_admin() &&
        'playlist_yt' == $current_page &&
        'edit.php' == $pagenow &&
        $typeQuery == 'playlist_yt' &&
        isset( $_GET['s'] )
    );*/

    //var_dump("CALZONCILLOS");
    //var_dump(isset($_GET['ADMIN_FILTER_FIELD_VALUE']));
    //var_dump($query->is_main_query() && $typeQuery == 'playlist_yt' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']));
    if($query->is_main_query() && $typeQuery == 'playlist_yt' && (isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && is_numeric($_GET['ADMIN_FILTER_FIELD_VALUE'])) ){
        $query->set('meta_query', array(
            array(
                'key' => 'pagina_artista_id',
                'compare' => '=',
                'value' => $_GET['ADMIN_FILTER_FIELD_VALUE']
            )
        ));
    }
    /*
    if ( is_admin() &&
        'playlist_yt' == $current_page &&
        'edit.php' == $pagenow &&
        $typeQuery == 'playlist_yt' &&
        isset( $_GET['s'] )
        //$_GET['pagina_artista_id'] != '' ) {
    ) {
        var_dump($query);
        $query->set('meta_query', array(
            array(
                'key' => 'pagina_artista_id',
                'compare' => '=',
                'value' => 18
            )
        ));
    }*/



    /*var_dump($query);
    if ( is_admin() &&
        'playlist_yt' == $current_page &&
        'edit.php' == $pagenow
        //isset( $_GET['pagina_artista_id'] ) &&
        //$_GET['pagina_artista_id'] != '' ) {
        ) {

        $competition_name                  = $_GET['pagina_artista_id']? $_GET['pagina_artista_id'] : '';
        $query->query_vars['meta_key']     = 'pagina_artista_id';
        $query->query_vars['meta_value']   = $competition_name;
        $query->query_vars['meta_compare'] = '=';
    }*/
}

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





add_action( 'restrict_manage_posts', 'wpse45436_admin_posts_filter_restrict_manage_posts' );
/**
 * First create the dropdown
 * make sure to change POST_TYPE to the name of your custom post type
 *
 * @author Ohad Raz
 *
 * @return void
 */
function wpse45436_admin_posts_filter_restrict_manage_posts(){
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('playlist_yt' == $type){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = get_artists_all_columns();

        $listArtists = array_map(function ($item) {
            $arr['id'] = $item->ID;
            $arr['name'] = $item->ID . ' | ' . $item->post_title;
            return $arr;
        }, $values );
        ?>
        <select name="ADMIN_FILTER_FIELD_VALUE">
            <option value=""><?php _e('Filter By ', 'wose45436'); ?></option>
            <?php
            $current_v = isset($_GET['ADMIN_FILTER_FIELD_VALUE'])? $_GET['ADMIN_FILTER_FIELD_VALUE']:'';
            foreach ($listArtists as $label => $value) {
                echo "<option value='" . $value['id'] . "'>". $value['name'] . " </option>";
                /*var_dump($values);
                printf
                (
                    '<option value="'.$value->ID.'"%s>'.$value->ID.'</option>',
                    $value,
                    $value == $current_v? ' selected="selected"':'',
                    $label
                );*/
            }
            ?>
        </select>
        <?php
    }
}