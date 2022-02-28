<?php
/**
 * Plugin Name: Excel Download
 * Plugin URI: https://www.facebook.com/jesusMFC
 * Description: Este plugln descarga de excel
 * Version: 1.0.0
 * Author: Jesus Fuentes
 * Author URI: https://www.facebook.com/jesusMFC
 *
 * Text Domain: wpplugin
 * Domain path: /
 */


function get_artists_all_columns_excel(){
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

add_filter('init', 'get_artists_all_columns_excel');



add_action( 'load-edit.php', function() {
    add_filter( 'views_edit-contact_user', 'talk_tabs' ); // talk is my custom post type
});

# echo the tabs
function talk_tabs() {
    global $artistAllInit;

    $select = "<option value='all'>Todos</option>";


    foreach ($artistAllInit as $label => $value){
        $select .= "<option value='" . $value->ID . "' >". $value->post_title . " </option>";
    }

    echo '
            <div style="width:100%; text-align: right; margin-bottom: 20px;">
                <div style="">
                    <input id="start_date" name="start_date" type="text" placeholder="Fecha inicio" class="date_picker">
                    <input id="end_date" name="end_date" type="text" placeholder="Fecha fin" class="date_picker">
                    <select name="artist_id" id="artist_id">
                       '.$select.'
                    </select>
                    <a href="#" id="download_excel">Descargar excel</a>
                </div>
            </div>
            <script type="text/javascript">
                jQuery("#download_excel").on("click", function(e) {
                    e.preventDefault();
                    const url = "'.get_home_url().'?section=excel&artist_id=" + jQuery("#artist_id").val() +"&start_date=" + jQuery("#start_date").val()+"&end_date=" + jQuery("#end_date").val();
                    window.open(url, "_blank");
                });
                jQuery(".date_picker").datepicker({
                        dateFormat : "yy-mm-dd"
                    }).datepicker("setDate", "today");
            </script>
     ';
}

function wpse_enqueue_datepicker() {
    // Load the datepicker script (pre-registered in WordPress).
    wp_register_script( 'jquery-ui-datepicker_v', 'https://code.jquery.com/ui/1.13.1/jquery-ui.js' );
    wp_enqueue_script( 'jquery-ui-datepicker_v' );

    // You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
    wp_register_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
    wp_enqueue_style( 'jquery-ui' );
}

add_action( 'init', 'wpse_enqueue_datepicker' );


add_action( 'template_redirect', 'apicall' );


function apicall() {

    $callapi = $_GET['section'];
    $artist_id = $_GET['artist_id'];
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];

    if($callapi=='excel'){

        header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
        header('Content-Disposition: attachment; filename=nombre_archivo.xls');

        $args = array (
            'post_type'      => 'contact_user',
            'posts_per_page' => -1,
            'orderby'   => array(
                'start_date' => 'ASC',
                'start_time' => 'ASC'
            ),
            'meta_query'	=> array(),
        );

        if($artist_id != 'all'){
            array_push($args['meta_query'], array(
                'key'	 	=> 'artist_id',
                'value'	  	=> $artist_id,
                'compare' 	=> '=',
            ));
        }

        if($startDate != '' && $endDate != ''){
            $args['date_query'] = array(
                'column' => 'post_date',
                'after' => $startDate,
                'before' => $endDate
            );
        }


        $meta_query= new WP_Query($args);
        $posts = $meta_query->posts;

        $body = '';
        foreach($posts as $index => $post) {
            /*var_dump($post);
            echo "<pre>";
            var_dump($post->post_title);
            var_dump($post->post_content);
            var_dump(get_field('name', $post->ID));
            var_dump(get_field('email', $post->ID));
            var_dump(get_field('telephone', $post->ID));
            var_dump(get_field('artist_id', $post->ID));
            echo "</pre>";*/
            $body .= ' 
            <tr>
                <td>'.$post->post_title.'</td>
                <td>'.get_field('email', $post->ID).'</td>
                <td>'.get_field('telephone', $post->ID).'</td>
                <td>'.$post->post_content.'</td>
                <td>'.get_field('artist_id', $post->ID).'</td>
                <td>'.$post->post_date.'</td>
            </tr>
            ';
            //$data[$index]['title']          =   $post->post_title;
            //$data[$index]['codigo_de_playlist'] = get_field('codigo_de_playlist', $post->ID);
        }

        echo '
        <table border="1" cellpadding="2" cellspacing="0" width="100%">
            <tr>
                <td>Nombre</td>
                <td>Email</td>
                <td>Telefono</td>
                <td>Mensaje</td>
                <td>Artista</td>
                <td>Fecha</td>
            </tr>
            '.$body.'
        </table>
        ';

        exit;
    }
}




