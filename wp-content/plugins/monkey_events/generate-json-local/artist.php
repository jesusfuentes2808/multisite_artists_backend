<?php
function fn_sincronizar_artista_info($postId, $codeArtist){
    if (!is_dir(WP_CONTENT_DIR . '/json/')) {
        mkdir(WP_CONTENT_DIR . '/json/');
    }

    $folder = WP_CONTENT_DIR . '/json/'.$codeArtist.'/';   
    $file_name =  'artist.json';

    if (!is_dir($folder)) {
        mkdir($folder);
    }

    $query = get_artists_all();
    $posts_query = $query->posts;

    $array_site = array_map(function($item){
        $response['post'] = $item;
        $response['url'] = get_post_meta($item->ID, 'url');
        //$response['field_custom'] = get_post_meta($item->ID);
        return $response;
    }, $posts_query );


    $dataInfo = array();
    $dataInfo['post'] = get_post( $postId );
    $dataInfo['post_thumbnail'] =  wp_get_attachment_url(get_post_thumbnail_id( $postId ));
    $dataInfo['field_custom'] = get_post_meta($postId);
    $dataInfo['artist_all'] = $array_site;

    $data = json_encode($dataInfo, JSON_UNESCAPED_UNICODE);

    $response = array();
    $response['data']['url'] = str_replace(WP_CONTENT_DIR, "local.com", $folder).$file_name;
    
    if(file_put_contents($folder.$file_name, $data) !== false){
        $response['status'] = "ok";
        $response['data']['message'] = "Creado correctamente";
        
    } else {
        $response['status'] = "error";
        $response['data']['message'] = "No se lograron cargar los archivos correctamente";
    }

    return json_encode($response);
}