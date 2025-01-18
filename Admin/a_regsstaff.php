<?php  
session_start();  
include '../Admin/a.regsstaff.php'; // Include your database connection file  

// Initialize variables for error and success messages  
$error = '';  
$success = '';  

// Handle staff registration  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {  
    $username = trim($_POST['username']);  
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash the password  
    $phone = trim($_POST['phone']);  
    $email = trim($_POST['email']);  
    $adminid = $_POST['adminid'];  

    // Validate inputs  
    if (empty($username) || empty($password) || empty($phone) || empty($email)) {  
        $error = "All fields are required.";  
    } else {  
        // Insert into database  
        $conn = getConnection();  
        $sql = 'INSERT INTO STAFF (S_USERNAME, S_PASS, S_PHONENUM, S_EMAIL, ADMINID) VALUES (:username, :password, :phone, :email, :adminid)';  
        $stmt = oci_parse($conn, $sql);  
        oci_bind_by_name($stmt, ':username', $username);  
        oci_bind_by_name($stmt, ':password', $password);  
        oci_bind_by_name($stmt, ':phone', $phone);  
        oci_bind_by_name($stmt, ':email', $email);  
        oci_bind_by_name($stmt, ':adminid', $adminid);  
        
        if (oci_execute($stmt)) {  
            $success = "Staff registered successfully!";  
        } else {  
            $error = "Error registering staff.";  
        }  

        oci_free_statement($stmt);  
        oci_close($conn);  
    }  
}  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Registration Result</title>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
</head>  
<body class="bg-gray-100">  
    <div class="flex justify-center items-center h-screen">  
        <div class="bg-white p-8 rounded-lg shadow-md w-96">  
            <h2 class="text-2xl font-bold mb-6 text-center">Registration Result</h2>  
            <?php if ($error): ?>  
                <div class="bg-red-200 text-red-600 p-2 rounded mb-4"><?= htmlspecialchars($error) ?></div>  
            <?php endif; ?>  
            <?php if ($success): ?>  
                <div class="bg-green-200 text-green-600 p-2 rounded mb-4"><?= htmlspecialchars($success) ?></div>  
            <?php endif; ?>  
            <a href="a_regstaff.php" class="text-blue-500">Register another staff member</a>  
        </div>  
    </div>  
</body>  
</html>