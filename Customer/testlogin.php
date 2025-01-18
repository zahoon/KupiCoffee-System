<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login Page</title>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
</head>  
<body class="bg-gray-100">  
    <?php include '../Homepage/header.php'; ?>  
    <div class="flex items-center justify-center h-screen">  
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">  
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>  
            <form action="login.php" method="POST">  
                <!-- Radio Buttons for User Type Selection -->  
                <div class="mb-4">  
                    <span class="block text-sm font-medium text-gray-700 mb-2">Select User Type:</span>  
                    <div class="flex items-center space-x-4">  
                        <label class="flex items-center cursor-pointer">  
                            <input type="radio" name="userType" value="customer" class="mr-2 text-blue-600 focus:ring-blue-500" required>  
                            <span class="text-gray-700">Customer</span>  
                        </label>  
                        <label class="flex items-center cursor-pointer">  
                            <input type="radio" name="userType" value="staff" class="mr-2 text-blue-600 focus:ring-blue-500" required>  
                            <span class="text-gray-700">Staff</span>  
                        </label>  
                    </div>  
                </div>  
                <div class="mb-4">  
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>  
                    <input type="text" id="username" name="username" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">  
                </div>  
                <div class="mb-6">  
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>  
                    <input type="password" id="password" name="password" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">  
                </div>  
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button>  
            </form>  
            <button onclick="window.location.href='testregister.php'" class="w-full mt-4 bg-green-500 text-white p-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Register</button>  
        </div>  
    </div>  
</body>  
</html>