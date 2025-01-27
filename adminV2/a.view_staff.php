<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.staff.php');
    exit;
}

$staffId = $_GET['id'];

// Get staff details
$sql = "SELECT * FROM STAFF WHERE STAFFID = :staffid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":staffid", $staffId);
oci_execute($stmt);
$staff = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$staff) {
    header('Location: a.staff.php');
    exit;
}

// Get staff's assigned orders
$sql = "
    SELECT 
        o.ORDERID,
        o.KUPIDATE,
        c.C_USERNAME as CUSTOMER_NAME,
        k.K_NAME,
        od.QUANTITY,
        o.KUPISIZE,
        o.KUPITYPE,
        o.KUPIBEAN,
        o.KUPIMILK,
        o.KUPICREAM,
        CASE 
            WHEN d.D_STATUS IS NOT NULL THEN d.D_STATUS
            WHEN p.P_STATUS IS NOT NULL THEN p.P_STATUS
            ELSE 'Processing'
        END as STATUS,
        od.SUBTOTAL
    FROM ORDERTABLE o
    JOIN CUSTOMER c ON o.CUSTID = c.CUSTID
    JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID
    JOIN KUPI k ON od.KUPIID = k.KUPIID
    LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
    LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    WHERE o.STAFFID = :staffid
    ORDER BY o.KUPIDATE DESC
";

$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":staffid", $staffId);
oci_execute($stmt);

$orders = array();
while ($row = oci_fetch_assoc($stmt)) {
    $orderId = $row['ORDERID'];
    if (!isset($orders[$orderId])) {
        $orders[$orderId] = array(
            'ORDERID' => $orderId,
            'KUPIDATE' => $row['KUPIDATE'],
            'CUSTOMER_NAME' => $row['CUSTOMER_NAME'],
            'STATUS' => $row['STATUS'],
            'ITEMS' => array(),
            'TOTAL_AMOUNT' => 0
        );
    }
    
    $itemDetails = $row['K_NAME'] . ' - ' .
                  'Size: ' . $row['KUPISIZE'] . 
                  ', Type: ' . $row['KUPITYPE'] .
                  ', Bean: ' . $row['KUPIBEAN'] . 
                  ', Milk: ' . $row['KUPIMILK'];
    
    if (!empty($row['KUPICREAM'])) {
        $itemDetails .= ', Cream: ' . $row['KUPICREAM'];
    }
    
    $itemDetails .= ' (' . $row['QUANTITY'] . ')';
    
    $orders[$orderId]['ITEMS'][] = $itemDetails;
    $orders[$orderId]['TOTAL_AMOUNT'] += $row['SUBTOTAL'];
}
oci_free_statement($stmt);

// Convert to indexed array
$orders = array_values($orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff Details</title>
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
        <!-- Staff Profile Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Staff Profile</h2>
                <a href="a.staff.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Staff ID</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($staff['STAFFID']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Username</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($staff['S_USERNAME']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($staff['S_EMAIL']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Phone Number</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($staff['S_PHONENUM']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Role</p>
                        <p class="font-semibold">
                            <span class="px-2 py-1 rounded text-sm <?php echo $staff['S_ROLE'] === 'Admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                                <?php echo htmlspecialchars($staff['S_ROLE']); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Section -->
        <div>
            <h2 class="text-pink-700 text-2xl font-bold mb-4">Assigned Orders History</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <?php if (count($orders) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-pink-100">
                            <thead class="bg-pink-100">
                                <tr>
                                    <th class="text-left px-4 py-2 border-b">Order ID</th>
                                    <th class="text-left px-4 py-2 border-b">Date</th>
                                    <th class="text-left px-4 py-2 border-b">Customer</th>
                                    <th class="text-left px-4 py-2 border-b">Items</th>
                                    <th class="text-center px-4 py-2 border-b">Total Amount</th>
                                    <th class="text-center px-4 py-2 border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr class="border-b hover:bg-pink-50">
                                        <td class="text-left px-4 py-2"><?php echo htmlspecialchars($order['ORDERID']); ?></td>
                                        <td class="text-left px-4 py-2"><?php echo date('Y-m-d H:i', strtotime($order['KUPIDATE'])); ?></td>
                                        <td class="text-left px-4 py-2"><?php echo htmlspecialchars($order['CUSTOMER_NAME']); ?></td>
                                        <td class="text-left px-4 py-2 whitespace-pre-line"><?php echo htmlspecialchars(implode("\n", $order['ITEMS'])); ?></td>
                                        <td class="text-center px-4 py-2">RM <?php echo number_format($order['TOTAL_AMOUNT'], 2); ?></td>
                                        <td class="text-center px-4 py-2">
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
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">No assigned orders found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
