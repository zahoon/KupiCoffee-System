<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.orders.php');
    exit;
}

$orderId = $_GET['id'];

// First verify if order exists and get its status
$sql = "
    SELECT o.ORDERID, 
           CASE 
               WHEN d.D_STATUS IS NOT NULL THEN d.D_STATUS
               WHEN p.P_STATUS IS NOT NULL THEN p.P_STATUS
               ELSE 'Processing'
           END as STATUS
    FROM ORDERTABLE o
    LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
    LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    WHERE o.ORDERID = :orderid
";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
oci_execute($stmt);
$order = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$order) {
    $_SESSION['error'] = "Order not found.";
    header('Location: a.orders.php');
    exit;
}

// Check if order can be deleted (not completed)
if ($order['STATUS'] === 'Completed') {
    $_SESSION['error'] = "Cannot delete completed orders.";
    header('Location: a.orders.php');
    exit;
}

// Begin transaction
$success = true;

// Delete from delivery table if exists
$sql = "DELETE FROM DELIVERY WHERE ORDERID = :orderid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
if (!oci_execute($stmt)) {
    $success = false;
    $error = oci_error($stmt);
}
oci_free_statement($stmt);

// Delete from pickup table if exists
$sql = "DELETE FROM PICKUP WHERE ORDERID = :orderid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
if (!oci_execute($stmt)) {
    $success = false;
    $error = oci_error($stmt);
}
oci_free_statement($stmt);

// Delete from orderdetail table
$sql = "DELETE FROM ORDERDETAIL WHERE ORDERID = :orderid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
if (!oci_execute($stmt)) {
    $success = false;
    $error = oci_error($stmt);
}
oci_free_statement($stmt);

// Finally delete from ordertable
$sql = "DELETE FROM ORDERTABLE WHERE ORDERID = :orderid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
if (!oci_execute($stmt)) {
    $success = false;
    $error = oci_error($stmt);
}
oci_free_statement($stmt);

if ($success) {
    $_SESSION['success'] = "Order deleted successfully.";
} else {
    $_SESSION['error'] = "Error deleting order: " . $error['message'];
}

// Redirect back to orders list
header('Location: a.orders.php');
exit;
?>
