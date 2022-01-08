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

const ARRPOSTTYPE = ['playlist_yt', 'playlist_sp'];
const ARRPOSTTYPEGLOBAL = ['ranking', 'in_trend', 'page_artist_item'];

function add_cors_http_header( $value ) {
    $origin = get_http_origin();
    
    $allowed_origins = [ 'multisite_artists.test:8084', 'site2.example.com', 'localhost:3000' ];

    if ( $origin && in_array( $origin, $allowed_origins ) ) {
        header( 'Access-Control-Allow-Origin: ' . esc_url_raw( $origin ) );
        header( 'Access-Control-Allow-Methods: GET' );
        header( 'Access-Control-Allow-Credentials: true' );
    }

    return $value;
}

add_action('init','add_cors_http_header');

function add_data($postId) {
    $post = get_post($postId);
    
    if(in_array($post->post_type, ARRPOSTTYPE)){
        $keyArtist = array();
        $postArtist = get_field('pagina_artista_id', $post->ID);
        $codeArtist = get_field('codigo', $postArtist->ID);
        $keyArtist = ['id' => $postArtist->ID, 'name' => $codeArtist];
        makeDirectory($post->post_type, $keyArtist);
    } else if(in_array($post->post_type, ARRPOSTTYPEGLOBAL)){
        makeDirectory($post->post_type);
    }

}


function makeDirectory($postType, $keyArtist = null){
    if (!is_dir(WP_CONTENT_DIR . '/json/')) {
        mkdir(WP_CONTENT_DIR . '/json/');
    }
    
    $type = '';

    if(is_null($keyArtist)){
        //$folder = get_template_directory() . '/assets/json/'.$postType.'/';   
        $folder = WP_CONTENT_DIR . '/json/'.$postType.'/';   
        
        $type = 'tracks';

        $args = array (
            'post_type'      => $postType,
            'posts_per_page' => 10,
            'orderby'   => array(
                'date' =>'DESC',
            ),
            'post_status' => array('publish'),
        );
    } else {
        //$folder = get_template_directory() . '/assets/json/'.$keyArtist['name'].'/';
        $folder = WP_CONTENT_DIR . '/json/'.$keyArtist['name'].'/';   
        
        $args = array (
            'post_type'      => $postType,
            'posts_per_page' => 10,
            'orderby'   => array(
                'date' =>'DESC',
            ),
            'post_status' => array('publish'),
            'meta_query'	=> array(
                array(
                    'key'	 	=> 'pagina_artista_id',
                    'value'	  	=> $keyArtist['id'],
                    'compare' 	=> '=',
                )
            ),
        );

        $type="playlists";
    }
    
    if (!is_dir($folder)) {
        mkdir($folder);
    }

    $data = createJSON($args, $type);
    
    $file_name = $postType . '.json';
    file_put_contents($folder.$file_name, $data);
}

function createJSON($args, $type){
    $token = getToken();
    
    $query = new WP_Query( $args );

    $posts_query = $query->posts;

    $posts = array();
    
    foreach($posts_query as $index => $post) {
        $posts[$index]['title']          =   $post->post_title;
        
        if($type === 'tracks')
        {
            $posts[$index]['track_id'] = get_field('track_id', $post->ID);
        } else {
            $posts[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
        }


        if($type === 'tracks')
        {
            $posts[$index]['response'] = json_decode(getSpotify($token, get_field('track_id', $post->ID), $type));
        } 
        else if($type === 'playlists' && $args['post_type'] === 'playlist_yt')
        {
            $posts[$index]['response'] = json_decode(getYoutube(get_field('codigo_de_playlist', $post->ID)));
        }
        else if($type === 'playlists' && $args['post_type'] === 'playlist_sp')
        {
            $posts[$index]['response'] = json_decode(getSpotify($token, get_field('codigo_de_playlist', $post->ID), $type));
        }
    }
    
    wp_reset_query();

    $data = json_encode($posts, JSON_UNESCAPED_UNICODE);

    return $data;
}

function selectGenerator($type){
    switch ($type) {
        case 'value':
            # code...
            break;
        default:
            # code...
            break;
    }
}


function getToken(){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://accounts.spotify.com/api/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"grant_type=client_credentials");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                'Content-Type: application/x-www-form-urlencoded',
                                                'Authorization: Basic  OGJmOGZhODUzYTM2NGZjYjlkOTk4Y2MyMjk1MGM5YzU6NzdiMGI3MzA3ZTE3NDMwMzk2ZDBmNDA3OTQxNmRkZjM='
                                                )
                                            );


    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);

    curl_close ($ch);

    $responseJSON = json_decode($server_output);

    if(isset($responseJSON->error)){
        return '-1';
    } else {
        return $responseJSON->access_token;
    }

}


/*return await fetch("https://api.spotify.com/v1/tracks/" + listId,
        {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': tokenStorage ? tokenStorage.token : '',
            },
        }
    )*/

function getYoutube($listId, $type='playlist'){
    /*$arrListId = [];
    for($i = 0 ; $i < count($listId); $i++){
        array_push($arrListId, 'id='+youtube_ids[i]);
    }
    
    var_dump(join('&', $arrListId));*/
    //array_youtube_ids = array_youtube_ids.join('&');

    $ch = curl_init();
    //https://api.spotify.com/v1/playlists/

    curl_setopt($ch, CURLOPT_URL,"https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&id=" . $listId . "&maxResults=10&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                'Content-Type: application/json'
                                                )
                                            );


    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);

    curl_close ($ch);

    return $server_output;
}

function getSpotify($token, $listId = '5aHHf6jrqDRb1fcBmue2kn', $type='tracks'){
    $ch = curl_init();
    //https://api.spotify.com/v1/playlists/

    curl_setopt($ch, CURLOPT_URL,"https://api.spotify.com/v1/" . $type . "/" . $listId);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                                'Content-Type: application/json',
                                                'Authorization: Bearer ' . $token
                                                )
                                            );


    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);

    curl_close ($ch);

    return $server_output;
    /*$responseJSON = json_decode($server_output);

    if(isset($responseJSON->error)){
        return '-1';
    } else {
        return $responseJSON->access_token;
    }*/

}

//add_action('save_post', 'add_data');
//add_action('wp_insert_post_data', 'add_data');
//add_action('post_updated', 'add_data');
//add_action('save_post', 'add_data');
//add_action('delete_post', 'add_data');



//ADMIN VISUAL
add_action('admin_menu', 'sincronizar_listas');
 
function sincronizar_listas() {
 add_menu_page('Sincronizar Listas',
 'Sincronizar Listas',
 'manage_options',
 'sincronizar_listas', 
 'funcion_sincronizar','',3);
}

function funcion_sincronizar() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('No tienes suficientes permisos para acceder a esta página.') );
    }

    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'date' =>'DESC',
        ),
    );

    $query = new WP_Query( $args );

    $posts_query = $query->posts;
    if($_GET['response'] == 'ok'){
        echo '<br /><br />';
        echo '<div id="message_system" style="background: #49c049;color: black;font-weight: bold;font-size: 20px;padding: 10px;" class="message">Se actualizaron los datos correctamente</div>';
        echo '<script> setTimeout(function(){ jQuery("#message_system").fadeOut( 1600); },5000)</script>';
        echo '<br />';
    } else if($_GET['response'] == 'error'){
        echo '<br /><br />';
        echo '<div id="message_system" style="background: #c06168;color: black;font-weight: bold;font-size: 20px;padding: 10px;" class="message">No se actualizaron los datos correctamente, por favor revisar</div>';
        echo '<script> setTimeout(function(){ jQuery("#message_system").fadeOut( 1600); },5000)</script>';
        echo '<br />';
    } else if($_GET['response'] == 'select_nothing'){
        echo '<br /><br />';
        echo '<div id="message_system" style="background: #c06168;color: black;font-weight: bold;font-size: 20px;padding: 10px;" class="message">Seleccionar algún campo, por favor revisar</div>';
        echo '<script> setTimeout(function(){ jQuery("#message_system").fadeOut( 1600); },5000)</script>';
        echo '<br />';
    }

    echo '<div class="wrap">';
    echo '<h2>Lista de páginas</h2>';
    echo '<h3>Seleccione las páginas que desea sincronizar</h3>';
    echo  '<form method="post"  action="'.get_admin_url().'admin-post.php">';
    echo '<input name="action" type="hidden" value="custom_form_submit">';
    
    echo '<p><input value="ranking" name="global[]"  type="checkbox" />Listas Globales - Ranking</p>';
    echo '<p><input value="in_trend" name="global[]"  type="checkbox" />Listas Globales - Tendencia</p>';
    echo '<p><input value="page_artist_item" name="global[]"  type="checkbox" />Listas Globales - Item Pagina artista</p>';

    echo '<hr/>';

        foreach($posts_query as $index => $post) {
            echo '<p><input value="'.$post->ID.'" name="page_artist[]"  type="checkbox" />'.$post->post_title.'</p>';
        }
    echo '<button style="font-size: 25px;font-weight: inherit;width: 200px;cursor: pointer;" type="submit">Sincronizar</button>';
   
    
    
    echo '</div>';
}

add_action('admin_post_custom_form_submit','our_custom_form_function');
//add_action('admin_post_submit-form', '_handle_form_action'); // If the user is logged in
//add_action('admin_post_nopriv_submit-form', '_handle_form_action'); // If the user in not logged in
function our_custom_form_function(){
    try{
        $selectNothing = true;
        var_dump($_POST['global']);

        if(isset($_POST['global'])){
            foreach($_POST['global'] as $postType){
                if(in_array($postType, ARRPOSTTYPEGLOBAL)){
                    fn_sincronizar_global($postType);    
                } 
            }
            $selectNothing = false;
        }
        
        if(isset($_POST['page_artist'])){
            foreach($_POST['page_artist'] as $postId){
                fn_sincronizar_listas($postId);
            }
            $selectNothing = false;
        }

        if($selectNothing){
            wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=select_nothing'));    
        } else {
            wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=ok'));    
        }

    } catch (\Error $e) {
        wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=error'));    
    }   
}



function fn_sincronizar_listas($postId) {
    $codeArtist = get_field('codigo', $postId);
    if (empty($codeArtist))  {
        wp_die( __('Code no exist.') );
    }

    $keyArtist = array();
    $keyArtist = ['id' => $postId, 'name' => $codeArtist];
    foreach(ARRPOSTTYPE as $post_type){
        makeDirectory($post_type, $keyArtist);
    }
    
    /*if(!empty($codeArtist)){
        makeDirectory($post->post_type, $keyArtist);
    } else if(in_array($post->post_type, ARRPOSTTYPEGLOBAL)){
        makeDirectory($post->post_type);
    }*/

}

function fn_sincronizar_global($postType) {
    makeDirectory($postType);
}

