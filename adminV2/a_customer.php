<?php
function fetchCustomers($currentPage, $itemsPerPage)
{
    global $condb; // Use the global connection variable

    $offset = ($currentPage - 1) * $itemsPerPage;

    // SQL to fetch paginated customers with total orders using ROW_NUMBER() for pagination
    $sql = "
    SELECT * FROM (
        SELECT 
            c.custID, 
            c.c_username, 
            c.c_email,
            c.c_phonenum,
            COALESCE(COUNT(o.orderID), 0) AS TOTAL_ORDERS,  -- Ensures 0 if no orders
            ROW_NUMBER() OVER (ORDER BY c.custID) AS row_number
        FROM customer c
        LEFT JOIN ordertable o ON c.custID = o.custID
        GROUP BY c.custID, c.c_username, c.c_email, c.c_phonenum
    ) 
    WHERE row_number > :start_row AND row_number <= :end_row
";


    $stid = oci_parse($condb, $sql);
    $endRow = $offset + $itemsPerPage;
    $startRow = $offset;

    oci_bind_by_name($stid, ':end_row', $endRow);
    oci_bind_by_name($stid, ':start_row', $startRow);
    oci_execute($stid);

    $customers = [];
    while ($row = oci_fetch_assoc($stid)) {
        $customers[] = $row;
    }

    oci_free_statement($stid);

    // Get the total number of customers for pagination
    $countQuery = "SELECT COUNT(*) AS total FROM customer";
    $countStid = oci_parse($condb, $countQuery);
    oci_execute($countStid);
    $totalRow = oci_fetch_assoc($countStid);
    $totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);

    oci_free_statement($countStid);

    return ['customers' => $customers, 'totalPages' => $totalPages];
}
