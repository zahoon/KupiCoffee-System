<?php
session_start();
// Check for error message in session
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
// Clear the error message after displaying it
unset($_SESSION['error']);
?>
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login Page</title>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
    <style>
        body {
            background-image: url(../image/bgDel.png);
            background-size: cover;
            color: #444;
        }
        .login-container {
            background:rgb(255, 248, 207);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            color: #7a2005;
            font-family: 'Roboto', sans-serif;
        }
        .input-label {
            font-family: 'Roboto', sans-serif;
            color: #7a2005;
        }
        .login-button {
            background-color: #7a2005;
            transition: background-color 0.3s ease;
        }
        .login-button:hover {
            background-color: #5c1603;
        }
        .register-link {
            color: #7a2005;
            text-decoration: underline;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .register-link:hover {
            color: #D97706;
        }
        .error-message {
            color: #ff0000;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            text-align: center;
        }
    </style>
</head>  
<body class="bg-gray-100">  
    <?php include '../Homepage/header.php'; ?>  
    <div class="flex items-center justify-center h-screen">  
        <div class="login-container p-8 rounded-lg shadow-lg w-full max-w-sm">  
            <h2 class="text-2xl font-bold mb-6 text-center login-title">Customer Login</h2>  
            <!-- Display error message if it exists -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form action="c_login.php" method="POST">  
                <div class="mb-4">  
                    <label for="username" class="block text-sm font-medium input-label">Username</label>  
                    <input type="text" id="username" name="username" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">  
                </div>  
                <div class="mb-6">  
                    <label for="password" class="block text-sm font-medium input-label">Password</label>  
                    <input type="password" id="password" name="password" required class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">  
                </div>  
                <button type="submit" class="w-full text-white p-2 rounded-md login-button focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Login</button>  
            </form>  
            <div class="mt-4 text-center">
                <a href="c.register.php" class="register-link">Don't have an account yet? Register now!</a>
            </div>
            <button onclick="window.location.href='../Staff/s_login.php'" class="w-full mt-4 text-white p-2 rounded-md bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">Staff Login</button>
        </div>  
    </div>  
</body>  
</html>