<?php
// Include required files for session management and database connection
require_once '../Homepage/session.php';
include("../Homepage/dbkupi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to validate the username and password
    $sql = "SELECT * FROM customer WHERE c_username = :c_username AND c_pass = :c_pass";
    $stmt = oci_parse($condb, $sql);

    oci_bind_by_name($stmt, ':c_username', $username);
    oci_bind_by_name($stmt, ':c_pass', $password);

    oci_execute($stmt);

    // If a matching user is found
    if ($row = oci_fetch_assoc($stmt)) {
        // Set session variables
        setSession('custid', $row['CUSTID']);
        setSession('username', $row['C_USERNAME']);
        setSession('password', $row['C_PASS']);
        setSession('phonenum', $row['C_PHONENUM']);
        setSession('email', $row['C_EMAIL']);
        setSession('address', $row['C_ADDRESS']);

        // Redirect to the homepage or dashboard
        header("Location: ../Homepage/index.php");
        exit();
    } else {
        // Login failed, set error message
        $_SESSION['error'] = "Incorrect username or password.";
        header("Location: c_login.php");
        exit();
    }

    oci_free_statement($stmt);
}
?>