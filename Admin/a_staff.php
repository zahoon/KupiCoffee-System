<?php
function fetchStaff($currentPage, $itemsPerPage)
{
    global $condb; // Use the global connection variable

    $offset = ($currentPage - 1) * $itemsPerPage;

    // SQL to fetch paginated staff using ROW_NUMBER() for pagination
    $sql = "
    SELECT * FROM (
        SELECT 
            s.staffID, 
            s.s_username, 
            s.s_email, 
            s.s_phonenum,
            s.s_role,
            ROW_NUMBER() OVER (ORDER BY s.staffID) AS row_number
        FROM staff s
    ) 
    WHERE row_number > :start_row AND row_number <= :end_row
    ";

    $stid = oci_parse($condb, $sql);
    $endRow = $offset + $itemsPerPage;
    $startRow = $offset;

    oci_bind_by_name($stid, ':end_row', $endRow);
    oci_bind_by_name($stid, ':start_row', $startRow);
    oci_execute($stid);

    $staff = [];
    while ($row = oci_fetch_assoc($stid)) {
        $staff[] = $row;
    }

    oci_free_statement($stid);

    // Get the total number of staff members for pagination
    $countQuery = "SELECT COUNT(*) AS total FROM staff";
    $countStid = oci_parse($condb, $countQuery);
    oci_execute($countStid);
    $totalRow = oci_fetch_assoc($countStid);
    $totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);

    oci_free_statement($countStid);

    return ['staff' => $staff, 'totalPages' => $totalPages];
}
