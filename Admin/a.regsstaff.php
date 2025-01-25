<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(../image/bgDel.png);
            background-size: cover;
            color: #444;
            font-family: 'Poppins', sans-serif;
            padding-top: 20px;
        }
        .register-container {
            background: rgba(255, 248, 207, 0.9);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        .register-title {
            color: #7a2005;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }
        .input-label {
            font-family: 'Poppins', sans-serif;
            color: #7a2005;
        }
        .register-button {
            background-color: #7a2005;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .register-button:hover {
            background-color: #5c1603;
            transform: scale(1.05);
        }
        .input-field {
            border-radius: 10px;
            border: 2px solid #7a2005;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .input-field:focus {
            border-color: #5c1603;
            box-shadow: 0 0 8px rgba(122, 32, 5, 0.3);
        }
        .radio-label {
            transition: color 0.3s ease;
        }
        .radio-label:hover {
            color: #5c1603;
        }
        .success-message {
            animation: slideIn 0.5s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include '../Homepage/header.php'; ?>
    <div class="flex justify-center items-center h-screen">
        <div class="register-container p-8 rounded-lg shadow-lg w-full max-w-sm">
            <h2 class="text-2xl font-bold mb-6 text-center register-title">Register Staff</h2>
            <form action="a_regsstaff.php" method="POST">
                <!-- Radio Buttons for Admin/Staff -->
                <div class="mb-4 flex justify-around">
                    <label class="inline-flex items-center radio-label">
                        <input type="radio" name="role" value="admin" class="form-radio text-blue-500">
                        <span class="ml-2"><i class="fas fa-user-shield"></i> Admin</span>
                    </label>
                    <label class="inline-flex items-center radio-label">
                        <input type="radio" name="role" value="staff" class="form-radio text-blue-500" checked>
                        <span class="ml-2"><i class="fas fa-user-tie"></i> Staff</span>
                    </label>
                </div>
                <!-- Form Fields -->
                <div class="mb-4">
                <label for="username" class="block text-sm font-medium input-label">Username</label>  
                    <input type="text" name="username" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                <label for="password" class="block text-sm font-medium input-label">Password</label>  
                    <input type="password" name="password" required class="p-2 border border-gray-300 rounded w-full input-field">
                </div>
                <div class="mb-4">
                <label for="phone" class="block text-sm font-medium input-label">Phone Number</label>  
                    <input type="text" name="phone" required class="p-2 border border-gray-300 rounded w-full input-field">
                </div>
                <div class="mb-4">
                <label for="email" class="block text-sm font-medium input-label">Email</label>  
                    <input type="email" name="email" required class="p-2 border border-gray-300 rounded w-full input-field">
                </div>
                <button type="submit" name="register" class="w-full text-white p-2 rounded-md register-button focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"">
                    Register
                </button>
            </form>
        </div>
    </div>
    <?php
    // // Assuming the registration process is successful
    // $registrationSuccess = true; // Set to true after successful registration

    // if ($registrationSuccess) {
    //     echo "
    //     <div class='fixed top-0 right-0 mt-4 mr-4 max-w-xs w-full bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md success-message'>
    //         <strong class='font-bold'>Success!</strong>
    //         <span>Your staff member has been successfully registered.</span>
    //     </div>
    //     ";
    // }
    ?>
</body>

</html>