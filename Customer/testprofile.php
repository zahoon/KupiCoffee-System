<?php
include 'session.php';
include 'dbkupi.php';

// Check if the user is logged in
$username = getSession('username');
if (!$username) {
    header('Location: login.html');
    exit();
}

// Get current user data from the database
$custid = getSession('custid');
$sql = "SELECT * FROM customer WHERE custid = :custid";
$stmt = oci_parse($condb, $sql);
oci_bind_by_name($stmt, ':custid', $custid);
oci_execute($stmt);
$user = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php include '../Homepage/header.php'; ?>
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold mb-6 text-center">Edit Profile</h2>
            <form action="update_profile.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['C_USERNAME']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="phonenum" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="phonenum" name="phonenum" value="<?php echo htmlspecialchars($user['C_PHONENUM']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['C_EMAIL']); ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>