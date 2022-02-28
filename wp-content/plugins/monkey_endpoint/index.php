<?php
/**
 * Plugin Name: Endpoint Consumer
 * Plugin URI: https://www.facebook.com/jesusMFC
 * Description: Este plugln adiciona un endpoints
 * Version: 1.0.0
 * Author: Jesus Fuentes
 * Author URI: https://www.facebook.com/jesusMFC
 *
 * Text Domain: wpplugin
 * Domain path: /
 */

const STATUS_RESPONSE = [
    'ok' => 'OK',
    'fail' => 'FAIL',
    'error' => 'ERROR',
];

add_action( 'rest_api_init', function () {

    register_rest_route( 'v1', '/ranking',
        array(
            'methods' => 'GET',
            'callback' => 'get_ranking'
        )
    );

    register_rest_route( 'v1', '/trend',
        array(
            'methods' => 'GET',
            'callback' => 'get_trend'
        )
    );

    register_rest_route( 'v1', '/artist/week',
        array(
            'methods' => 'GET',
            'callback' => 'get_page_artist_week'
        )
    );

    register_rest_route( 'v1', '/artist/(?P<codigo>[a-zA-Z0-9-_]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_page_artists'
        )
    );

    register_rest_route( 'v1', '/artist',
        array(
            'methods' => 'GET',
            'callback' => 'get_page_artists_all'
        )
    );

    register_rest_route( 'v1', '/artist/(?P<codigo>[a-zA-Z0-9-_]+)/(?P<tipo>[a-zA-Z0-9-_]+)',
        array(
            'methods' => 'GET',
            'callback' => 'get_youtube_spotify_playlist'
        )
    );

    register_rest_route( 'v1', '/global/trend',
        array(
            'methods' => 'GET',
            'callback' => 'get_trend_playlist'
        )
    );

    register_rest_route( 'v1', '/global/ranking',
        array(
            'methods' => 'GET',
            'callback' => 'get_ranking_playlist'
        )
    );
    
    register_rest_route( 'v1', '/insert',
        array(
            'methods' => 'GET',
            'callback' => 'insert_user'
        )
    );
    
    register_rest_route( 'v1', '/insert',
        array(
            'methods' => 'POST',
            'callback' => 'insert_user_post'
        )
    );

});

function get_ranking($data){
    $filename =   WP_CONTENT_DIR . '/json/ranking/ranking.json';
    $contentRanking = [];

    if (file_exists($filename)) {
        $contentRanking = file_get_contents($filename);
        $contentRanking = json_decode($contentRanking);
    }

    return $contentRanking;
}

function get_trend($data){
    $filename =   WP_CONTENT_DIR . '/json/in_trend/in_trend.json';
    $contentTrend = [];

    if (file_exists($filename)) {
        $contentTrend = file_get_contents($filename);
        $contentTrend = json_decode($contentTrend);
    }

    return $contentTrend;
}

function insert_user($data){
    $my_post = array(
        'post_title'    => wp_strip_all_tags('Jesus Fuentes'),//wp_strip_all_tags( $_POST['post_title'] ),
        'post_content'  => 'Hola que tal',//$_POST['post_content'],
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'   => 'contact_user',
    );
    
    return wp_insert_post( $my_post );
}

function insert_user_post($data){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $message = $_POST['message'];
    $artist_id = $_POST['artist_id'];

    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => 1,
        'orderby'   => array(
            'start_date' => 'ASC',
            'start_time' => 'ASC'
        ),
        'meta_query'	=> array(
            array(
                'key'	 	=> 'codigo',
                'value'	  	=> $artist_id,
                'compare' 	=> '=',
            )
        ),
    );

    $meta_query = new WP_Query($args);
    
    $postId = null;
    
    if($meta_query->have_posts()) {
        $meta_query->the_post();
        $postId = get_the_ID();
    }

    if(!$postId){
        return 0;
    }

    $my_post = array(
        'post_title'    => wp_strip_all_tags($name),//wp_strip_all_tags( $_POST['post_title'] ),
        'post_content'  => $name,//$_POST['post_content'],
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'   => 'contact_user',
        'meta_input'    =>  array(
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
            'message' => $message,
            'artist_id' => $postId,
        ),
    );
    
    /*
    wp_update_post(array(
        'post_title' => 'About',
        'ID' => $page_id,
        'meta_input' =>  array(
          'your_meta_key' => 'your meta value'
        ),
      ));
      */

    return wp_insert_post( $my_post );
}

function get_ranking_playlist($data){

    $codigo = $data['codigo'];

    $args = array (
        'post_type'      => 'ranking',
        'posts_per_page' => 10,
        'orderby'   => array(
            'date' =>'DESC',
        ),
    );


    $response = array();
    $data = array();

    $meta_query_playlist = new WP_Query($args);
    $posts = $meta_query_playlist->posts;

    if(count($posts) === 0){
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe lista';
        $response['data'] = [];    
        return $response;
    }

    foreach($posts as $index => $post) {
        $data[$index]['title']          =   $post->post_title;
        $data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
    }

    $response['response'] = STATUS_RESPONSE['ok'];
    $response['message'] = 'tendencias cargadas';
    $response['data'] = $data;

    return $response;
}


function get_artist_week($data){

    $codigo = $data['codigo'];

    $args = array (
        'post_type'      => 'page_artist_week',
        'posts_per_page' => 1,
        'orderby'   => array(
            'date' =>'DESC',
        ),
    );


    $response = array();
    $data = array();

    $meta_query_playlist = new WP_Query($args);
    $posts = $meta_query_playlist->posts;

    if(count($posts) === 0){
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe lista';
        $response['data'] = [];    
        return $response;
    }

    foreach($posts as $index => $post) {
        $data[$index]['title']          =   $post->post_title;
        $data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
    }

    $response['response'] = STATUS_RESPONSE['ok'];
    $response['message'] = 'tendencias cargadas';
    $response['data'] = $data;

    return $response;
}

function get_trend_playlist($data){

    $codigo = $data['codigo'];

    $args = array (
        'post_type'      => 'in_trend',
        'posts_per_page' => 3,
        'orderby'   => array(
            'date' =>'DESC',
        ),
    );


    $response = array();
    $data = array();

    $meta_query_playlist = new WP_Query($args);
    $posts = $meta_query_playlist->posts;

    if(count($posts) === 0){
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe lista';
        $response['data'] = [];    
        return $response;
    }

    foreach($posts as $index => $post) {
        $data[$index]['title']          =   $post->post_title;
        $data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
    }

    $response['response'] = STATUS_RESPONSE['ok'];
    $response['message'] = 'tendencias cargadas';
    $response['data'] = $data;

    return $response;
}


function get_page_artists($data){

    $codigo = $data['codigo'];

    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'start_date' => 'ASC',
            'start_time' => 'ASC'
        ),
        'meta_query'	=> array(
            array(
                'key'	 	=> 'codigo',
                'value'	  	=> $codigo,
                'compare' 	=> '=',
            )
        ),
    );

    $meta_query = new WP_Query($args);

    $response = array();
    $data = array();

    if($meta_query->have_posts()) {
        $meta_query->the_post();
        $postId = get_the_ID();
        $title = get_the_title();
        $content = get_the_content();
        
        $data['post'] = get_post( $postId );
        $data['post_thumbnail'] =  wp_get_attachment_url(get_post_thumbnail_id( $postId ));
        $data['field_custom'] = get_post_meta(get_the_ID());

        $response['response'] = STATUS_RESPONSE['ok'];
        $response['message'] = 'artista cargado';
        $response['data'] = $data;
    } else {
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe artista';
        $response['data'] = [];    
    }

    return $response;
}

function get_page_artists_all($data){


    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'start_date' => 'ASC',
            'start_time' => 'ASC'
        )
    );

    $response = array();
    $data = array();

    $meta_query_playlist = new WP_Query($args);
    $posts = $meta_query_playlist->posts;

    if(count($posts) === 0){
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe lista';
        $response['data'] = [];    
        return $response;
    }

    foreach($posts as $index => $post) {
        $data[$index]['title']          =   $post->post_title;
        $data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
        $data[$index]['url'] = get_field('url', $post->ID);
    }

    $response['response'] = STATUS_RESPONSE['ok'];
    $response['message'] = 'tendencias cargadas';
    $response['data'] = $data;

    return $response;
}


function get_youtube_spotify_playlist($data){

    $codigo = $data['codigo'];
    $tipo = $data['tipo'];
    
    $typeValue = '';

    if($tipo === 'youtube'){
        $typeValue = 'playlist_yt';
    } else if($tipo === 'spotify'){
        $typeValue = 'playlist_sp';
    } else {
        $response['response'] = STATUS_RESPONSE['error'];
        $response['message'] = 'no existe tipo playlist';

        return $response;
    }

    

    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'start_date' => 'ASC',
            'start_time' => 'ASC'
        ),
        'meta_query'	=> array(
            array(
                'key'	 	=> 'codigo',
                'value'	  	=> $codigo,
                'compare' 	=> '=',
            )
        ),
    );

    $meta_query = new WP_Query($args);

    $response = array();
    $data = array();

    if($meta_query->have_posts()) {
        $meta_query->the_post();
        $artistId = get_the_ID();
        
        $args = array (
            'post_type'      => $typeValue,
            'posts_per_page' => -1,
            'orderby'   => array(
                'start_date' => 'ASC',
                'start_time' => 'ASC'
            ),
            'meta_query'	=> array(
                array(
                    'key'	 	=> 'pagina_artista_id',
                    'value'	  	=> $artistId,
                    'compare' 	=> '=',
                )
            ),
        );
        wp_reset_postdata();

        $meta_query_playlist = new WP_Query($args);

        $posts = $meta_query_playlist->posts;

        foreach($posts as $index => $post) {
            $data[$index]['title']          =   $post->post_title;
            $data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
        }

        $response['response'] = STATUS_RESPONSE['ok'];
        $response['message'] = 'lista ' . $tipo . ' cargada';
        $response['data'] = $data;

        wp_reset_postdata();
    } else {
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe artista';
        $response['data'] = [];    
    }

    return $response;
}


function get_page_artist_week(){

    $args = array (
        'post_type'      => 'page_artist_week',
        'posts_per_page' => 1,
        'orderby'   => array(
            'date' =>'DESC',
        )
    );

    $meta_query = new WP_Query($args);

    $response = array();
    $data = array();

    if($meta_query->have_posts()) {
        $meta_query->the_post();
        $postId = get_the_ID();
        $title = get_the_title();
        $content = get_the_content();
        
        $data['post'] = get_post( $postId );
        $data['post_thumbnail'] =  wp_get_attachment_url(get_post_thumbnail_id( $postId ));
        //$data['field_custom'] = get_post_meta(get_the_ID());

        $meta_query->the_post();
        $artistId = get_the_ID();
        
        $argsItem = array (
            'post_type'      => 'page_artist_item',
            'posts_per_page' => 6,
            'orderby'   => array(
                'date' =>'DESC',
            ),
            'meta_query'	=> array(
                array(
                    'key'	 	=> 'artist_week_id',
                    'value'	  	=> $postId,
                    'compare' 	=> '=',
                )
            ),
        );
        //var_dump($postId);
        wp_reset_postdata();

        $meta_query_item = new WP_Query($argsItem);

        $posts = $meta_query_item->posts;
        
        $data['items'] = array();
        foreach($posts as $index => $post) {
            //echo get_field('artist_week_id', $post->ID);
            //exit();
            $data['items'][$index]['title']    =   $post->post_title;
            $data['items'][$index]['track_id'] = get_field('track_id', $post->ID);
        }

        wp_reset_postdata();

        $response['response'] = STATUS_RESPONSE['ok'];
        $response['message'] = 'artista cargado';
        $response['data'] = $data;
    } else {
        $response['response'] = STATUS_RESPONSE['fail'];
        $response['message'] = 'no existe artista';
        $response['data'] = [];    
    }

    return $response;
}

function disable_acf_load_field( $field ) {
	$fields = ["email","name","telephone","message"]; // add more here
	if(in_array($field["name"],$fields)) $field['disabled'] = true;
	return $field;
}
add_filter('acf/load_field/type=text', 'disable_acf_load_field');
add_filter('acf/load_field/type=textarea', 'disable_acf_load_field');

