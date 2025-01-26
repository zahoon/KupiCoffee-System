<?php require_once '../Homepage/session.php'; ?>
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
    <header class="bg-amber-950 p-6 shadow-md flex justify-between items-center fixed top-0 w-full z-50">
        <!-- Logo and Text Container -->
        <div class="flex items-center space-x-4">
           <a href="../Homepage/index.php" class="no-underline"> <img src="../image/logo.png" alt="Logo" class="w-10"> </a>
           <a href="../Homepage/index.php" class="no-underline"> <h1 class="text-2xl font-mono text-pink-100">KupiCoffee</h1> </a>
        </div>
        <div class="flex items-center space-x-4">
            <?php
            // Retrieve the username from the session using getSession function
            $username = getSession('username');
            if ($username) {
                echo "<span class='text-pink-100'>Welcome back, $username!</span>";
            } else {
                echo "<span class='text-pink-100'>Hello user!</span>";
            }
            ?>
            <div class="relative">
                <button class="text-pink-100 font-medium" id="menu-button" aria-expanded="true" aria-haspopup="true">
                    About ▼
                </button>
                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-pink-100 ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                    <?php
                    // Retrieve the username from the session using getSession function
                    $custusername = getSession('username');
                    $role = getSession('s_role');
                    if ($custusername && empty($role)){
                        echo '<a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                        echo '<a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                        echo '<a href="../Customer/c.profile.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-2">Profile</a>';
                        echo '<a href="../Homepage/logout.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>';
                    } else if ($role == 'admin') {
                        echo '<a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                        echo '<a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                        echo '<a href="../Admin/a.customer.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-2">Customer</a>';
                        echo '<a href="../Admin/a.staff.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-3">Staff</a>';
                        echo '<a href="../Admin/a.kupi.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-4">Kupi !</a>';
                        echo '<a href="../Admin/a.sales.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-5">Sales</a>';
                        echo '<a href="../Homepage/logout.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid" role="menuitem" tabindex="-1" id="menu-item-6">Logout</a>';
                    } else if ($role == 'staff') {
                        echo '<a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                        echo '<a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                        echo '<a href="../Staff/s.manageOrder.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-2">Manage Order</a>';
                        echo '<a href="../Homepage/logout.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>';
                    } else {
                        echo '<a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                        echo '<a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                        echo '<a href="../Customer/c.login.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-2">Login</a>';
                        echo '<a href="../Homepage/logout.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>';
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Optional: Script to handle dropdown menu -->
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            const menu = document.querySelector('.origin-top-right');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>