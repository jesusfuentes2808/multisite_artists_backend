<?php 

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
    
    $response = array();
    $response['data']['url'] = str_replace(WP_CONTENT_DIR, "local.com", $folder).$postType;
    
    if(file_put_contents($folder.$file_name, $data) !== false){
        $response['status'] = "ok";
        $response['data']['message'] = "Creado correctamente";
        
    } else {
        $response['status'] = "error";
        $response['data']['message'] = "No se lograron cargar los archivos correctamente";
    }
    
    return json_encode($response);
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
