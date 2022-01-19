<?php
function register_session_new(){
    if( ! session_id() ) {
       session_start();
     }
 }

add_action('init', 'register_session_new');

function sincronizar_listas() {
    add_menu_page('Sincronizar Listas',
                    'Sincronizar Listas',
                    'manage_options',
                    'sincronizar_listas', 
                    'funcion_sincronizar','',3
                );
} 

function funcion_sincronizar() {
    global $wp_session;

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

    foreach($posts_query as $index => $post) {
        echo '<p style="width: 20%; display: inline-block">
                <input value="'.$post->ID.'" name="page_artist[]"  type="checkbox" />'.
                $post->post_title .
            '</p>';
    }
    echo '<hr/>';
    echo '<span style="font-weight: bold">Si seleccionas las listas globales y no has seleccionado ninguna página, se sincronizarán la lista global seleccionadas (Ranking, Tendencias, Item Página Artista) de todas las páginas.</span>';
    echo '<p><input value="ranking" name="global[]"  type="checkbox" />Listas Globales - Ranking</p>';
    echo '<p><input value="in_trend" name="global[]"  type="checkbox" />Listas Globales - Tendencia</p>';
    echo '<p><input value="page_artist_item" name="global[]"  type="checkbox" />Listas Globales - Item Pagina artista</p>';
    
    echo '<button style="font-size: 25px;font-weight: inherit;width: 200px;cursor: pointer;" type="submit">Sincronizar</button>';
    
    if(isset($_SESSION['message'])){
        echo '<hr/>';
        
        foreach($_SESSION['message'] as $item){
            $itemJson = json_decode($item);
            if($itemJson->status === 'ok'){
                echo '<div style="background: #62ba62; padding: 10px; margin-bottom: 5px;"> <b>Url Sitio:</b> '
                        . $itemJson->data->url .' | <b>Lista:</b> '. $itemJson->data->message .
                    ' </div>';
            } else if($itemJson->status === 'error'){
                echo '<div style="background: ##fa8e8e; padding: 10px; margin-bottom: 5px;"> <b>Url Sitio:</b> '
                        . $itemJson->data->url .' | <b>Mensaje:</b> '. $itemJson->data->message .
                    ' </div>';
            }
        }
    }

    echo '</div>';
    unset($_SESSION['message']);
}

function our_custom_form_function(){
    try{
        
        $selectNothing = true;
        $arrayMessage = array();

        if(isset($_POST['global'])){
            foreach($_POST['global'] as $postType){
                if(in_array($postType, ARRPOSTTYPEGLOBAL)){
                    array_push($arrayMessage, fn_sincronizar_global($postType));

                    if(!isset($_POST['page_artist'])){
                        $query = get_artists_all();
                        $posts_query = $query->posts;

                        foreach($posts_query as $index => $post) {
                            $url = get_field('url', $post->ID);
                            array_push($arrayMessage, fn_enviar_files_remote($url, $postType));
                        }
                    } else {
                        foreach($_POST['page_artist'] as $postId){
                            $url = get_field('url', $postId);
                            array_push($arrayMessage, fn_enviar_files_remote($url, $postType));
                        }
                    }
                } 
            }
            $selectNothing = false;
        }
        
        
        if(isset($_POST['page_artist'])){
            foreach($_POST['page_artist'] as $postId){
                $codeArtist = get_field('codigo', $postId);
                $url = get_field('url', $postId);
                
                foreach(fn_sincronizar_listas($postId, $codeArtist) as $response){
                    array_push($arrayMessage, $response);
                }

                foreach(ARRPOSTTYPE as $nameFile){
                    array_push($arrayMessage, fn_enviar_files_remote($url, $codeArtist, $nameFile));
                }   
            }
            $selectNothing = false;
        }

        $_SESSION['message'] = $arrayMessage;

        if($selectNothing){
            wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=select_nothing'));    
        } else {
            wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=ok'));    
        }

    } catch (\Error $e) {
        wp_redirect(admin_url('/admin.php?page=sincronizar_listas&response=error'));    
    }   
}

function fn_sincronizar_global($postType) {
    return makeDirectory($postType);
}


function fn_sincronizar_listas($postId, $codeArtist) {
    if (empty($codeArtist))  {
        wp_die( __('Code no exist.') );
    }

    $keyArtist = array();
    $keyArtist = ['id' => $postId, 'name' => $codeArtist];
    $arryResponse = array();
    foreach(ARRPOSTTYPE as $post_type){
        array_push($arryResponse, makeDirectory($post_type, $keyArtist));
    }
    return $arryResponse;
}

add_action('admin_menu', 'sincronizar_listas');
add_action('admin_post_custom_form_submit','our_custom_form_function');