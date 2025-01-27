<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.customer.php');
    exit;
}

$customerId = $_GET['id'];
$error = '';

// First verify if customer exists
$sql = "SELECT CUSTID FROM CUSTOMER WHERE CUSTID = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
oci_execute($stmt);
$customer = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$customer) {
    $_SESSION['error'] = "Customer not found.";
    header('Location: a.customer.php');
    exit;
}

// Check for related orders
$sql = "SELECT COUNT(*) as ORDER_COUNT FROM ORDERTABLE WHERE CUSTID = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
oci_execute($stmt);
$result = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if ($result['ORDER_COUNT'] > 0) {
    $_SESSION['error'] = "Cannot delete customer. Customer has existing orders.";
    header('Location: a.customer.php');
    exit;
}

// If no orders exist, proceed with deletion
$sql = "DELETE FROM CUSTOMER WHERE CUSTID = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
$result = oci_execute($stmt);

if ($result) {
    $_SESSION['success'] = "Customer deleted successfully.";
} else {
    $e = oci_error($stmt);
    $_SESSION['error'] = "Error deleting customer: " . $e['message'];
}

oci_free_statement($stmt);

// Redirect back to customer list
header('Location: a.customer.php');
exit;
?>
