<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

// Pagination logic
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM ORDERTABLE";
$countStmt = oci_parse($condb, $countQuery);
oci_execute($countStmt);
$totalRow = oci_fetch_assoc($countStmt);
$totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);
oci_free_statement($countStmt);

// Fetch orders with details using pagination
$sql = "
    WITH OrderDetails AS (
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
            od.SUBTOTAL,
            CASE 
                WHEN d.D_STATUS IS NOT NULL THEN d.D_STATUS
                WHEN p.P_STATUS IS NOT NULL THEN p.P_STATUS
                ELSE 'Processing'
            END as STATUS,
            ROW_NUMBER() OVER (ORDER BY o.KUPIDATE DESC) AS rnum
        FROM ORDERTABLE o
        JOIN CUSTOMER c ON o.CUSTID = c.CUSTID
        JOIN ORDERDETAIL od ON o.ORDERID = od.ORDERID
        JOIN KUPI k ON od.KUPIID = k.KUPIID
        LEFT JOIN STAFF s ON o.STAFFID = s.STAFFID
        LEFT JOIN DELIVERY d ON o.ORDERID = d.ORDERID
        LEFT JOIN PICKUP p ON o.ORDERID = p.ORDERID
    )
    SELECT * FROM OrderDetails
    WHERE rnum > :offset AND rnum <= :end_row
";

$stmt = oci_parse($condb, $sql);
$endRow = $offset + $itemsPerPage;
oci_bind_by_name($stmt, ":offset", $offset);
oci_bind_by_name($stmt, ":end_row", $endRow);
oci_execute($stmt);

$orders = array();
while ($row = oci_fetch_assoc($stmt)) {
    $orderId = $row['ORDERID'];
    if (!isset($orders[$orderId])) {
        $orders[$orderId] = array(
            'ORDERID' => $orderId,
            'KUPIDATE' => $row['KUPIDATE'],
            'CUSTID' => $row['CUSTID'],
            'CUSTOMER_NAME' => $row['CUSTOMER_NAME'],
            'STAFFID' => $row['STAFFID'],
            'STAFF_NAME' => $row['STAFF_NAME'],
            'STATUS' => $row['STATUS'],
            'ITEMS' => array()
        );
    }
    
    $itemDetails = array(
        'K_NAME' => $row['K_NAME'],
        'KUPISIZE' => $row['KUPISIZE'],
        'KUPITYPE' => $row['KUPITYPE'],
        'KUPIBEAN' => $row['KUPIBEAN'],
        'KUPIMILK' => $row['KUPIMILK'],
        'QUANTITY' => $row['QUANTITY'],
        'SUBTOTAL' => $row['SUBTOTAL']
    );
    if (!empty($row['KUPICREAM'])) {
        $itemDetails['KUPICREAM'] = $row['KUPICREAM'];
    }
    
    $orders[$orderId]['ITEMS'][] = $itemDetails;
}
oci_free_statement($stmt);

// Get available staff for assignment
$staffSql = "SELECT STAFFID, S_USERNAME FROM STAFF ORDER BY S_USERNAME";
$staffStmt = oci_parse($condb, $staffSql);
oci_execute($staffStmt);
$staffList = array();
while ($row = oci_fetch_assoc($staffStmt)) {
    $staffList[] = $row;
}
oci_free_statement($staffStmt);

// Convert to indexed array
$orders = array_values($orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }
        .pagination a {
            width: 10px;
            height: 10px;
            background: rgb(114, 113, 113);
            border-radius: 50%;
            cursor: pointer;
        }
        .pagination a.active {
            background-color: #ec4899;
            color: white;
            border: 1px solid #ec4899;
        }
        .pagination a:hover:not(.active) {
            background-color: rgb(191, 41, 129);
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Order Management</h2>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php 
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php 
                        echo htmlspecialchars($_SESSION['success']);
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-pink-100">
                        <thead class="bg-pink-100">
                            <tr>
                                <th class="text-left px-4 py-2 border-b">Order ID</th>
                                <th class="text-left px-4 py-2 border-b">Date</th>
                                <th class="text-left px-4 py-2 border-b">Customer Info</th>
                                <th class="text-left px-4 py-2 border-b">Staff Info</th>
                                <th class="text-left px-4 py-2 border-b">Items</th>
                                <th class="text-center px-4 py-2 border-b">Status</th>
                                <th class="text-center px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr class="border-b hover:bg-pink-50">
                                    <td class="text-left px-4 py-2"><?php echo htmlspecialchars($order['ORDERID']); ?></td>
                                    <td class="text-left px-4 py-2"><?php echo date('Y-m-d H:i', strtotime($order['KUPIDATE'])); ?></td>
                                    <td class="text-left px-4 py-2">
                                        ID: <?php echo htmlspecialchars($order['CUSTID']); ?><br>
                                        <?php echo htmlspecialchars($order['CUSTOMER_NAME']); ?>
                                    </td>
                                    <td class="text-left px-4 py-2">
                                        <?php if ($order['STAFFID']): ?>
                                            ID: <?php echo htmlspecialchars($order['STAFFID']); ?><br>
                                            <?php echo htmlspecialchars($order['STAFF_NAME']); ?>
                                        <?php else: ?>
                                            <span class="text-gray-500">Not assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-left px-4 py-2">
                                        <?php foreach ($order['ITEMS'] as $item): ?>
                                            <div class="mb-2">
                                                <?php echo htmlspecialchars($item['K_NAME']); ?> (×<?php echo htmlspecialchars($item['QUANTITY']); ?>)<br>
                                                <small class="text-gray-600">
                                                    Size: <?php echo htmlspecialchars($item['KUPISIZE']); ?>,
                                                    Type: <?php echo htmlspecialchars($item['KUPITYPE']); ?>,
                                                    Bean: <?php echo htmlspecialchars($item['KUPIBEAN']); ?>,
                                                    Milk: <?php echo htmlspecialchars($item['KUPIMILK']); ?>
                                                    <?php if (isset($item['KUPICREAM'])): ?>
                                                        , Cream: <?php echo htmlspecialchars($item['KUPICREAM']); ?>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        <?php endforeach; ?>
                                    </td>
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
                                    <td class="text-center px-4 py-2">
                                        <a href="a.view_order.php?id=<?php echo $order['ORDERID']; ?>" 
                                           class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mb-1">
                                            View
                                        </a>
                                        <?php if (!$order['STAFFID']): ?>
                                            <a href="a.assign_order.php?id=<?php echo $order['ORDERID']; ?>" 
                                               class="inline-block px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 mb-1">
                                                Assign
                                            </a>
                                        <?php endif; ?>
                                        <a href="a.delete_order.php?id=<?php echo $order['ORDERID']; ?>" 
                                           class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                           onclick="return confirm('Are you sure you want to delete this order?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = $i === $currentPage ? 'active' : '';
                        echo "<a href='?page=$i' class='$activeClass'></a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
