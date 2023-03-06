<?php

header('Content-type: application/json');

$result = array();

if (isset($_GET['file']) && $_GET['file'] != '') {
    $file = $_GET['file'];
    $json = file_get_contents($file);
    $decoded_json = json_decode($json, true);
}

foreach($decoded_json as $item) {
    $result[] = $item['year'];
    }
    echo json_encode($result);

?>