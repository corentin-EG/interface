<?php

// initialise the curl request
$request = curl_init('localhost/interface/model/services/upload.php');

// send a file
curl_setopt($request, CURLOPT_POST, true);
curl_setopt(
    $request,
    CURLOPT_POSTFIELDS,
    array(
      'asset' => '@' . realpath('deliveroo.png') . ';finename=asset.png'
    ));

// output the response
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($request);

// close the session
curl_close($request);
