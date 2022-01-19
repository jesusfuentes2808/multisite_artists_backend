<?php
function fn_enviar_files_remote($url, $nameDirectory, $nameFile = ''){
    $folder = WP_CONTENT_DIR . '/json/'.$nameDirectory.'/';   
    $fileName = '';
    
    if($nameFile !== ''){
        $fileName = $folder . $nameFile . '.json';
    } else {
        $fileName = $folder . $nameDirectory . '.json';
    }

    $fileSize = filesize($fileName);

    if(!file_exists($fileName)) {
        $out['status'] = 'error';
        $out['message'] = 'File not found.';
        exit(json_encode($out));
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $finfo = finfo_file($finfo, $fileName);

    $cFile = new CURLFile($fileName, $finfo, basename($fileName));
    $data = array( "file" => $cFile, "filename" => $cFile->postname);

    $lastCharUrl = substr($url, -1);
    $lastCharUrl = ($lastCharUrl === '/') ? '' : '/';
    $url = $url.$lastCharUrl;

    $curl = curl_init( $url."enpoint.php" );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // This is not mandatory, but is a good practice.
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            'Content-Type: multipart/form-data'
        )
    );
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_INFILESIZE, $fileSize);

    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}
