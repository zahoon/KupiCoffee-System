<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!isset($_GET['id'])) {
    header('Location: a.orders.php');
    exit;
}

$orderId = $_GET['id'];

// Get order details
$sql = "SELECT * FROM ORDERTABLE WHERE ORDERID = :orderid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
$result = oci_execute($stmt);

if (!$result) {
    $e = oci_error($stmt);
    die("Error fetching order: " . $e['message']);
}

$order = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if ($order) {
    // Initialize customer fields
    $order['C_USERNAME'] = '';
    $order['C_EMAIL'] = '';
    $order['C_PHONENUM'] = '';

    // Get customer details if CUSTID exists
    if (!empty($order['CUSTID'])) {
        $sql = "SELECT * FROM CUSTOMER WHERE CUSTID = :custid";
        $stmt = oci_parse($condb, $sql);
        oci_bind_by_name($stmt, ":custid", $order['CUSTID']);
        $result = oci_execute($stmt);
        
        if ($result) {
            $customer = oci_fetch_assoc($stmt);
            if ($customer) {
                $order['C_USERNAME'] = $customer['C_USERNAME'];
                $order['C_EMAIL'] = $customer['C_EMAIL'];
                $order['C_PHONENUM'] = $customer['C_PHONENUM'];
            }
        }
        oci_free_statement($stmt);
    }
    
    // Get staff details if assigned
    if ($order['STAFFID']) {
        $sql = "SELECT S_USERNAME, S_EMAIL, S_PHONENUM FROM STAFF WHERE STAFFID = :staffid";
        $stmt = oci_parse($condb, $sql);
        oci_bind_by_name($stmt, ":staffid", $order['STAFFID']);
        $result = oci_execute($stmt);
        
        if (!$result) {
            $e = oci_error($stmt);
            die("Error fetching staff: " . $e['message']);
        }
        
        $staff = oci_fetch_assoc($stmt);
        oci_free_statement($stmt);
        
        // Merge staff details into order array
        $order['S_USERNAME'] = $staff['S_USERNAME'] ?? '';
        $order['S_EMAIL'] = $staff['S_EMAIL'] ?? '';
        $order['S_PHONENUM'] = $staff['S_PHONENUM'] ?? '';
    }
    
    // Get status
    $status = 'Processing';
    $sql = "SELECT D_STATUS FROM DELIVERY WHERE ORDERID = :orderid";
    $stmt = oci_parse($condb, $sql);
    oci_bind_by_name($stmt, ":orderid", $orderId);
    $result = oci_execute($stmt);
    
    if ($result) {
        $delivery = oci_fetch_assoc($stmt);
        if ($delivery && !empty($delivery['D_STATUS'])) {
            $status = $delivery['D_STATUS'];
        }
        oci_free_statement($stmt);
    }

    if ($status === 'Processing') {
        $sql = "SELECT P_STATUS FROM PICKUP WHERE ORDERID = :orderid";
        $stmt = oci_parse($condb, $sql);
        oci_bind_by_name($stmt, ":orderid", $orderId);
        $result = oci_execute($stmt);
        
        if ($result) {
            $pickup = oci_fetch_assoc($stmt);
            if ($pickup && !empty($pickup['P_STATUS'])) {
                $status = $pickup['P_STATUS'];
            }
            oci_free_statement($stmt);
        }
    }
}

if (!$order) {
    header('Location: a.orders.php');
    exit;
}

// Get order items
$sql = "
    SELECT 
        k.K_NAME,
        k.K_DESC,
        od.QUANTITY,
        od.SUBTOTAL,
        o.KUPISIZE,
        o.KUPITYPE,
        o.KUPIBEAN,
        o.KUPIMILK
    FROM ORDERDETAIL od
    JOIN ORDERTABLE o ON od.ORDERID = o.ORDERID
    JOIN KUPI k ON od.KUPIID = k.KUPIID
    WHERE od.ORDERID = :orderid
";

$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":orderid", $orderId);
$result = oci_execute($stmt);

if (!$result) {
    $e = oci_error($stmt);
    die("Error fetching items: " . $e['message']);
}

$items = array();
$totalAmount = 0;
while ($row = oci_fetch_assoc($stmt)) {
    // Add null checks for all item fields
    $items[] = array(
        'K_NAME' => $row['K_NAME'] ?? '',
        'K_DESC' => $row['K_DESC'] ?? '',
        'QUANTITY' => $row['QUANTITY'] ?? 0,
        'SUBTOTAL' => $row['SUBTOTAL'] ?? 0,
        'KUPISIZE' => $row['KUPISIZE'] ?? '',
        'KUPITYPE' => $row['KUPITYPE'] ?? '',
        'KUPIBEAN' => $row['KUPIBEAN'] ?? '',
        'KUPIMILK' => $row['KUPIMILK'] ?? ''
    );
    $totalAmount += ($row['SUBTOTAL'] ?? 0);
}
oci_free_statement($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order Details</title>
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
                <h2 class="text-pink-700 text-3xl font-bold">Order Details</h2>
                <div>
                    <?php if (!$order['STAFFID']): ?>
                        <a href="a.assign_order.php?id=<?php echo htmlspecialchars($orderId); ?>" 
                           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mr-2">
                            Assign Staff
                        </a>
                    <?php endif; ?>
                    <a href="a.orders.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Back to Orders
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <!-- Order Summary -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-gray-600">Order ID</p>
                                <p class="font-semibold"><?php echo htmlspecialchars($order['ORDERID'] ?? ''); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Date</p>
                                <p class="font-semibold"><?php echo isset($order['KUPIDATE']) ? date('Y-m-d H:i', strtotime($order['KUPIDATE'])) : ''; ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Status</p>
                                <p class="font-semibold">
                                    <span class="px-2 py-1 rounded text-sm
                                        <?php 
                                        switch($status) {
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
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600">Total Amount</p>
                                <p class="font-semibold">RM <?php echo number_format($totalAmount, 2); ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-gray-600">Name</p>
                                <p class="font-semibold"><?php echo htmlspecialchars($order['C_USERNAME'] ?? ''); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Email</p>
                                <p class="font-semibold"><?php echo htmlspecialchars($order['C_EMAIL'] ?? ''); ?></p>
                            </div>
                            <div>
                                <p class="text-gray-600">Phone</p>
                                <p class="font-semibold"><?php echo htmlspecialchars($order['C_PHONENUM'] ?? ''); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Information -->
                <?php if ($order['STAFFID']): ?>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Assigned Staff</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-gray-600">Name</p>
                            <p class="font-semibold"><?php echo htmlspecialchars($order['S_USERNAME'] ?? ''); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Email</p>
                            <p class="font-semibold"><?php echo htmlspecialchars($order['S_EMAIL'] ?? ''); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Phone</p>
                            <p class="font-semibold"><?php echo htmlspecialchars($order['S_PHONENUM'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Order Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                    <table class="min-w-full border border-pink-100">
                        <thead class="bg-pink-50">
                            <tr>
                                <th class="text-left px-4 py-2 border-b">Item</th>
                                <th class="text-left px-4 py-2 border-b">Customization</th>
                                <th class="text-center px-4 py-2 border-b">Quantity</th>
                                <th class="text-right px-4 py-2 border-b">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr class="border-b">
                                    <td class="px-4 py-2">
                                        <div class="font-semibold">
                                            <?php 
                                            echo htmlspecialchars($item['K_NAME']);
                                            if (!empty($item['KUPITYPE'])) {
                                                echo ' ' . htmlspecialchars($item['KUPITYPE']) . '';
                                            }
                                            ?>
                                        </div>
                                        <?php if (!empty($item['K_DESC'])): ?>
                                            <div class="text-sm text-gray-600"><?php echo htmlspecialchars($item['K_DESC']); ?></div>
                                        <?php endif; ?>
                                    </td>
                                   
                                    <td class="px-4 py-2">
                                        <div class="text-sm">
                                            <?php if (!empty($item['KUPISIZE'])): ?>
                                                Size: <?php echo htmlspecialchars($item['KUPISIZE']); ?><br>
                                            <?php endif; ?>
                                            <?php if (!empty($item['KUPIBEAN'])): ?>
                                                Bean: <?php echo htmlspecialchars($item['KUPIBEAN']); ?><br>
                                            <?php endif; ?>
                                            <?php if (!empty($item['KUPIMILK'])): ?>
                                                Milk: <?php echo htmlspecialchars($item['KUPIMILK']); ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center px-4 py-2"><?php echo htmlspecialchars($item['QUANTITY']); ?></td>
                                    <td class="text-right px-4 py-2">RM <?php echo number_format($item['SUBTOTAL'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="bg-pink-50">
                                <td colspan="3" class="text-right px-4 py-2 font-semibold">Total:</td>
                                <td class="text-right px-4 py-2 font-semibold">RM <?php echo number_format($totalAmount, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
