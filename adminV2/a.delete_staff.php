<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.staff.php');
    exit;
}

$staffId = $_GET['id'];

// First verify if staff exists
$sql = "SELECT STAFFID, S_ROLE FROM STAFF WHERE STAFFID = :staffid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":staffid", $staffId);
oci_execute($stmt);
$staff = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$staff) {
    $_SESSION['error'] = "Staff not found.";
    header('Location: a.staff.php');
    exit;
}

// Check if this is the last admin
if ($staff['S_ROLE'] === 'Admin') {
    $sql = "SELECT COUNT(*) as ADMIN_COUNT FROM STAFF WHERE S_ROLE = 'Admin'";
    $stmt = oci_parse($condb, $sql);
    oci_execute($stmt);
    $result = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    if ($result['ADMIN_COUNT'] <= 1) {
        $_SESSION['error'] = "Cannot delete the last admin account.";
        header('Location: a.staff.php');
        exit;
    }
}

// Check for assigned orders that are still in progress
$sql = "
    SELECT COUNT(*) as ORDER_COUNT 
    FROM ORDERTABLE o
    LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
    LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    WHERE o.STAFFID = :staffid
    AND (
        d.D_STATUS IN ('Pending', 'Processing')
        OR p.P_STATUS IN ('Pending', 'Processing')
        OR (d.D_STATUS IS NULL AND p.P_STATUS IS NULL)
    )
";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":staffid", $staffId);
oci_execute($stmt);
$result = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if ($result['ORDER_COUNT'] > 0) {
    $_SESSION['error'] = "Cannot delete staff. Staff has pending or in-progress orders.";
    header('Location: a.staff.php');
    exit;
}

// If no pending orders exist, proceed with deletion
$sql = "DELETE FROM STAFF WHERE STAFFID = :staffid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":staffid", $staffId);
$result = oci_execute($stmt);

if ($result) {
    $_SESSION['success'] = "Staff deleted successfully.";
} else {
    $e = oci_error($stmt);
    $_SESSION['error'] = "Error deleting staff: " . $e['message'];
}

oci_free_statement($stmt);

// Redirect back to staff list
header('Location: a.staff.php');
exit;
?>
