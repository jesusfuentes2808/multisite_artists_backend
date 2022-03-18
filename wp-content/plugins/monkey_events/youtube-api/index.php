<?php

function getYoutube($listId, $type='playlist'){
    /*$arrListId = [];
    for($i = 0 ; $i < count($listId); $i++){
        array_push($arrListId, 'id='+youtube_ids[i]);
    }
    
    var_dump(join('&', $arrListId));*/
    //array_youtube_ids = array_youtube_ids.join('&');

    $ch = curl_init();
    //https://api.spotify.com/v1/playlists/
    //https://youtube.googleapis.com/youtube/v3/playlistItems?part=contentDetails%20&playlistId=PLanrn6bPgjsbWdA7MPfyLAZS1D-byCfVb&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM
    //curl_setopt($ch, CURLOPT_URL,"https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&id=" . $listId . "&maxResults=10&key=AIzaSyA5hWJ8FJrTZr412seBlVgzCIoykzBm8yM");
    curl_setopt($ch, CURLOPT_URL,"https://youtube.googleapis.com/youtube/v3/playlists?part=snippet%20&id=" . $listId . "&maxResults=10&key=AIzaSyBb1Ay4v3-KeQajZtTIY8aqAyCaWDIIw-0");
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