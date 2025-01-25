<?php
include '../Homepage/dbkupi.php';
require_once '../Homepage/session.php';

// Check if the user is logged in
$custid = getSession('custid');
if (!$custid) {
    header('../Customer/c.login.php');
    exit();
}

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phonenum = $_POST['phonenum'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Prepare the SQL query to update the profile
    $sql = "UPDATE customer SET c_username = :c_username, c_pass = :c_pass, c_phonenum = :c_phonenum, c_email = :c_email, c_address = :c_address WHERE custid = :custid";
    $stmt = oci_parse($condb, $sql);
    // if (!empty($password)) {
    //     $sql .= ", c_pass = :c_pass";
    // }
    // $sql .= " WHERE custid = :custid";

    // Bind the parameters
    oci_bind_by_name($stmt, ':c_username', $username);
    oci_bind_by_name($stmt, ':c_pass', $password);
    oci_bind_by_name($stmt, ':c_phonenum', $phonenum);
    oci_bind_by_name($stmt, ':c_email', $email);
    oci_bind_by_name($stmt, ':c_address', $address);
    oci_bind_by_name($stmt, ':custid', $custid);
    // if (!empty($password)) {
    //     oci_bind_by_name($stmt, ':c_pass', $password);
    // }

    // Execute the query
    if (oci_execute($stmt)) {
        // Update session data
        setSession('username', $username);
        setSession('phonenum', $phonenum);
        setSession('email', $email);
        setSession('address', $address);
        setSession('password', $password);

        // Redirect back to the profile page
        header('Location: ../Customer/c.profile.php');
    } else {
        $e = oci_error($stmt);
        echo "Failed to update profile: " . $e['message'];
    }

    // Redirect back to the profile page
    header('Location: ../Customer/c.profile.php');
    exit();
}

// Fetch Order History from Database
$sql = "SELECT od.orderdetailid, od.quantity, od.subtotal, ot.orderdate
        FROM orderdetail od
        JOIN ORDERTABLE ot ON od.orderid = ot.orderid
        WHERE ot.custid = :custid
        ORDER BY ot.orderdate DESC";// Adjust the table and column names as needed

$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ':custid', $custid);

if (!oci_execute($stmt)) {
    $e = oci_error($stmt);
    die("Failed to fetch order history: " . $e['message']);
}

$orderHistory = [];
while ($row = oci_fetch_assoc($stmt)) {
    $orderHistory[] = [
        'id' => $row['ORDERID'],
        'date' => $row['ORDERDATE'],
        'amount' => $row['TOTALAMOUNT']
    ];
}

oci_free_statement($stmt);

?>