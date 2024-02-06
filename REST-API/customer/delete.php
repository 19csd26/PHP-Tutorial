<?php

// Calling the basic header for the API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE'); // Allowed only for the DELETE method
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Including the functions defined in 'function.php'
include('function.php');

// Retrieving the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Checking that the method is DELETE
if ($requestMethod == "DELETE") {
    
        $deleteCustomer = deleteCustomer($_GET);
       
        echo $deleteCustomerList;
    
} else {
    // If the request method is not GET, return a 405 Method Not Allowed response
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    // Displaying the JSON response for the Method Not Allowed error
    echo json_encode($data);
}
