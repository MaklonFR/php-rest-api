<?php  
    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-type,Access-Control-Allow-Origin, Authorization, X-Requested-With"); 
    
    include ('function.php');
    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if ($requestMethod == "GET") {
        $soalList = getSoalList();
        echo $soalList;
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