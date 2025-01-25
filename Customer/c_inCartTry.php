<?php
require_once '../Homepage/dbkupi.php'; // Ensure database connection

// Retrieve customer ID from the session
$custid = getSession('custid'); // Assuming there is a custid in the session
$staffid = getSession('staffid'); // Assuming there is a staffid in the session

if ($custid === null) {
    echo "Customer ID is not set in the session.";
    exit;
}

// Fetch orders for the customer from the database
$sql = "SELECT kupimilk, kupitype, kupisize, kupicream, kupibean, kupidate FROM ORDERTABLE WHERE custid = :custid";
$stmt = oci_parse($condb, $sql);

// Bind the customer ID
oci_bind_by_name($stmt, ':custid', $custid);

// Execute the query
oci_execute($stmt);

// Fetch all results
$orders = [];
while ($row = oci_fetch_assoc($stmt)) {
    $orders[] = $row;
}

// Free the statement
oci_free_statement($stmt);

// Close the database connection
oci_close($condb);
?>