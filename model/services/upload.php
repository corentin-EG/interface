<?php

header('Content-Type: text/plain; charset=utf-8');

var_dump($_FILES);

try {

    if (!isset($_FILES['asset']))
        throw new RuntimeException('Invalid parameters.');

    switch ($_FILES['asset']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    if ($_FILES['asset']['size'] > 1000000)
        throw new RuntimeException('Exceeded filesize limit.');

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $ext = array_search(
                $finfo->file($_FILES['asset']['tmp_name']),
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            );
   
    if ($ext === false)
        throw new RuntimeException('Invalid file format.');

    $move = !move_uploaded_file(
                $_FILES['asset']['tmp_name'],
                sprintf('././asset/gamesbrandrunner/upload/%s.%s',
                    sha1_file($_FILES['asset']['tmp_name']),
                    $ext)
            );

    if ($move)
        throw new RuntimeException('Failed to move uploaded file.');

    echo json_encode(
        array( 
            'result' => $fileGuid,
            'error' => null 
        )
    );

} catch (RuntimeException $e) {

    echo $e->getMessage();

}