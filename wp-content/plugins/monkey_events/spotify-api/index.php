<?php

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

