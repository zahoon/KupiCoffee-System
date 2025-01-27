<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($phone) || empty($role) || empty($password)) {
        $error = "All fields are required";
    } else {
        // Get next staff ID
        $sql = "SELECT MAX(STAFFID) as MAX_ID FROM STAFF";
        $stmt = oci_parse($condb, $sql);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        $nextId = $row['MAX_ID'] + 1;
        oci_free_statement($stmt);

        // Insert new staff
        $sql = "
            INSERT INTO STAFF (
                STAFFID,
                S_USERNAME,
                S_PASS,
                S_EMAIL,
                S_PHONENUM,
                S_ROLE
            ) VALUES (
                :staffid,
                :username,
                :password,
                :email,
                :phone,
                :role
            )
        ";
        
        $stmt = oci_parse($condb, $sql);
        
        oci_bind_by_name($stmt, ":staffid", $nextId);
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":password", $password);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":phone", $phone);
        oci_bind_by_name($stmt, ":role", $role);
        
        $result = oci_execute($stmt);
        
        if ($result) {
            $success = "Staff added successfully";
            // Reset form
            $username = $email = $phone = '';
        } else {
            $e = oci_error($stmt);
            $error = "Error adding staff: " . $e['message'];
        }
        
        oci_free_statement($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Add New Staff</h2>
                <a href="a.staff.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to List</a>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" 
                            value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" 
                            value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                            value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select id="role" name="role" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                            <option value="">Select Role</option>
                            <option value="Admin" <?php echo isset($role) && $role === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="Staff" <?php echo isset($role) && $role === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                        </select>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Reset
                        </button>
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                            Add Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
