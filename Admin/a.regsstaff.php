<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Register Staff</h2>
            <form action="a_regsstaff.php" method="POST">
                <!-- Radio Buttons for Admin/Staff -->
                <div class="mb-4 flex">
                    <label class="inline-flex items-center">
                        <input type="radio" name="role" value="admin" class="form-radio text-blue-500">
                        <span class="ml-2">Admin</span>
                    </label>
                    <label class="inline-flex items-center ml-4">
                        <input type="radio" name="role" value="staff" class="form-radio text-blue-500" checked>
                        <span class="ml-2">Staff</span>
                    </label>
                </div>
                <!-- Form Fields -->
                <input type="text" name="username" placeholder="Username" required class="p-2 border border-gray-300 rounded mb-4 w-full">
                <input type="password" name="password" placeholder="Password" required class="p-2 border border-gray-300 rounded mb-4 w-full">
                <input type="text" name="phone" placeholder="Phone Number" required class="p-2 border border-gray-300 rounded mb-4 w-full">
                <input type="email" name="email" placeholder="Email" required class="p-2 border border-gray-300 rounded mb-4 w-full">
                <button type="submit" name="register" class="bg-blue-500 text-white p-2 rounded w-full">Register</button>
            </form>
        </div>
    </div>
</body>
<?php
// // Assuming the registration process is successful
// $registrationSuccess = true; // Set to true after successful registration

// if ($registrationSuccess) {
//     echo "
//     <div class='fixed top-0 right-0 mt-4 mr-4 max-w-xs w-full bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md'>
//         <strong class='font-bold'>Success!</strong>
//         <span>Your staff member has been successfully registered.</span>
//     </div>
//     ";
// }
?>

</html>