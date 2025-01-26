<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!$condb) {
    die("Database connection failed!"); // Extra safety check
}

// Insert data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);

    // SQL query to insert data
    $sql = "INSERT INTO KUPI (k_name, k_price, k_desc) VALUES (:k_name, :k_price, :k_desc)";
    $stmt = oci_parse($condb, $sql);

    // Bind parameters
    oci_bind_by_name($stmt, ":k_name", $name);
    oci_bind_by_name($stmt, ":k_price", $price);
    oci_bind_by_name($stmt, ":k_desc", $description);
    // Execute the query
    $result = oci_execute($stmt);

    if ($result) {
        echo "Kupi added successfully!";
    } else {
        $error = oci_error($stmt);
        echo "Failed to insert kupi: " . htmlspecialchars($error['message']);
    }

    // Free the statement
    oci_free_statement($stmt);
}

// Close the connection (optional; script termination will also close it)
oci_close($condb);
?>