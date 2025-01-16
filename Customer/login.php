<?php
include("session.php");
include("dbkupi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to check the credentials
    $sql = "SELECT * FROM customer WHERE c_username = :c_username AND c_pass = :c_pass";
    $stmt = oci_parse($condb, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ':c_username', $username);
    oci_bind_by_name($stmt, ':c_pass', $password);

    // Execute the query
    oci_execute($stmt);

    // Fetch the result
    $row = oci_fetch_assoc($stmt);
    if ($row) {
        // Set session data
        setSession('custid', $row['custid']);
        setSession('username', $row['c_username']);
        setSession('password', $row['c_pass']);
        setSession('phonenum', $row['c_phonenum']);
        setSession('email', $row['c_email']);
        setSession('address', $row['c_address']);

        // Redirect to the menu page
        header("Location: ../Cust/index.php");
        exit();
    } else {
        // Debugging output
        echo "Login failed! No matching user found.";

        // Redirect to the admin page on login failure
        header("Location: ../Cust/MeetOurTeam.php");
        exit();
    }

    // Free the statement
    oci_free_statement($stmt);
}

?>