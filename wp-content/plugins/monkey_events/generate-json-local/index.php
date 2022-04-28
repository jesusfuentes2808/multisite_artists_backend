<?php

function makeDirectoryNews($category){
    if (!is_dir(WP_CONTENT_DIR . '/json/')) {
        mkdir(WP_CONTENT_DIR . '/json/');
    }

    if (!is_dir(WP_CONTENT_DIR . '/json/news')) {
        mkdir(WP_CONTENT_DIR . '/json/news');
    }

    $folder = WP_CONTENT_DIR . '/json/news/'.$category.'/';

    $args = array(
        'post_type' => 'news',
        'posts_per_page' => 10,
        'orderby' => array(
            'date' => 'DESC',
        ),
        'post_status' => array('publish'),
        'tax_query' => array(
            array (
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $category,
            )
        )
    );

    if (!is_dir($folder)) {
        mkdir($folder);
    }

    $query = new WP_Query($args);
    $posts_query = $query->posts;

    $posts = array();
    $response = null;

    foreach ($posts_query as $post) {
        $dataParent = array();
        //array_push($posts, $post);
        $dataParent['post'] = get_post($post->ID);
        $dataParent['post_thumbnail'] = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        array_push($posts, $dataParent);
    }

    $response['items'] = $posts;
    $data = json_encode($response);

    $file_name = $category . '.json';

    $response = array();

    if (file_put_contents($folder . $file_name, $data) !== false) {
        $response['status'] = "ok";
        $response['data']['message'] = "Creado correctamente";

    } else {
        $response['status'] = "error";
        $response['data']['message'] = "No se lograron cargar los archivos correctamente";
    }

    return json_encode($response);
}

function makeDirectory($postType, $keyArtist = null)
{
    if (!is_dir(WP_CONTENT_DIR . '/json/')) {
        mkdir(WP_CONTENT_DIR . '/json/');
    }

    $type = '';

    if (is_null($keyArtist)) {
        //$folder = get_template_directory() . '/assets/json/'.$postType.'/';   
        $folder = WP_CONTENT_DIR . '/json/' . $postType . '/';

        $type = 'tracks';
        $args = array();
        $dataParent = null;

        if ($postType === 'page_artist_item') {

            $argsParent = array(
                'post_type' => 'page_artist_week',
                'posts_per_page' => 1,
                'orderby' => array(
                    'date' => 'DESC',
                )
            );

            $meta_query = new WP_Query($argsParent);

            if ($meta_query->have_posts()) {
                $meta_query->the_post();
                $postId = get_the_ID();
                $title = get_the_title();
                $content = get_the_content();

                $dataParent['post'] = get_post($postId);
                $dataParent['post_thumbnail'] = wp_get_attachment_url(get_post_thumbnail_id($postId));

                $meta_query->the_post();
                $artistId = get_the_ID();

                $args = array(
                    'post_type' => 'page_artist_item',
                    'posts_per_page' => 6,
                    'orderby' => array(
                        'date' => 'DESC',
                    ),
                    'meta_query' => array(
                        array(
                            'key' => 'artist_week_id',
                            'value' => $postId,
                            'compare' => '=',
                        )
                    ),
                );
            }

        } else {

            $args = array(
                'post_type' => $postType,
                'posts_per_page' => 10,
                'orderby' => array(
                    'date' => 'DESC',
                ),
                'post_status' => array('publish'),
            );
        }

    } else {
        //$folder = get_template_directory() . '/assets/json/'.$keyArtist['name'].'/';
        $folder = WP_CONTENT_DIR . '/json/' . $keyArtist['name'] . '/';

        $args = array(
            'post_type' => $postType,
            'posts_per_page' => 10,
            'orderby' => array(
                'date' => 'DESC',
            ),
            'post_status' => array('publish'),
            'meta_query' => array(
                array(
                    'key' => 'pagina_artista_id',
                    'value' => $keyArtist['id'],
                    'compare' => '=',
                )
            ),
        );

        $type = "playlists";
    }

    if (!is_dir($folder)) {
        mkdir($folder);
    }

    $data = createJSON($args, $type, $dataParent);

    $file_name = $postType . '.json';

    $response = array();
    $response['data']['url'] = str_replace(WP_CONTENT_DIR, "local.com", $folder) . $postType;

    if (file_put_contents($folder . $file_name, $data) !== false) {
        $response['status'] = "ok";
        $response['data']['message'] = "Creado correctamente";

    } else {
        $response['status'] = "error";
        $response['data']['message'] = "No se lograron cargar los archivos correctamente";
    }

    return json_encode($response);
}


function createJSON($args, $type, $dataParent = null)
{
    $token = getToken();

    $query = new WP_Query($args);

    $posts_query = $query->posts;

    $posts = array();
    $response = null;
    $postIdMain = -1;


    /*if($type === 'tracks'){
        $posts['post'] = get_post( $postIdMain );
        $posts['post_thumbnail'] =  wp_get_attachment_url(get_post_thumbnail_id( $postIdMain ));
    }*/
    //var_dump($dataParent);

    if ($dataParent !== null) {
        $posts['post'] = $dataParent['post'];
        $posts['post_thumbnail'] = $dataParent['post_thumbnail'];

        foreach ($posts_query as $index => $post) {
            $posts['items'][$index]['title'] = $post->post_title;
            $posts['items'][$index]['track_id'] = get_field('track_id', $post->ID);
            $posts['items'][$index]['response'] = json_decode(getSpotify($token, get_field('track_id', $post->ID), $type));
        }

        $response = $posts;
    } else {
        foreach ($posts_query as $index => $post) {
            //$posts['items'][$index]['title']          =   $post->post_title;
            $posts[$index]['title'] = $post->post_title;

            if ($type === 'tracks') {
                $posts[$index]['track_id'] = get_field('track_id', $post->ID);
            } else {
                $posts[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
            }


            if ($type === 'tracks') {
                $posts[$index]['response'] = json_decode(getSpotify($token, get_field('track_id', $post->ID), $type));
            } else if ($type === 'playlists' && $args['post_type'] === 'playlist_yt') {
                $posts[$index]['response'] = json_decode(getYoutube(get_field('codigo_de_playlist', $post->ID)));
            } else if ($type === 'playlists' && $args['post_type'] === 'playlist_sp') {
                $posts[$index]['response'] = json_decode(getSpotify($token, get_field('codigo_de_playlist', $post->ID), $type));
            }
        }

        wp_reset_query();

        $response['items'] = $posts;
    }

    //$data['items'][$index]['title']

    $data = json_encode($response, JSON_UNESCAPED_UNICODE);

    return $data;
}
