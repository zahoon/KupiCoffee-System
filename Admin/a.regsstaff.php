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
            <form action="a_regstaff_process.php" method="POST">  
                <input type="text" name="username" placeholder="Username" required class="p-2 border border-gray-300 rounded mb-4 w-full">  
                <input type="password" name="password" placeholder="Password" required class="p-2 border border-gray-300 rounded mb-4 w-full">  
                <input type="text" name="phone" placeholder="Phone Number" required class="p-2 border border-gray-300 rounded mb-4 w-full">  
                <input type="email" name="email" placeholder="Email" required class="p-2 border border-gray-300 rounded mb-4 w-full">  
                <input type="hidden" name="adminid" value="1"> <!-- Assuming a default admin ID -->  
                <button type="submit" name="register" class="bg-blue-500 text-white p-2 rounded w-full">Register</button>  
            </form>  
        </div>  
    </div>  
</body>  
</html>