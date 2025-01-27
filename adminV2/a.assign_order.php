<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.orders.php');
    exit;
}

$orderId = $_GET['id'];
$error = '';
$success = '';

// Get order details
$sql = "
    SELECT 
        o.ORDERID,
        o.KUPIDATE,
        o.CUSTID,
        c.C_USERNAME as CUSTOMER_NAME,
        o.STAFFID,
        s.S_USERNAME as STAFF_NAME,
        o.KUPIBEAN,
        o.KUPIMILK,
        o.KUPISIZE,
        o.KUPITYPE,
        o.KUPICREAM,
        k.K_NAME,
        od.QUANTITY,
        CASE 
            WHEN d.D_STATUS IS NOT NULL THEN d.D_STATUS
            WHEN p.P_STATUS IS NOT NULL THEN p.P_STATUS
            ELSE 'Processing'
        END as STATUS
    FROM ORDERTABLE o
    JOIN CUSTOMER c ON o.CUSTID = c.CUSTID
    JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID
    JOIN KUPI k ON od.KUPIID = k.KUPIID
    LEFT JOIN STAFF s ON o.STAFFID = s.STAFFID
    LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
    LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    WHERE o.ORDERID = :orderid
";

$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
oci_execute($stmt);

$order = null;
$items = array();
while ($row = oci_fetch_assoc($stmt)) {
    if (!$order) {
        $order = $row;
    }
    $itemDetails = $row['K_NAME'] . ' - ' .
                  'Size: ' . $row['KUPISIZE'] . 
                  ', Type: ' . $row['KUPITYPE'] .
                  ', Bean: ' . $row['KUPIBEAN'] . 
                  ', Milk: ' . $row['KUPIMILK'];
    if (!empty($row['KUPICREAM'])) {
        $itemDetails .= ', Cream: ' . $row['KUPICREAM'];
    }
    $itemDetails .= ' (×' . $row['QUANTITY'] . ')';
    $items[] = $itemDetails;
}
oci_free_statement($stmt);

if (!$order) {
    header('Location: a.orders.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffId = trim($_POST['staff_id']);

    if (empty($staffId)) {
        $error = "Please select a staff member";
    } else {
        // Update order with new staff assignment
        $sql = "UPDATE ORDERTABLE SET STAFFID = :staffid WHERE ORDERID = :orderid";
        $stmt = oci_parse($condb, $sql);
        oci_bind_by_name($stmt, ":staffid", $staffId);
        oci_bind_by_name($stmt, ":orderid", $orderId);
        $result = oci_execute($stmt);
        
        if ($result) {
            $_SESSION['success'] = "Staff assigned successfully";
            header('Location: a.orders.php');
            exit;
        } else {
            $e = oci_error($stmt);
            $error = "Error assigning staff: " . $e['message'];
        }
        oci_free_statement($stmt);
    }
}

// Get available staff
$staffSql = "SELECT STAFFID, S_USERNAME, S_ROLE FROM STAFF ORDER BY S_USERNAME";
$staffStmt = oci_parse($condb, $staffSql);
oci_execute($staffStmt);
$staffList = array();
while ($row = oci_fetch_assoc($staffStmt)) {
    $staffList[] = $row;
}
oci_free_statement($staffStmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Staff to Order</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Assign Staff to Order</h2>
                <a href="a.orders.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to Orders</a>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Order Details -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Order Details</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-gray-600">Order ID</p>
                            <p class="font-semibold"><?php echo htmlspecialchars($order['ORDERID']); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Date</p>
                            <p class="font-semibold"><?php echo date('Y-m-d H:i', strtotime($order['KUPIDATE'])); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Customer</p>
                            <p class="font-semibold">
                                ID: <?php echo htmlspecialchars($order['CUSTID']); ?><br>
                                <?php echo htmlspecialchars($order['CUSTOMER_NAME']); ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Status</p>
                            <p class="font-semibold">
                                <span class="px-2 py-1 rounded text-sm
                                    <?php 
                                    switch($order['STATUS']) {
                                        case 'Pending':
                                            echo 'bg-yellow-100 text-yellow-800';
                                            break;
                                        case 'Completed':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'Cancelled':
                                            echo 'bg-red-100 text-red-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?php echo htmlspecialchars($order['STATUS']); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-600 mb-2">Items</p>
                        <div class="pl-4 border-l-2 border-pink-200">
                            <?php foreach ($items as $item): ?>
                                <p class="mb-1"><?php echo htmlspecialchars($item); ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Staff Assignment Form -->
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-1">Select Staff</label>
                        <select id="staff_id" name="staff_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                            <option value="">Select a staff member</option>
                            <?php foreach ($staffList as $staff): ?>
                                <option value="<?php echo htmlspecialchars($staff['STAFFID']); ?>">
                                    <?php echo htmlspecialchars($staff['S_USERNAME']); ?> 
                                    (<?php echo htmlspecialchars($staff['S_ROLE']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                            Assign Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
