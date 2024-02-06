<?php

error_reporting(0);
//calling the basic header for the api 
header('Access-Control-Allow-Orgin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST'); //allowed only for the POST method 
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Header, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'POST') {
    // Decode JSON data from the request body
    $inputData = json_decode(file_get_contents("php://input"), true);
    if (empty($inputData)) {
        $storeCustomer = storeCustomer($_POST);
    } else {
        // Call the storeCustomer function with the decoded data
        $storeCustomer = storeCustomer($inputData);
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
