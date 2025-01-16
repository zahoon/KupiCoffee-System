<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Navbar -->
    <header class="bg-amber-950 p-4 shadow-md flex justify-between items-center">
        <!-- Logo and Text Container -->
        <div class="flex items-center space-x-4">
           <img src="../image/logowhite.png" alt="Logo" class="w-10">
           <h1 class="text-2xl font-mono text-pink-100">KupiCoffee</h1>
        </div>
        <div class="flex items-center space-x-4">
            <!-- User Name -->
            <div class="text-pink-100 fon">
                <?php
                include("../Customer/session.php");
                $username = getSession('username');
                if ($username) {
                    echo "Good to see you back, $username!";
                } else {
                    echo "Welcome to our website, Guest";
                }
                ?>
            </div>
            <!-- Menu Button -->
            <div class="relative">
                <button class="text-pink-100 font-medium" id="menu-button" aria-expanded="true" aria-haspopup="true">
                    Menu ▼
                </button>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-pink-100 ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>
                        <a href="Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>
                        <a href="../Customer/testlogin.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" role="menuitem" tabindex="-1" id="menu-item-2">Login</a>
                        <a href="../Customer/logout.php" class="text-black block px-4 py-2 text-sm hover:bg-red-200" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- to handle dropdown menu -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const menu = document.querySelector('.origin-top-right');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>