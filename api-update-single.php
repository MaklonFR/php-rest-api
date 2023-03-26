<?php
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With"); 

include ('function.php');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "PUT") {
    $inputData = json_decode(file_get_contents("php://input"),TRUE);
    if (empty($inputData)) {
        $updateSoal = updateSoal($_POST, $_GET); 
    }
    else{
        $updateSoal = updateSoal($inputData, $_GET);
    }
        echo $updateSoal;
}
else {
    $data = [
        'status'    => 405,
        'message'   => $requestMethod. "Method Not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>