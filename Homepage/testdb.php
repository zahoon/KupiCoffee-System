<?php

// Database configuration
$host = "localhost"; // Replace with your Oracle DB host
$port = "1521";      // Replace with your Oracle DB port
$sid = "xe";         // Replace with your Oracle SID or Service Name
$username = "kupidb"; // Replace with your Oracle username
$password = "kupidb"; // Replace with your Oracle password

// Create a connection string
$connection_string = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
    (CONNECT_DATA = (SID = $sid))
)";

// Connect to Oracle database
$conn = oci_connect($username, $password, $connection_string);

if (!$conn) {
    $error = oci_error();
    echo "Connection failed: " . $error['message'];
} else {
    echo "Oracle database connected successfully!";
}

// Close the connection
oci_close($conn);

?>