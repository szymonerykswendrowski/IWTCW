<?php

header('Content-type: application/json');

// Helper function for yearOp that returns
// the appropriate operator between two
// variables.
function operand ($var1, $op, $var2) {
    switch ($op) {
        case "=":  return $var1 === $var2;
        case ">":  return $var1 >  $var2;
        case "<":  return $var1 <  $var2;
    default:       return true;
    }
}

// Array to store results.
$result = array();

// File not selected error:
if ($_GET['file'] === 'default') {
    $error = ["error" => "error, no file selected"];
    echo json_encode($error);
    exit();
}

// Case when only file is selected:
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

// All the other cases:
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

    // Year out of range error:
    // ($year != '' at the end to ensure
    // that when the form is cleared
    // you don't get a false error).
    if (($file === 'mens-grand-slam-winners.json' && ($yearint < 1877 || $yearint > 2022) && $year != '')
        || ($file === 'womens-grand-slam-winners.json' && ($yearint < 1884 || $yearint > 2022) && $year != '')) {
        $error = ["error" => "error, year out of range"];
        echo json_encode($error);
        exit();
    }

    // Case for all tournaments:
    if ($tournament === 'Any') {
        foreach($decoded_json as $item) {
                if ((operand($item['year'], $yearOp, $yearint) || $year === "") 
                    && (stripos($item['winner'], $winner) === 0 || $winner === "")
                    && (stripos($item['runner-up'],$runnerUp) === 0 || $runnerUp === "")) {
                        $result[] = [
                            "year"  => $item['year'],
                            "tournament" => $item['tournament'],
                            "winner" => $item['winner'],
                            "runnerUp" => $item['runner-up']
                        ];
                }
        } echo json_encode($result);  
    }

    // Case for a specific tournament:
    else {
        foreach($decoded_json as $item) {
        if ((operand($item['year'], $yearOp, $yearint) || $year === "") 
            && (stripos($item['winner'], $winner) === 0 || $winner === "")
            && (stripos($item['runner-up'], $runnerUp) === 0 || $runnerUp === "")
            && ($item['tournament'] === $tournament)) {
                $result[] = [
                    "year"  => $item['year'],
                    "tournament" => $item['tournament'],
                    "winner" => $item['winner'],
                    "runnerUp" => $item['runner-up']
                ];
            }
        } echo json_encode($result);  
    }      
    // || $i === '' conditions ensure that if year, winner or runnerUp
    // are blank the query is still executed.
}

?>