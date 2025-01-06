<?php
$user = "root"; //mysqlusername
$pass = "";
$host = "localhost";
$dbname = "coffeeforgo";
$dbconn = mysqli_connect($host ,$user , $pass , $dbname) or die(mysqli_error($dbconn));

// echo "Database name : ". $dbname;
?>