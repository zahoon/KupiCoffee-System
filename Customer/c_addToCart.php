<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $milk = $_POST['milk'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $cream = $_POST['cream'];
    $bean = $_POST['bean'];
    $date = $_POST['date'];

    // Retrieve customer and staff information from the session
    $custid = getSession('custid'); // Assuming there is a custid in the session
    $staffid = getSession('staffid'); // Assuming there is a staffid in the session

    // Check if custid is set
    if ($custid === null) {
        echo "Customer ID is not set in the session.";
        exit;
    }

    // Insert the data into the database
    $sql = "INSERT INTO ORDERTABLE (kupimilk, kupitype, kupisize, kupicream, kupibean, kupidate, custid, staffid) 
            VALUES (:kupimilk, :kupitype, :kupisize, :kupicream, :kupibean, TO_DATE(:kupidate, 'YYYY-MM-DD'), :custid, :staffid)";
    $stmt = oci_parse($condb, $sql);

    // Bind variables
    oci_bind_by_name($stmt, ':kupimilk', $milk);
    oci_bind_by_name($stmt, ':kupitype', $type);
    oci_bind_by_name($stmt, ':kupisize', $size);
    oci_bind_by_name($stmt, ':kupicream', $cream);
    oci_bind_by_name($stmt, ':kupibean', $bean);
    oci_bind_by_name($stmt, ':kupidate', $date);
    oci_bind_by_name($stmt, ':custid', $custid);
    oci_bind_by_name($stmt, ':staffid', $staffid);

    // Execute the statement
    if (oci_execute($stmt)) {
        echo "Order successfully added to the cart!";
    } else {
        $e = oci_error($stmt);
        echo "Failed to add order to the cart: " . $e['message'];
    }

    // Free the statement
    oci_free_statement($stmt);
}

oci_close($condb);
?>