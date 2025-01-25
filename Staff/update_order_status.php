<?php  
// update_order_status.php  

// Database connection  
$username = "kupidb"; // Your Oracle database username  
$password = "kupidb"; // Your Oracle database password  
$connection_string = "localhost:1521/xe"; // Database connection string  

// Create connection  
$dbconn = oci_connect($username, $password, $connection_string);  

if (!$dbconn) {  
    $e = oci_error();  
    die("Connection failed: " . $e['message']);  
}  

// Get the order ID and status from the request  
$orderId = $_POST['orderId'];  
$status = $_POST['status'];  

// Prepare the update statement  
$sql = "UPDATE PICKUP SET P_STATUS = :status WHERE ORDERID = :orderId";  
$stmt = oci_parse($dbconn, $sql);  

// Bind parameters  
oci_bind_by_name($stmt, ':status', $status);  
oci_bind_by_name($stmt, ':orderId', $orderId);  

// Execute the statement  
if (oci_execute($stmt)) {  
    echo json_encode(['success' => true]);  
} else {  
    echo json_encode(['success' => false, 'error' => oci_error($stmt)]);  
}  

// Free statement and close connection  
oci_free_statement($stmt);  
oci_close($dbconn);  
?>