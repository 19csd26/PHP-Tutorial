<?php

require '../inc/dbcon.php';

/**
 * Sends a JSON response with the specified status code and data.
 *
 * @param int $statusCode The HTTP status code for the response.
 * @param array $data The data to be included in the response.
 */
function sendResponse($statusCode, $data)
{
    header("HTTP/1.0 $statusCode");

    // Log errors here if needed

    echo json_encode($data);
    exit();
}

/**
 * Handles validation and storing of customer data in the database.
 *
 * @param array $customerInput The input data for the customer.
 */
function storeCustomer($customerInput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    // Additional input validation for email
    if (empty(trim($name)) || empty(trim($email)) || empty(trim($phone)) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return sendResponse(422, ['status' => 422, 'message' => 'Valid name, email, and phone are required']);
    }

    // Using prepared statements to prevent SQL injection
    $query = "INSERT INTO customers(name, email, phone) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);

    if (mysqli_stmt_execute($stmt)) {
        $data = [
            'status' => 201,
            'message' => 'Customer Created Successfully',
        ];
        sendResponse(201, $data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        sendResponse(500, $data);
    }

    mysqli_stmt_close($stmt);
}

/**
 * Retrieves the list of customers from the database.
 */
function getCustomerList()
{
    global $conn;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res
            ];
            sendResponse(200, $data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            sendResponse(404, $data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        sendResponse(500, $data);
    }
}

/**
 * Retrieves customer details based on the provided ID.
 *
 * @param array $customerParams The parameters for retrieving customer details.
 */
function getCustomer($customerParams)
{
    global $conn;

    if (empty($customerParams['id']) || !is_numeric($customerParams['id'])) {
        $data = [
            'status' => 422,
            'message' => 'Valid Customer ID is required',
        ];
        return sendResponse(422, $data);
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $query = "SELECT * FROM customers WHERE id=?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $customerId);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Customer Fetched Successfully',
                'data' => $res
            ];
            sendResponse(200, $data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found'
            ];
            sendResponse(404, $data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
        sendResponse(500, $data);
    }

    mysqli_stmt_close($stmt);
}

function updateCustomer($customerInput, $customerParams)
{
    global $conn;

    if (!isset($customerParams['id']) || !is_numeric($customerParams['id'])) {
        $data = [
            'status' => 422,
            'message' => 'Valid Customer ID is required',
        ];
        return sendResponse(422, $data);
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    // Additional input validation for email
    if (empty(trim($name)) || empty(trim($email)) || empty(trim($phone)) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return sendResponse(422, ['status' => 422, 'message' => 'Valid name, email, and phone are required']);
    }

    // Using prepared statements to prevent SQL injection
    $query = "UPDATE customers SET name=?, email=?, phone=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $customerId);

    if (mysqli_stmt_execute($stmt)) {
        $data = [
            'status' => 200,
            'message' => 'Customer Updated Successfully',
        ];
        sendResponse(200, $data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
        sendResponse(500, $data);
    }

    mysqli_stmt_close($stmt);
}

function deleteCustomer($customerParams)
{
    global $conn;

    // Validate if 'id' parameter is set and is a numeric value
    if (!isset($customerParams['id']) || !is_numeric($customerParams['id'])) {
        $data = [
            'status' => 422,
            'message' => 'Valid Customer ID is required',
        ];
        return sendResponse(422, $data);
    }
    // Sanitize the customer ID
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    // Prepare and execute the DELETE query using a prepared statement
    $query = "DELETE FROM customers WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $customerId);

    if (mysqli_stmt_execute($stmt)) {
        // If deletion is successful, send a 204 No Content response
        $data = [
            'status' => 204,
            'message' => 'Customer Deleted Successfully',
        ];
        sendResponse(204, $data);
    } else {

        // If customer not found or deletion fails, send a 404 Not Found or 500 Internal Server Error response
        $data = [
            'status' => 404,
            'message' => 'Customer Not Found',
        ];
        sendResponse(404, $data);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}
