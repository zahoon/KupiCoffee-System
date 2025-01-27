<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

$error = '';
$success = '';

if (!isset($_GET['id'])) {
    header('Location: a.customer.php');
    exit;
}

$customerId = $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($phone)) {
        $error = "All fields are required except address";
    } else {
        // Update customer information
        $sql = "
            UPDATE CUSTOMER 
            SET 
                C_USERNAME = :username,
                C_EMAIL = :email,
                C_PHONENUM = :phone,
                C_ADDRESS = :address
            WHERE CUSTID = :custid
        ";
        
        $stmt = oci_parse($condb, $sql);
        
        oci_bind_by_name($stmt, ":username", $username);
        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":phone", $phone);
        oci_bind_by_name($stmt, ":address", $address);
        oci_bind_by_name($stmt, ":custid", $customerId);
        
        $result = oci_execute($stmt);
        
        if ($result) {
            $success = "Customer information updated successfully";
        } else {
            $e = oci_error($stmt);
            $error = "Error updating customer: " . $e['message'];
        }
        
        oci_free_statement($stmt);
    }
}

// Get current customer information
$sql = "SELECT * FROM CUSTOMER WHERE CUSTID = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ":custid", $customerId);
oci_execute($stmt);
$customer = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

if (!$customer) {
    header('Location: a.customer.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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
                <h2 class="text-pink-700 text-3xl font-bold">Edit Customer Profile</h2>
                <a href="a.view_customer.php?id=<?php echo htmlspecialchars($customerId); ?>" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Back to View</a>
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
                            value="<?php echo htmlspecialchars($customer['C_USERNAME']); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" 
                            value="<?php echo htmlspecialchars($customer['C_EMAIL']); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" id="phone" name="phone" 
                            value="<?php echo htmlspecialchars($customer['C_PHONENUM']); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                            required>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"><?php echo htmlspecialchars($customer['C_ADDRESS']); ?></textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="reset" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Reset
                        </button>
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
