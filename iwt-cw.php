<?php

header('Content-type: application/json');

$result = array();

// Tests if file is empty, if not gets the file name and decodes
// the corresponding json file.
if (isset($_GET['file']) && $_GET['file'] != '') {
    $file = $_GET['file'];
    $json = file_get_contents($file);
    $decoded_json = json_decode($json, true);
}

// Put the required data into the result array with the
// appropriate keys
foreach($decoded_json as $item) {
    $result[] = [
        "year"  => $item['year'],
        "tournament" => $item['tournament'],
        "winner" => $item['winner'],
        "runnerUp" => $item['runner-up']
    ];
    }
    echo json_encode($result);

?>