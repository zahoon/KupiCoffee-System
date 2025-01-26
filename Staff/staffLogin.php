<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection parameters
    $username = "kupidb"; // Your Oracle database username
    $password = "kupidb"; // Your Oracle database password
    $connection_string = "localhost:1521/xe"; // Database name (TNS name or connection string)

    // Create connection
    $dbconn = oci_connect($username, $password, $connection_string);

    // Check connection
    if (!$dbconn) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    // Get the username and password from the form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare the SQL statement
    $sql = "SELECT S_USERNAME, S_ROLE FROM STAFF WHERE S_USERNAME = :username AND S_PASS = :password";
    $stmt = oci_parse($dbconn, $sql);

    // Bind parameters
    oci_bind_by_name($stmt, ':username', $user);
    oci_bind_by_name($stmt, ':password', $pass);

    // Execute the statement
    oci_execute($stmt);

    // Check if a matching record was found
    if (oci_fetch($stmt)) {
        // Fetch the role from the result
        $role = oci_result($stmt, 'S_ROLE'); // Fetch the S_ROLE column

        // Login successful
        $_SESSION['username'] = $user; // Store username in session
        $_SESSION['s_role'] = $role; // Store role in session
        echo $_SESSION['s_role'];

        // Redirect to the dashboard or another page based on role
        if ($role === 'admin') {
            header("Location: ../Admin/a.kupi.php"); // Redirect to admin dashboard
        } elseif ($role === 'staff') {
            header("Location: s.manageOrder.php"); // Redirect to staff dashboard
        } else {
            header("Location: ../Homepage/index.php"); // Redirect to default page for other roles
        }
        exit();
    } else {
        // Login failed
        $error = "Invalid username or password.";
        header("Location: s_login.php?error=" . urlencode($error)); // Redirect back to login with error
        exit();
    }

    // Free the statement and close the connection
    oci_free_statement($stmt);
    oci_close($dbconn);
}
?>