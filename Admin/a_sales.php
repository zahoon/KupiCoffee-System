<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

function fetchTotalSalesAndPurchases()
{
    global $condb;

    // Check if the database connection is valid
    if (!$condb) {
        echo "Error: Database connection is not established.";
        return null;
    }

    // SQL to fetch total sales and total purchases
    $sql = "
    SELECT
        COALESCE(SUM(SUBTOTAL), 0) AS total_sales,
        COALESCE(SUM(QUANTITY), 0) AS total_purchases
    FROM
        ORDERDETAIL
  ";

    // Prepare and execute the query
    $stid = oci_parse($condb, $sql);
    $executeResult = oci_execute($stid);

    // Check for any OCI errors
    if (!$executeResult) {
        $error = oci_error($stid);
        echo "OCI Execute Error: " . $error['message'];
        return null;
    }

    // Fetch the result
    $result = oci_fetch_assoc($stid);

    // Check if the result is fetched correctly
    if ($result === false) {
        echo "Error: No data found or failed to fetch result.";
        return null;
    }

    oci_free_statement($stid);

    // Return the result
    return [
        'total_sales' => $result['TOTAL_SALES'] ?? 0,
        'total_purchases' => $result['TOTAL_PURCHASES'] ?? 0,
    ];
}

function fetchTotalSalesAndPurchasesForMonth($selectedMonth)
{
    global $condb;

    // Check if the database connection is valid
    if (!$condb) {
        echo "Error: Database connection is not established.";
        return null;
    }

    // Ensure the selected month is in the 'YYYY-MM' format
    $date = DateTime::createFromFormat('Y-m', $selectedMonth);
    if (!$date) {
        // Return JSON error if the date format is invalid
        echo json_encode(["error" => "Invalid date format. Please use YYYY-MM."]);
        exit; // Ensure no other output is sent
    }

    // Get the first and last day of the selected month
    $startDate = $date->format('Y-m-01');  // First day of the month
    $endDate = $date->format('Y-m-t');    // Last day of the month

    // SQL to fetch total sales and total purchases for the selected date range
    $sql = "
    SELECT
        COALESCE(SUM(od.SUBTOTAL), 0) AS total_sales,
        COALESCE(SUM(od.QUANTITY), 0) AS total_purchases
    FROM
        ORDERDETAIL od
    JOIN
        ORDERTABLE o ON od.ORDERID = o.ORDERID
    WHERE
        o.KUPIDATE BETWEEN TO_DATE(:startDate, 'YYYY-MM-DD') AND TO_DATE(:endDate, 'YYYY-MM-DD')
    ";

    // Prepare and execute the query
    $stid = oci_parse($condb, $sql);
    oci_bind_by_name($stid, ':startDate', $startDate);
    oci_bind_by_name($stid, ':endDate', $endDate);
    $executeResult = oci_execute($stid);

    // Check for any OCI errors
    if (!$executeResult) {
        $error = oci_error($stid);
        echo json_encode(["error" => "OCI Execute Error: " . $error['message']]);
        exit;
    }

    // Fetch the result
    $result = oci_fetch_assoc($stid);

    // Check if the result is fetched correctly
    if ($result === false) {
        echo json_encode(["error" => "No data found or failed to fetch result."]);
        exit;
    }

    oci_free_statement($stid);

    // Return the result as JSON
    echo json_encode([
        'total_sales' => $result['TOTAL_SALES'] ?? 0,
        'total_purchases' => $result['TOTAL_PURCHASES'] ?? 0,
    ]);
    exit; // Ensure no other output is sent
}

// If the AJAX request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selectedDate'])) {
    $selectedDate = $_POST['selectedDate'];
    fetchTotalSalesAndPurchasesForMonth($selectedDate);
}
