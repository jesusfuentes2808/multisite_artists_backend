<?php

function sql_institucion_pais(){
    global $wpdb;
    $select_instituciones = "SELECT DISTINCT {$wpdb->prefix}bp_xprofile_data.value
                            FROM {$wpdb->prefix}users 
                            JOIN {$wpdb->prefix}usermeta 
                            ON {$wpdb->prefix}users.ID = {$wpdb->prefix}usermeta.user_id 
                            JOIN {$wpdb->prefix}bp_xprofile_data
                            ON {$wpdb->prefix}bp_xprofile_data.user_id = {$wpdb->prefix}users.ID
                            WHERE {$wpdb->prefix}usermeta.meta_key = 'wpxu_capabilities' 
                            AND {$wpdb->prefix}usermeta.meta_value LIKE '%miembros%'
                            AND {$wpdb->prefix}bp_xprofile_data.field_id = 1
                            AND {$wpdb->prefix}users.user_status = 0";

    $select_instituciones_result = $wpdb->get_results($select_instituciones);

    $select_instituciones_result = array_map(function($item){
        return $item->value;
    }, $select_instituciones_result  );

    $instituciones = array();
    foreach($select_instituciones_result as $index => $institucion){
        $instituciones[$index]['institucion'] = $institucion;
        $select_country = "SELECT DISTINCT value 
                FROM `{$wpdb->prefix}bp_xprofile_data` 
                WHERE user_id IN (SELECT DISTINCT user_id 
                                    FROM `{$wpdb->prefix}bp_xprofile_data` 
                                    WHERE value = '$institucion' AND 
                                    field_id = 1) 
                AND field_id = 3";

        $select_country_result = $wpdb->get_results($select_country);
        foreach ($select_country_result  as $index_inner => $country){
            $instituciones[$index]['pais'][$index_inner ] = $country->value;
        }

    }

    return $instituciones;
}
