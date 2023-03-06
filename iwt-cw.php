<?php

header('Content-type: application/json');

// Helper function for yearOp
function operand ($var1, $op, $var2) {

    switch ($op) {
        case "=":  return $var1 === $var2;
        case ">":  return $var1 >  $var2;
        case "<":  return $var1 <  $var2;
    default:       return true;
    }
}

$result = array();

// File not selected error
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

else {
    $file = $_GET['file'];
    $json = file_get_contents($file);
    $decoded_json = json_decode($json, true);
    $year = $_GET['year'];
    $yearint = intval($year);
    $yearOp = $_GET['yearOp'];
    $tournament = $_GET['tournament'];
    $winner = $_GET['winner'];
    $runnerUp = $_GET['runnerUp'];

    // Year out of range error
    if (($file === 'mens-grand-slam-winners.json' && ($yearint < 1877 || $yearint > 2022))
        || ($file === 'womens-grand-slam-winners.json' && ($yearint < 1884 || $yearint > 2022))) {
        $error = ["error" => "error, year out of range"];
        echo json_encode($error);
        exit();
    }

    // if ($tournament === 'Any') {
        foreach($decoded_json as $item) {
            // foreach($array as $item) {
                if ((operand($item['year'], $yearOp, $yearint) || $year == "") 
                    && ($item['winner'] == $winner || $winner == "")
                    && ($item['runner-up'] == $runnerUp || $runnerUp == "")) {
                        $result[] = [
                            "year"  => $item['year'],
                            "tournament" => $item['tournament'],
                            "winner" => $item['winner'],
                            "runnerUp" => $item['runner-up']
                        ];
                }
            // }
        } echo json_encode($result);  
        // var_dump($result); 
    // }
           
}
// Put the required data into the result array with the
// appropriate keys

?>