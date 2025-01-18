<?php  

include("dbkupi.php");  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Get the username and password from the form  
    $input_username = $_POST['username'];  
    $input_password = $_POST['password'];  

    // Prepare the SQL query to check the credentials  
    $sql = "SELECT * FROM staff WHERE s_username = :s_username AND s_pass = :s_pass";  
    $stmt = oci_parse($condb, $sql);  

    // Bind the parameters  
    oci_bind_by_name($stmt, ':s_username', $input_username);  
    oci_bind_by_name($stmt, ':s_pass', $input_password);  

    // Execute the query  
    oci_execute($stmt);  

    // Fetch the result  
    if ($row = oci_fetch_assoc($stmt)) {  
        // Check if the user is an admin  
        if ($row['s_role'] === 'admin') { // Assuming 'c_role' is the column that indicates user role  
            echo "Admin login successful!";  
            header("Location: admin.html"); // Redirect to admin dashboard  
            exit();  
        } else {  
            echo "Login successful!";  
            header("Location: home.html"); // Redirect to user dashboard  
            exit();  
        }  
    } else {  
        echo "Login failed!";  
        header("Location: login.html"); // Redirect back to login page  
        exit();  
    }  

    // Free the statement  
    oci_free_statement($stmt);  
}  

?>