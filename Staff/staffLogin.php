<?php  
session_start(); // Start the session  

// Check if the form is submitted  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    // Database connection parameters  
    $username = "kupidb"; // Your Oracle database username  
    $password = "kupidb"; // Your Oracle database password  
    $connection_string = "localhost:1521/xe";; // Database name (TNS name or connection string)  

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
    $sql = "SELECT * FROM STAFF WHERE S_USERNAME = :username AND S_PASS = :password";  
    $stmt = oci_parse($dbconn, $sql);  
    oci_bind_by_name($stmt, ':username', $username);  
    oci_bind_by_name($stmt, ':password', $password);  
    oci_execute($stmt);    

    // Bind parameters  
    oci_bind_by_name($stmt, ':username', $user);  
    oci_bind_by_name($stmt, ':password', $pass);  

    // Execute the statement  
    oci_execute($stmt);  

    // Check if a matching record was found  
    if (oci_fetch($stmt)) {  
        // Login successful  
        $_SESSION['username'] = $user; // Store username in session  
        header("Location: s.manageOrder.php"); // Redirect to the dashboard or another page  
        exit();  
    } else {  
        // Login failed  
        $error = "Invalid username or password.";  
        header("Location: s_login.php?error=" . urlencode($error)); // Redirect back to login with error  
        exit();  
    }  

    // Free the statement and close the connection  
    oci_free_statement($stmt);  
    oci_close($conn);  
}  
?>