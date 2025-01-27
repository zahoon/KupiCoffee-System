<?php require_once '../Homepage/session.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Navbar -->
    <header class="bg-amber-950 p-6 shadow-md flex justify-between items-center fixed top-0 w-full z-50">
        <!-- Logo and Text Container -->
        <div class="flex items-center space-x-4">
            <a href="../Homepage/index.php" class="no-underline"> <img src="../image/logo.png" alt="Logo" class="w-10"> </a>
            <a href="../Homepage/index.php" class="no-underline">
                <h1 class="text-2xl font-mono text-pink-100">KupiCoffee</h1>
            </a>
        </div>

        <!-- User Info and Navigation Links -->
        <div class="flex space-x-4">
            <?php
            // Retrieve the username from the session using getSession function
            $username = getSession('username');
            if ($username) {
                echo "<span class='text-pink-100 mt-1.5'><b>Welcome back, $username!</b></span>";
            } else {
                echo "<span class='text-pink-100'>Hello user!</span>";
            }
            ?>
            <div class="flex items-center space-x-1">
                <?php
                $custusername = getSession('username');
                $role = getSession('s_role');
                if ($custusername && empty($role)) {
                    echo '<a href="../Homepage/index.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                    echo '<a href="../Homepage/Menu.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                    echo '<a href="../Customer/c.profile.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-2">Profile</a>';
                    echo '<a href="../Homepage/logout.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid rounded" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>';
                } else if ($role == 'admin') {
                    echo '<div class="relative">';
                    echo '<button class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" id="home-menu-button" aria-expanded="true" aria-haspopup="true">Home <i class="fas fa-chevron-down ml-1"></i></button>';
                    echo '<div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-pink-100 ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="home-menu-button" tabindex="-1">';
                    echo '<div class="py-1" role="none">';
                    echo '<a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Homepage</a>';
                    echo '<a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                    echo '<a href="../Homepage/logout.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid" role="menuitem" tabindex="-1" id="menu-item-2">Logout</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<a href="../AdminV2/a.kupi.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-2">Kupi !</a>';
                    echo '<a href="../AdminV2/a.orders.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-3">Manage Order</a>';
                    
                    echo '<div class="relative">';
                    echo '<button class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" id="manage-user-button" aria-expanded="true" aria-haspopup="true">Manage User <i class="fas fa-chevron-down ml-1"></i></button>';
                    echo '<div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-pink-100 ring-1 ring-black ring-opacity-5 hidden" role="menu" aria-orientation="vertical" aria-labelledby="manage-user-button" tabindex="-1">';
                    echo '<div class="py-1" role="none">';
                    echo '<a href="../AdminV2/a.staff.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-0">Staff</a>';
                    echo '<a href="../AdminV2/a.customer.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50 no-underline" role="menuitem" tabindex="-1" id="menu-item-1">Customer</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<a href="../Admin/a.sales.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-6">Sales</a>';
                } else if ($role == 'staff') {
                    echo '<a href="../Homepage/index.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-0">Homepage</a>';
                    echo '<a href="../staffV2/s.editProfile.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-1">Profile</a>';
                    echo '<a href="../StaffV2/s.manageOrder.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-2">Manage Order</a>';
                    echo '<a href="../Homepage/logout.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-red-200 underline decoration-solid rounded" role="menuitem" tabindex="-1" id="menu-item-3">Logout</a>';
                } else {
                    echo '<div class="relative">';
                    echo '<a href="../Homepage/index.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-0">Home</a>';
                    echo '<a href="../Homepage/Menu.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-1">Menu</a>';
                    echo '<a href="../Customer/c.login.php" class="text-pink-500 px-4 py-2 text-sm hover:bg-gray-50 no-underline rounded" role="menuitem" tabindex="-1" id="menu-item-2">Login</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </header>

    <!-- Optional: Script to handle dropdown menu -->
    <script>
    // Function to toggle dropdown menus
    function toggleDropdown(buttonId, dropdownClass) {
        document.getElementById(buttonId).addEventListener('click', function() {
            const menu = document.querySelector(`#${buttonId} + ${dropdownClass}`);
            menu.classList.toggle('hidden');
        });
    }

    // Toggle the "Home" dropdown
    toggleDropdown('home-menu-button', '.origin-top-right');

    // Toggle the "Manage User" dropdown
    toggleDropdown('manage-user-button', '.origin-top-right');
</script>
</body>

</html>