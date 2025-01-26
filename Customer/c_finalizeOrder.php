<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['custid'])) {
    header("Location: ../Customer/c.login.php");
    exit;
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: c.inCart.php");
    exit;
}

// Include the database connection file
include("../Homepage/dbkupi.php");

// Mapping of coffee_name to kupiID
$coffeeToKupiID = [
    'Americano' => 1,
    'Cappuccino' => 2,
    'Spanish Latte' => 3,
    'Salted Camy Frappe' => 4,
    'Espresso Frappe' => 5,
    'Salted Caramel Latte' => 6,
    'Buttercreme Latte' => 7,
    'Coconut Latte' => 8,
    'Hazelnut Latte' => 9,
    'Matcha Latte' => 10,
    'Nesloo' => 11,
    'Matcha Frappe' => 12,
    'Genmaicha Latte' => 13,
    'Biscoff Frappe' => 14,
    'Chocohazel Frappe' => 15,
    'Chocookies' => 16,
    'Buttercreme Choco' => 17,
    'Lemonade' => 18,
    'Cheesecream Matcha' => 19,
    'Ori Matcha' => 20,
    'Strawberry Frappe' => 21,
    'Yam Milk' => 22,
    'Coconut Shake' => 23,
];

// Retrieve order method and delivery time from the session
$orderMethod = $_SESSION['order_method'] ?? 'pickup';
$deliveryTime = $_SESSION['delivery_time'] ?? null; // Ensure this is set in c.delivery.php or c_pickup.php


    $deliveryTime = date('Y-m-d') . ' ' . $deliveryTime; // Combine current date with delivery time


// Loop through each item in the cart
foreach ($_SESSION['cart'] as $item) {
    // Assign kupiID based on coffee_name
    $coffeeName = $item['coffee_name'];
    $kupiID = $coffeeToKupiID[$coffeeName] ?? 0; // Default to 0 if coffee_name is not found

    // Retrieve other item details
    $quantity = $item['quantity'] ?? 1;
    $price = $item['price'];
    $subtotal = $quantity * $price; // Calculate subtotal

    // Prepare variables for binding
    $kupiMilk = $item['milk'] ?? 'N/A';
    $kupiType = $item['coffee_name'];
    $kupiSize = $item['size'] ?? 'N/A';
    $kupiCream = $item['cream'] ?? 'No';
    $kupiBean = $item['bean'] ?? 'N/A';
    $kupiDate = date('Y-m-d H:i:s'); // Current date and time
    $custID = $_SESSION['custid'];

    // Insert into ORDERTABLE with RETURNING clause
    $insertOrderTableSQL = "
        INSERT INTO ORDERTABLE (KUPIMILK, KUPITYPE, KUPISIZE, KUPICREAM, KUPIBEAN, KUPIDATE, CUSTID, STAFFID)
        VALUES (:kupiMilk, :kupiType, :kupiSize, :kupiCream, :kupiBean, TO_DATE(:kupiDate, 'YYYY-MM-DD HH24:MI:SS'), :custID, NULL)
        RETURNING ORDERID INTO :orderID
    ";

    $stmt = oci_parse($condb, $insertOrderTableSQL);
    $orderID = 0; // Initialize the variable

    // Bind variables for ORDERTABLE
    oci_bind_by_name($stmt, ':kupiMilk', $kupiMilk);
    oci_bind_by_name($stmt, ':kupiType', $kupiType);
    oci_bind_by_name($stmt, ':kupiSize', $kupiSize);
    oci_bind_by_name($stmt, ':kupiCream', $kupiCream);
    oci_bind_by_name($stmt, ':kupiBean', $kupiBean);
    oci_bind_by_name($stmt, ':kupiDate', $kupiDate);
    oci_bind_by_name($stmt, ':custID', $custID);
    oci_bind_by_name($stmt, ':orderID', $orderID, -1, SQLT_INT);

    // Execute the statement
    $result = oci_execute($stmt);

    if (!$result) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Insert into ORDERDETAIL using the same $orderID
    $insertOrderDetailSQL = "
        INSERT INTO ORDERDETAIL (QUANTITY, PRICEPERORDER, SUBTOTAL, KUPIID, ORDERID)
        VALUES (:quantity, :pricePerOrder, :subtotal, :kupiID, :orderID)
    ";

    $stmtDetail = oci_parse($condb, $insertOrderDetailSQL);

    // Bind variables for ORDERDETAIL
    oci_bind_by_name($stmtDetail, ':quantity', $quantity);
    oci_bind_by_name($stmtDetail, ':pricePerOrder', $price);
    oci_bind_by_name($stmtDetail, ':subtotal', $subtotal);
    oci_bind_by_name($stmtDetail, ':kupiID', $kupiID);
    oci_bind_by_name($stmtDetail, ':orderID', $orderID);

    $resultDetail = oci_execute($stmtDetail);

    if (!$resultDetail) {
        $e = oci_error($stmtDetail);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Debugging: Check the generated ORDERID
echo "Generated ORDERID for ORDERTABLE: " . $orderID . "<br>";

// Insert into DELIVERY if orderMethod is 'delivery'
if ($orderMethod === 'delivery' && $deliveryTime) {
    $insertDeliverySQL = "
        INSERT INTO DELIVERY (ORDERID, D_TIME, D_STATUS)
        VALUES (:orderID, TO_DATE(:deliveryTime, 'YYYY-MM-DD HH24:MI:SS'), 'Pending')
    ";

    $stmtDelivery = oci_parse($condb, $insertDeliverySQL);
    oci_bind_by_name($stmtDelivery, ':orderID', $orderID);
    oci_bind_by_name($stmtDelivery, ':deliveryTime', $deliveryTime);

    $resultDelivery = oci_execute($stmtDelivery);

    if (!$resultDelivery) {
        $e = oci_error($stmtDelivery);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
}

// Insert into PICKUP if orderMethod is 'pickup'
if ($orderMethod === 'pickup' && $deliveryTime) {
    echo "Inserting into DELIVERY or PICKUP with ORDERID: " . $orderID . "<br>";

    $insertPickupSQL = "
        INSERT INTO PICKUP (ORDERID, P_TIME, P_STATUS)
        VALUES (:orderID, TO_DATE(:deliveryTime, 'YYYY-MM-DD HH24:MI:SS'), 'Pending')
    ";
    echo "Inserting into DELIVERY or PICKUP with ORDERID: " . $orderID . "<br>";

    $stmtPickup = oci_parse($condb, $insertPickupSQL);
    oci_bind_by_name($stmtPickup, ':orderID', $orderID);
    oci_bind_by_name($stmtPickup, ':deliveryTime', $deliveryTime);

    $resultPickup = oci_execute($stmtPickup);

    if (!$resultPickup) {
        $e = oci_error($stmtPickup);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
}


   
}

// Commit the transaction
oci_commit($condb);

// Close the connection
oci_close($condb);

// Clear the cart after the order is finalized
unset($_SESSION['cart']);

// Redirect to a success page
header("Location: c_orderSuccess.php");
exit;
?>