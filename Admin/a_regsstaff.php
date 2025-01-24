<?php
// Include the necessary files
require_once '../Homepage/session.php'; // for session handling
require_once '../Homepage/dbkupi.php'; // for database connection

// Get form data
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $adminid = null; // Default value for staff role

    // Hash the password for security
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Ensure password is hashed

    // Set adminid for admin role
    if ($role == 'admin') {
        $adminid = 1; // Set adminid to 1 for Admin role
    }

    // Create SQL query for Oracle
    $sql = "INSERT INTO staff (s_username, s_pass, s_phonenum, s_email, adminid) 
            VALUES (:username, :password, :phone, :email, :adminid)";

    // Prepare the Oracle statement
    $stmt = oci_parse($condb, $sql);

    // Bind the variables to the statement
    oci_bind_by_name($stmt, ":username", $username);
    oci_bind_by_name($stmt, ":password", $password);
    oci_bind_by_name($stmt, ":phone", $phone);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":adminid", $adminid);

    // Execute the statement
    if (oci_execute($stmt)) {
        // Success: Redirect to login page after a short delay
        echo "
        <div class='fixed top-0 right-0 mt-4 mr-4 max-w-xs w-full bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md'>
            <strong class='font-bold'>Success!</strong>
            <span>Your staff member has been successfully registered.</span>
        </div>
        ";

        // Redirect to the login page after the success message is shown
        header("refresh:2;url=../Staff/s_login.php");  // Redirect after 2 seconds
        exit;  // Ensure no further code is executed
    } else {
        $error = oci_error($stmt);
        echo "Error: " . $error['message'];
    }

    // Close the statement and connection
    oci_free_statement($stmt);
    oci_close($condb);
}
