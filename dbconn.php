<?php  
// dbconn.php  
$username = 'kupidb'; // Oracle DB username  
$password = 'kupidb'; // Oracle DB password  
$connection_string = "localhost:1521/xe";; // Oracle DB connection string  

// Establish connection  
$dbconn = oci_connect($username, $password, $connection_string);  

if (!$dbconn) {  
    $e = oci_error();  
    die("Connection failed: " . $e['message']);  
}  
?>