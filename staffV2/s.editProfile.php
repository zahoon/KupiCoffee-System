<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

// Check if staff is logged in
if (!isset($_SESSION['username'])) {
    header("Location: s_login.php");
    exit();
}

$username = $_SESSION['username'];
$message = '';

// Fetch current staff data
$sql = "SELECT STAFFID, S_USERNAME, S_EMAIL, S_PHONENUM FROM STAFF WHERE S_USERNAME = :username";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ':username', $username);
oci_execute($stmt);
$staff = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use current values if fields are empty
    $email = !empty($_POST['email']) ? $_POST['email'] : $staff['S_EMAIL'];
    $phone = !empty($_POST['phone']) ? $_POST['phone'] : $staff['S_PHONENUM'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Only proceed if current password is provided
    if (!empty($current_password)) {
        // Verify current password first
        $verify_sql = "SELECT STAFFID FROM STAFF WHERE S_USERNAME = :username AND S_PASS = :password";
        $verify_stmt = oci_parse($condb, $verify_sql);
        oci_bind_by_name($verify_stmt, ':username', $username);
        oci_bind_by_name($verify_stmt, ':password', $current_password);
        oci_execute($verify_stmt);
        
        if (oci_fetch_assoc($verify_stmt)) {
            // Password verified, proceed with update
            if (!empty($new_password)) {
                // If new password is provided, verify it matches confirmation
                if ($new_password === $confirm_password) {
                    $update_sql = "UPDATE STAFF SET S_EMAIL = :email, S_PHONENUM = :phone, S_PASS = :new_password 
                                WHERE S_USERNAME = :username";
                    $update_stmt = oci_parse($condb, $update_sql);
                    oci_bind_by_name($update_stmt, ':email', $email);
                    oci_bind_by_name($update_stmt, ':phone', $phone);
                    oci_bind_by_name($update_stmt, ':new_password', $new_password);
                    oci_bind_by_name($update_stmt, ':username', $username);
                } else {
                    $message = "New passwords do not match!";
                }
            } else {
                // Update without changing password
                $update_sql = "UPDATE STAFF SET S_EMAIL = :email, S_PHONENUM = :phone WHERE S_USERNAME = :username";
                $update_stmt = oci_parse($condb, $update_sql);
                oci_bind_by_name($update_stmt, ':email', $email);
                oci_bind_by_name($update_stmt, ':phone', $phone);
                oci_bind_by_name($update_stmt, ':username', $username);
            }
            
            if (isset($update_stmt) && oci_execute($update_stmt)) {
                $message = "Profile updated successfully!";
                // Refresh staff data
                $sql = "SELECT STAFFID, S_USERNAME, S_EMAIL, S_PHONENUM FROM STAFF WHERE S_USERNAME = :username";
                $stmt = oci_parse($condb, $sql);
                oci_bind_by_name($stmt, ':username', $username);
                oci_execute($stmt);
                $staff = oci_fetch_assoc($stmt);
                oci_free_statement($stmt);
            } else {
                $message = "Error updating profile!";
            }
            
            if (isset($update_stmt)) {
                oci_free_statement($update_stmt);
            }
        } else {
            $message = "Current password is incorrect!";
        }
        oci_free_statement($verify_stmt);
    } else {
        $message = "Current password is required to make changes!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-3xl font-bold text-pink-700 mb-6">Edit Profile</h2>
            
            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded <?php echo strpos($message, 'success') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <!-- Username (read-only) -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" value="<?php echo htmlspecialchars($staff['S_USERNAME']); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-100" readonly>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($staff['S_EMAIL']); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-pink-500" 
                           placeholder="Enter new email (leave empty to keep current)">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($staff['S_PHONENUM']); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-pink-500" 
                           placeholder="Enter new phone number (leave empty to keep current)">
                </div>

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Current Password <span class="text-red-500">*</span></label>
                    <input type="password" id="current_password" name="current_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-pink-500" 
                           required>
                    <p class="text-sm text-gray-500 mt-1">Required to make any changes</p>
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                    <input type="password" id="new_password" name="new_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-pink-500" 
                           placeholder="Leave blank to keep current password">
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-pink-500" 
                           placeholder="Required only if changing password">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="s.manageOrder.php" 
                       class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
