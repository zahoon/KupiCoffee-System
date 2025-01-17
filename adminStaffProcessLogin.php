<!DOCTYPE html>  
<html>  
<head>  
    <style>  
        #error-message {  
            position: fixed;  
            top: 50%;  
            left: 50%;  
            transform: translate(-50%, -50%);  
            border-radius: 25px;  
            width: 800px;  
            height: 680px;  
            margin-top: 15px;  
            background-color: #FFD700;  
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);  
            z-index: 100;  
        }  

        #error-message h1 {  
            text-align: center;  
            color: red;  
            font-size: 70px;  
            margin-top: 200px;  
            animation: transitionIn 1s;  
        }  

        #error-message p {  
            font-family: 'Poppins', sans-serif;  
            font-size: 40px;  
            color: black;  
            text-align: center;  
            font-weight: bold;  
            animation: transitionIn 1s;  
        }  

        #error-message button {  
            width: 200px;  
            height: 50px;  
            background-color: #7a2005;  
            border-radius: 25px;  
            font-weight: bold;  
            color: white;  
            font-family: 'Poppins', sans-serif;  
            font-size: 16px;  
            margin-top: 30px;  
            margin-left: 305px;  
            border: none;  
            outline: none;  
            transition: box-shadow 0.2s ease-in-out;  
            animation: transitionIn 1s;  
        }  

        #error-message button:hover {  
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.5);  
        }  
    </style>  
</head>  
<body>  
</body>  
</html>  

<?php  
session_start();  
// Include dbconn  
include("dbconn.php");  

if (isset($_POST['login'])) {  
    $username = $_POST['username'];  
    $password = $_POST['password'];  

    // Prepare SQL statement  
    $sql = "SELECT * FROM STAFF WHERE S_USERNAME = :username AND S_PASS = :password";  
    $stmt = oci_parse($dbconn, $sql);  
    oci_bind_by_name($stmt, ':username', $username);  
    oci_bind_by_name($stmt, ':password', $password);  
    oci_execute($stmt);  

    // Fetch results  
    $row = oci_fetch_all($stmt, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);  

    if ($row == 0) {  
        echo "<div id='error-message'>  
            <h1>Invalid Username or Password</h1>  
            <a href='adminStaffLogin.php'>  
                <button>Try Again</button>  
            </a>  
        </div>  
        <div id='cover' style='display:block'></div>";  
    } else {  
        // Assuming you want to check the admin type  
        $adminType = $result[0]['ADMINID']; // Adjust this based on your actual column name  
        $_SESSION['username'] = $result[0]['S_USERNAME'];  

        // Redirect to adminDash.html directly  
        header("Location: adminDash.html");  
        exit(); // Ensure no further code is executed after the redirect  
    }  
}  

oci_close($dbconn);  
?>