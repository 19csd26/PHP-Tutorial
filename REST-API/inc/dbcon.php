<?php
    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "phptutorial";

    // Establishing a connection to the MySQL database
    $conn = mysqli_connect($host, $username, $password, $dbname);
    
    // Checking if the connection is successfully established
    if (!$conn) {
        // If the connection fails, display an error message and terminate the script
        die("Connection Failed: " . mysqli_connect_error());
    }
?>
