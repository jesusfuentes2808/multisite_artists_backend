<?php

function create_image_institution_country_table()
{
    global $wpdb;

    $tblname = 'image_institution_country';
    $wp_track_table = $wpdb->prefix . "$tblname";

    #Check to see if the table exists already, if not, then create it

    $sql = "CREATE TABLE IF NOT EXISTS `". $wp_track_table . "` ( ";
    $sql .= "  `id`  int   NOT NULL auto_increment, ";
    $sql .= "  `code`  varchar(255)   NOT NULL, ";
    $sql .= "  `institution`  varchar(255)   NOT NULL, ";
    $sql .= "  `country`  varchar(255)   NOT NULL, ";
    $sql .= "  `created_at`  datetime DEFAULT CURRENT_TIMESTAMP NOT NULL, ";
    $sql .= "  `updated_at`  datetime DEFAULT CURRENT_TIMESTAMP NOT NULL, ";
    $sql .= "  PRIMARY KEY `order_id` (`id`) ";
    $sql .= ") ENGINE=MyISAM DEFAULT CHARSET={$wpdb->charset} AUTO_INCREMENT=1 ; ";
    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

    var_dump($sql);
    exit();
    dbDelta($sql);
}

