<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.kupi.php');
    exit;
}

$kupiId = $_GET['id'];

// First check if KUPI exists
$checkSql = "SELECT KUPIID, K_NAME FROM KUPI WHERE KUPIID = :id";
$stmt = oci_parse($condb, $checkSql);
oci_bind_by_name($stmt, ":id", $kupiId);
oci_execute($stmt);
$kupi = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$kupi) {
    $_SESSION['error'] = "KUPI not found";
    header('Location: a.kupi.php');
    exit;
}

// Check if KUPI is referenced in any orders
$checkOrderSql = "SELECT COUNT(*) as count FROM ORDERDETAIL WHERE KUPIID = :id";
$stmt = oci_parse($condb, $checkOrderSql);
oci_bind_by_name($stmt, ":id", $kupiId);
oci_execute($stmt);
$result = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if ($result['COUNT'] > 0) {
    $_SESSION['error'] = "Cannot delete KUPI because it is referenced in orders";
    header('Location: a.kupi.php');
    exit;
}

// Delete the KUPI
$deleteSql = "DELETE FROM KUPI WHERE KUPIID = :id";
$stmt = oci_parse($condb, $deleteSql);
oci_bind_by_name($stmt, ":id", $kupiId);

if (oci_execute($stmt)) {
    $_SESSION['success'] = "KUPI '" . htmlspecialchars($kupi['K_NAME']) . "' deleted successfully";
} else {
    $e = oci_error($stmt);
    $_SESSION['error'] = "Error deleting KUPI: " . htmlspecialchars($e['message']);
}

oci_free_statement($stmt);
header('Location: a.kupi.php');
exit;
?>
