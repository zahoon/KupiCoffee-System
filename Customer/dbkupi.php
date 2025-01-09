<?PHP

$user = "kupidb"; //oracle username
$pass = "kupidb"; //Oracle password 
$host = "localhost:1521/xe"; //server name or ip address 

$condb=oci_connect($user, $pass, $host);

?>