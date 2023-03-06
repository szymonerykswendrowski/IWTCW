<?php

header('Content-type: application/json');

$result = array();

if ($_GET['file'] === 'default') {
    $error = ["error" => "error, no file selected"];
    echo json_encode($error);
    exit();
}

// Case when only file is selected
if (isset($_GET['file']) && $_GET['file'] != ''
    && empty($_GET['year']) && $_GET['tournament'] === 'Any'
    && empty($_GET['winner']) && empty($_GET['runner-up'])) {
    $file = $_GET['file'];
    $json = file_get_contents($file);
    $decoded_json = json_decode($json, true);

    foreach($decoded_json as $item) {
        $result[] = [
            "year"  => $item['year'],
            "tournament" => $item['tournament'],
            "winner" => $item['winner'],
            "runnerUp" => $item['runner-up']
        ];
        }
        echo json_encode($result);
}

?>