<?php  
session_start();  
include 'db.php'; // Include the database connection file  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $userType = $_POST['userType']; // Get user type (customer or staff)  
    $username = $_POST['username'];  
    $password = $_POST['password'];  

    // Establish a database connection  
    $conn = getConnection();  

    // Prepare the SQL statement based on user type  
    if ($userType === 'customer') {  
        $sql = 'SELECT * FROM CUSTOMER WHERE C_USERNAME = :username AND C_PASS = :password';  
    } else if ($userType === 'staff') {  
        $sql = 'SELECT * FROM STAFF WHERE S_USERNAME = :username AND S_PASS = :password';  
    } else {  
        // Handle unexpected user type  
        die("Invalid user type.");  
    }  

    $stmt = oci_parse($conn, $sql);  

    // Bind parameters  
    oci_bind_by_name($stmt, ':username', $username);  
    oci_bind_by_name($stmt, ':password', $password); // Note: Passwords should be hashed in a real application  

    // Execute the statement  
    oci_execute($stmt);  

    // Check if a user was found  
    if ($row = oci_fetch_array($stmt, OCI_ASSOC)) {  
        // Successful login  
        $_SESSION['username'] = $userType === 'customer' ? $row['C_USERNAME'] : $row['S_USERNAME'];  
        $_SESSION['userType'] = $userType; // Store user type in session  
        header('Location: index.php'); // Redirect to a welcome page  
        exit();  
    } else {  
        // Login failed  
        $error_message = "Invalid username or password.";  
    }  

    // Free the statement and close the connection  
    oci_free_statement($stmt);  
    oci_close($conn);  
}  
?>