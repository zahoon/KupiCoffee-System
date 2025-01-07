<?php

include("dbkupi.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Prepare the SQL query to check the credentials
    $sql = "SELECT * FROM customer WHERE c_username = :c_username AND c_pass = :c_pass";
    $stmt = oci_parse($condb, $sql);

    // Bind the parameters
    oci_bind_by_name($stmt, ':c_username', $input_username);
    oci_bind_by_name($stmt, ':c_pass', $input_password);

    // Execute the query
    oci_execute($stmt);

    // Fetch the result
    if ($row = oci_fetch_assoc($stmt)) {
        echo "Login successful!";
        header("Menu.html");
    } else {
        echo "Login failed!";
        header("admin.html");
    }

    // Free the statement
    oci_free_statement($stmt);
}

?>