<?php
require_once '../Homepage/session.php';
include("../Homepage/dbkupi.php");

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    
    // Check if username already exists
    $check_sql = "SELECT COUNT(*) AS COUNT FROM customer WHERE c_username = :c_username";
    $check_stmt = oci_parse($condb, $check_sql);
    oci_bind_by_name($check_stmt, ':c_username', $username);
    oci_execute($check_stmt);
    $row = oci_fetch_assoc($check_stmt);

    if ($row['COUNT'] > 0) {
        echo "User already registered!";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO customer (c_username, c_email, c_phonenum, c_pass, c_address) VALUES (:c_username, :c_email, :c_phonenum, :c_pass, :c_address)";
        $stmt = oci_parse($condb, $sql);

        // Bind variables
        oci_bind_by_name($stmt, ':c_username', $username);
        oci_bind_by_name($stmt, ':c_email', $email);
        oci_bind_by_name($stmt, ':c_phonenum', $phone);
        oci_bind_by_name($stmt, ':c_pass', $password);
        oci_bind_by_name($stmt, ':c_address', $address);
        
        // Execute the statement
        if (oci_execute($stmt)) {
            // Set session variables using setSession function
            setSession('custid', $row['CUSTID']);
            setSession('username', $username);
            setSession('password', $password);
            setSession('email', $email);
            setSession('phonenum', $phone);
            setSession('address', $address);

            // Redirect to the homepage
            header("Location: ../Homepage/index.php");
            exit();
        } else {
            // Display an error message
            $e = oci_error($stmt);
            echo "Failed to register: " . $e['message'];
        }

        // Free the statement
        oci_free_statement($stmt);
    }

    // Free the check statement
    oci_free_statement($check_stmt);
}
?>