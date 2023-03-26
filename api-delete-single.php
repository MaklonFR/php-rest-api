<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With"); 
    
    include ('function.php');
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod == "DELETE") {
            $deleteSoal = deleteSoal($_GET);
            echo $deleteSoal;
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