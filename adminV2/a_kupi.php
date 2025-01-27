<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

function fetchKupi($currentPage, $itemsPerPage)
{
    global $condb;

    $offset = ($currentPage - 1) * $itemsPerPage;

    // SQL to fetch paginated records
    $sql = "
    SELECT * FROM (
        SELECT 
            k.kupiID,
            k.k_name,
            k.k_price,
            k.k_desc,
            ROW_NUMBER() OVER (ORDER BY k.kupiID) AS row_number
        FROM kupi k
    ) subquery
    WHERE subquery.row_number > :start_row AND subquery.row_number <= :end_row
    ";

    $stid = oci_parse($condb, $sql);
    $endRow = $offset + $itemsPerPage;
    $startRow = $offset;

    oci_bind_by_name($stid, ':end_row', $endRow);
    oci_bind_by_name($stid, ':start_row', $startRow);
    if (!oci_execute($stid)) {
        oci_free_statement($stid);
        echo json_encode(['error' => 'Failed to execute query']);
        exit;
    }

    $kupiRecords = [];
    while ($row = oci_fetch_assoc($stid)) {
        $kupiRecords[] = $row;
    }
    oci_free_statement($stid);

    // Get total record count
    $countQuery = "SELECT COUNT(*) AS total FROM kupi";
    $countStid = oci_parse($condb, $countQuery);
    if (!oci_execute($countStid)) {
        oci_free_statement($countStid);
        echo json_encode(['error' => 'Failed to fetch total records']);
        exit;
    }
    $totalRow = oci_fetch_assoc($countStid);
    oci_free_statement($countStid);

    $totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);

    echo json_encode(['kupi' => $kupiRecords, 'totalPages' => $totalPages]);
    exit;
}

// Handle AJAX requests for fetching data
if (isset($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
    $itemsPerPage = 10;
    fetchKupi($currentPage, $itemsPerPage);
}
?>
