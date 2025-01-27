<?php
require_once '../Homepage/dbkupi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get the BLOB data
    $query = "SELECT K_IMAGE FROM KUPI WHERE KUPIID = :id";
    $stmt = oci_parse($condb, $query);
    if (!$stmt) {
        die("Failed to prepare statement");
    }
    
    oci_bind_by_name($stmt, ":id", $id);
    
    if (!oci_execute($stmt)) {
        die("Failed to execute statement");
    }
    
    if ($row = oci_fetch_assoc($stmt)) {
        $lob = $row['K_IMAGE'];
        if ($lob && is_object($lob)) {
            // Load the BLOB
            $image = $lob->load();
            if ($image !== false) {
                // Set content type to image and output the BLOB data
                header("Content-Type: image/jpeg");
                echo $image;
            }
        }
    }
    
    oci_free_statement($stmt);
}
?>
