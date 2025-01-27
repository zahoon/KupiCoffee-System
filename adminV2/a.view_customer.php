<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.customer.php');
    exit;
}

$customerId = $_GET['id'];

// Get customer details
$sql = "SELECT * FROM CUSTOMER WHERE CUSTID = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
oci_execute($stmt);
$customer = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$customer) {
    header('Location: a.customer.php');
    exit;
}

// Get customer's order history
$sql = "
    SELECT 
        o.ORDERID,
        o.KUPIDATE,
        k.K_NAME,
        k.K_DESC,
        od.QUANTITY,
        od.SUBTOTAL,
        o.KUPIMILK,
        o.KUPITYPE,
        o.KUPISIZE,
        o.KUPICREAM,
        o.KUPIBEAN,
        CASE 
            WHEN d.D_STATUS IS NOT NULL THEN d.D_STATUS
            WHEN p.P_STATUS IS NOT NULL THEN p.P_STATUS
            ELSE 'Processing'
        END as STATUS
    FROM ORDERTABLE o
    JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID
    JOIN KUPI k ON od.KUPIID = k.KUPIID
    LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
    LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    WHERE o.CUSTID = :custid
    ORDER BY o.KUPIDATE DESC
";

$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
oci_execute($stmt);

$orders = array();
$currentOrder = null;

while ($row = oci_fetch_assoc($stmt)) {
    $orderId = $row['ORDERID'];
    
    if (!isset($orders[$orderId])) {
        $orders[$orderId] = array(
            'ORDERID' => $orderId,
            'KUPIDATE' => $row['KUPIDATE'],
            'STATUS' => $row['STATUS'],
            'ITEMS' => array(),
            'TOTAL_AMOUNT' => 0
        );
    }
    
    // Add item details
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

// Convert the associative array to indexed array
$orders = array_values($orders);

// Function to format order items for display
function formatOrderItems($items) {
    return implode("\n", $items);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer Details</title>
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
        <!-- Customer Profile Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Customer Profile</h2>
                <a href="a.customer.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Customer ID</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($customer['CUSTID']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Username</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($customer['C_USERNAME']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($customer['C_EMAIL']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Phone Number</p>
                        <p class="font-semibold"><?php echo htmlspecialchars($customer['C_PHONENUM']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order History Section -->
        <div>
            <h2 class="text-pink-700 text-2xl font-bold mb-4">Order History</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <?php if (count($orders) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-pink-100">
                            <thead class="bg-pink-100">
                                <tr>
                                    <th class="text-left px-4 py-2 border-b">Order ID</th>
                                    <th class="text-left px-4 py-2 border-b">Date</th>
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
                                        <td class="text-left px-4 py-2 whitespace-pre-line"><?php echo htmlspecialchars(formatOrderItems($order['ITEMS'])); ?></td>
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
                    <p class="text-gray-500 text-center py-4">No order history found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
