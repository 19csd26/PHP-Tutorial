<?php

// Calling the basic header for the API
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: GET'); // Allowed only for the GET method
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// Including the functions defined in 'function.php'
include('function.php');

// Retrieving the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Checking that the method is GET
if ($requestMethod == "GET") {
    // Checking if 'id' is set in the GET parameters
    if (isset($_GET['id'])) {
        $customer = getCustomer($_GET);
        echo $customer;
    } else {
        // Calling the 'getCustomerList' function to retrieve the customer list
        $customerList = getCustomerList();
        // Displaying the retrieved customer list as JSON
        echo $customerList;
    }
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
