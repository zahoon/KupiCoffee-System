<?php
include("dbkupi.php");
// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    // Check if username or email already exists
    $check_sql = "SELECT COUNT(*) AS COUNT FROM customer WHERE c_username = :c_username OR c_email = :c_email";
    $check_stmt = oci_parse($condb, $check_sql);
    oci_bind_by_name($check_stmt, ':c_username', $username);
    oci_bind_by_name($check_stmt, ':c_email', $email);
    oci_execute($check_stmt);
    $row = oci_fetch_assoc($check_stmt);

    if ($row['COUNT'] > 0) {
        // echo false alert that showed user alr existed
        echo "User already registered!";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO customer (c_username, c_email, c_phonenum, c_pass) VALUES (:c_username, :c_email, :c_phonenum, :c_pass)";
        $stmt = oci_parse($condb, $sql);

        // Bind variables
        oci_bind_by_name($stmt, ':c_username', $username);
        oci_bind_by_name($stmt, ':c_email', $email);
        oci_bind_by_name($stmt, ':c_phonenum', $phone);
        oci_bind_by_name($stmt, ':c_pass', $password);
        
        // Execute the statement
        if (oci_execute($stmt)) {
            echo "Registration successful! Welcome, $username!";
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