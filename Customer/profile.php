<?php
include 'session.php';
include 'dbkupi.php';

// Check if the user is logged in
$custid = getSession('custid');
if (!$custid) {
    header('Location: login.html');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phonenum = $_POST['phonenum'];
    $email = $_POST['email'];

    // Prepare the SQL query to update the profile
    $sql = "UPDATE customer SET c_username = :c_username, c_phonenum = :c_phonenum, c_email = :c_email";
    if (!empty($password)) {
        $sql .= ", c_pass = :c_pass";
    }
    $sql .= " WHERE custid = :custid";

    $stmt = oci_parse($condb, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ':c_username', $username);
    oci_bind_by_name($stmt, ':c_phonenum', $phonenum);
    oci_bind_by_name($stmt, ':c_email', $email);
    if (!empty($password)) {
        oci_bind_by_name($stmt, ':c_pass', $password);
    }
    oci_bind_by_name($stmt, ':custid', $custid);

    // Execute the query
    oci_execute($stmt);

    // Update session data
    setSession('username', $username);
    setSession('phonenum', $phonenum);
    setSession('email', $email);
    if (!empty($password)) {
        setSession('password', $password);
    }

    // Redirect back to the profile page
    header('Location: edit_profile.php');
    exit();
}
?>