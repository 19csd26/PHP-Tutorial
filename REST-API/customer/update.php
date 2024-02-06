<?php

error_reporting(0);
//calling the basic header for the api 
header('Access-Control-Allow-Orgin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT'); //allowed only for the PUT method 
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Header, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'PUT') {
    // Decode JSON data from the request body
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $storeCustomer = updateCustomer($_POST, $_GET);
    } else {
        // Call the storeCustomer function with the decoded data
        $storeCustomer = updateCustomer($inputData, $_GET);
    }
    echo $storeCustomer;
} else {
    // Return a Method Not Allowed response for non-POST requests
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
