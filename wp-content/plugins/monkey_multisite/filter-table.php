<?php
// Listar todos los artistas
function get_artists_all_columns_init(){
    global $artistAllInit;
    $args = array (
        'post_type'      => 'page_artist',
        'posts_per_page' => -1,
        'orderby'   => array(
            'date' =>'DESC',
        )
    );

    $query = new WP_Query( $args );
    $posts_query = $query->posts;
    $artistAllInit = $posts_query;
}

add_filter('init', 'get_artists_all_columns_init');


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////Adicionar Filtros de Artista Página/////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Adicionar columna
add_filter('manage_edit-playlist_yt_columns', 'add_artist_column');
add_filter('manage_edit-playlist_sp_columns', 'add_artist_column');

function add_artist_column($columns) {
    $custom_col_order = array(
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'code' => __( 'Código Playlist', 'textdomain' ),
        'pagina_artista_id' => __( 'Artista', 'textdomain' ),
        'date' => $columns['date']
    );
    //$columns['pagina_artista_id'] = 'Artista';
    return $custom_col_order;
}

add_filter('manage_edit-page_artist_week_columns', 'add_page_artist_week_column');

function add_page_artist_week_column($columns) {
    $custom_col_order = array(
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'image' => __('Imagen', ''),
        'date' => $columns['date']
    );
    //$columns['pagina_artista_id'] = 'Artista';
    return $custom_col_order;
}

add_filter('manage_edit-in_trend_columns', 'add_in_trend_column');
add_filter('manage_edit-ranking_columns', 'add_in_trend_column');
add_filter('manage_edit-page_artist_item_columns', 'add_in_trend_column');

function add_in_trend_column($columns) {
    $custom_col_order = array(
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'track_id' => __( 'Código Pista', 'textdomain' ),
        'date' => $columns['date']
    );
    //$columns['pagina_artista_id'] = 'Artista';
    return $custom_col_order;
}


add_filter('manage_edit-page_artist_columns', 'add_content_artist_column');

function add_content_artist_column($columns) {
    $custom_col_order = array(
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'image' => __('Imagen', ''),
        'url' => __( 'URL', 'textdomain' ),
        'code' => __( 'Código Artista', 'textdomain' ),
        'video_youtube_id' => __( 'Video Youtube', 'textdomain' ),
        'date' => $columns['date']
    );

    return $custom_col_order;
}

// Adicionar contenido de artista: Se
add_action('manage_playlist_yt_posts_custom_column',  'content_column');
add_action('manage_playlist_sp_posts_custom_column',  'content_column');

function content_column($name) {
    global $post;
    global $artistAllInit;

    $posts_query = $artistAllInit;

    $listArtists = array_map(function ($item) {
        $arr['id'] = $item->ID;
        $arr['name'] = $item->ID . ' | ' . $item->post_title;
        return $arr;
    }, $posts_query);


    switch ($name) {
        case 'code':
            echo get_post_meta($post->ID, 'codigo_de_playlist')[0];
            break;
        case 'pagina_artista_id':
            $artistId = get_post_meta($post->ID, 'pagina_artista_id')[0];
            $artistSearch = array_search($artistId, array_column($listArtists, 'id')) ? array_search($artistId, array_column($listArtists, 'id')) : 'delete-artist';
            $content = $listArtists[$artistSearch]['name'];
            echo $content;
            break;

    }
}


add_action('manage_page_artist_posts_custom_column',  'content_column_page_artist');

function content_column_page_artist($name) {
    global $post;

    switch ($name) {
        case 'image':
            if (has_post_thumbnail($post->ID)){
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                $image = $image[0];
            } else {
                $image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Imagen_no_disponible.svg/1200px-Imagen_no_disponible.svg.png';
            }
            echo "<img width='200' src='$image' alt='product'>";
            break;
        case 'code':
            $code = get_post_meta($post->ID, 'codigo')[0];
            echo $code;
            break;
        case 'url':
            $url = get_post_meta($post->ID, 'url')[0];
            echo "<a href='$url' target='_blank' >$url</a>";
            break;
        case 'video_youtube_id':
            $youtube = get_post_meta($post->ID, 'video_youtube_id')[0];
            //echo '<iframe width="200" height="200" src="https://www.youtube.com/embed/'.$youtube.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
            echo "<a href='#' onclick='openRequestedPopup$post->ID(event)'>$youtube</a>";
            echo '<script>function openRequestedPopup'.$post->ID.'(e) {
                        e.preventDefault();
                        windowObjectReference = window.open(
                            "https://www.youtube.com/watch?v='.$youtube.'",
                            "DescriptiveWindowName",
                            "width=736,height=500,scrollbars,status"
                            //"resizable,scrollbars,status"
                        );
                    }
                    </script>';
            break;
        default:
            echo $name;
            echo '----';
            break;

    }
}


add_action('manage_page_artist_week_posts_custom_column',  'content_column_page_artist_week');


function content_column_page_artist_week($name)
{
    global $post;

    switch ($name) {
        case 'image':
            if (has_post_thumbnail($post->ID)) {
                $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail');
                $image = $image[0];
            } else {
                $image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/Imagen_no_disponible.svg/1200px-Imagen_no_disponible.svg.png';
            }
            echo "<img width='200' src='$image' alt='product'>";
            break;

    }
}



//PECHE

add_filter('manage_edit-contact_user_columns', 'add_contact_user_column');

function add_contact_user_column($columns) {
    $custom_col_order = array(
        //'cb' => $columns['cb'],
        'title' => $columns['title'],
        'email' => __( 'Email', 'textdomain' ),
        'telephone' => __( 'Teléfono', 'textdomain' ),
        'pagina_artista_id' => __( 'Código Artista', 'textdomain' ),
        'date' => $columns['date']
    );
    //$columns['pagina_artista_id'] = 'Artista';
    return $custom_col_order;
}

add_action('manage_contact_user_posts_custom_column',  'content_column_page_contact_user');

//manage_page_artist_posts_custom_column
function content_column_page_contact_user($name)
{
    global $post;

    global $artistAllInit;

    $posts_query = $artistAllInit;

    $listArtists = array_map(function ($item) {
        $arr['id'] = $item->ID;
        $arr['name'] = $item->ID . ' | ' . $item->post_title;
        return $arr;
    }, $posts_query);


    switch ($name) {
        case 'pagina_artista_id':
            $artistId = get_post_meta($post->ID, 'artist_id')[0];
            $artistSearch = array_search($artistId, array_column($listArtists, 'id')) ? array_search($artistId, array_column($listArtists, 'id')) : 'delete-artist';
            $content = $listArtists[$artistSearch]['name'];
            echo $content;
            break;
        case 'telephone':
            echo get_post_meta($post->ID, 'telephone')[0];;
            break;
       case 'email':
            echo get_post_meta($post->ID, 'email')[0];;
            break;

    }
}


add_action('manage_in_trend_posts_custom_column',  'content_column_page_in_trend');
add_action('manage_ranking_posts_custom_column',  'content_column_page_in_trend');
add_action('manage_page_artist_item_posts_custom_column',  'content_column_page_in_trend');

function content_column_page_in_trend($name) {
    global $post;

    switch ($name) {
        case 'track_id':
            $code = get_post_meta($post->ID, 'track_id')[0];
            echo $code . '<br/><iframe style="border-radius:12px" src="https://open.spotify.com/embed/track/'.$code.'?utm_source=generator" width="200" height="100" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>';
            break;
    }
}



// Adicionar el orden a las columnas el ícono y enlace en cabecera
add_filter("manage_edit-playlist_yt_sortable_columns", 'column_artist_sort');
add_filter("manage_edit-playlist_sp_sortable_columns", 'column_artist_sort');

function column_artist_sort($columns) {
    $custom = array(
        'pagina_artista_id' 	=> 'pagina_artista_id',
    );
    return wp_parse_args($custom, $columns);
}



// Realizar el ORDERBY a las columnas y el filtrado
//add_filter( 'request', 'artist_column_orderby' );
function artist_column_orderby( $vars ) {
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


function order_column_artista($defaults) {
    $new = array();
    $tags = $defaults['pagina_artista_id'];  // save the tags column
    unset($defaults['pagina_artista_id']);   // remove it from the columns list

    foreach($defaults as $key => $value) {
        if($key=='date') {  // when we find the date column
            $new['pagina_artista_id'] = $tags;  // put the tags column before it
        }
        $new[$key]=$value;
    }

    return $new;
}
add_filter('manage_posts_columns', 'order_column_artista');


//Seleccionar query y verificar el orden
add_filter( 'parse_query', 'prefix_parse_filter' );
function  prefix_parse_filter($query) {

    global $pagenow;
    $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
    $typeQuery = $query->query['post_type'];
    $listPostType = ['playlist_yt', 'playlist_sp'];

    //only add filter to post type you want

    //MAIN
    /*$query->set('meta_query', array(
        array(
            'key' => 'pagina_artista_id',
            'compare' => '=',
            'value' => 18
        )
    ));*/

    /*var_dump( is_admin() &&
        'playlist_yt' == $current_page &&
        'edit.php' == $pagenow &&
        $typeQuery == 'playlist_yt' &&
        isset( $_GET['s'] )
    );*/

    //var_dump(isset($_GET['ADMIN_FILTER_FIELD_VALUE']));
    //var_dump($query->is_main_query() && $typeQuery == 'playlist_yt' && isset($_GET['ADMIN_FILTER_FIELD_VALUE']));
    if(
        $query->is_main_query() &&
        in_array($typeQuery , $listPostType) &&
        (isset($_GET['filter_artist']) && is_numeric($_GET['filter_artist']) && !empty($_GET['filter_artist']))
    ){
        $query->set('meta_query', array(
            array(
                'key' => 'pagina_artista_id',
                'compare' => '=',
                'value' => $_GET['filter_artist']
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


add_action( 'restrict_manage_posts', 'add_filter_artist' );

function add_filter_artist(){
    $type = 'post';
    global $artistAllInit;

    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    $listPostType = ['playlist_yt', 'playlist_sp'];

    //only add filter to post type you want
    if (in_array($type, $listPostType)){
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = $artistAllInit;

        $listArtists = array_map(function ($item) {
            $arr['id'] = $item->ID;
            $arr['name'] = $item->ID . ' | ' . $item->post_title;
            return $arr;
        }, $values );
        ?>
        <select name="filter_artist">
            <option value=""><?php _e('Filtrar por artista', 'wose45436'); ?></option>
            <?php
            $current_v = isset($_GET['filter_artist'])? $_GET['filter_artist']:'';
            foreach ($listArtists as $label => $value) {
                echo "<option value='" . $value['id'] . "' ". ($value['id'] == $current_v ? ' selected="selected"':'') .">". $value['name'] . " </option>";
            }
            ?>
        </select>
        <?php
    }
}



