<?php
// Start the session at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userRole = 'customer';
?>
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
            <img src="../image/logo.png" alt="Logo" class="w-10">
            <h1 class="text-2xl font-mono text-pink-100">KupiCoffee</h1>
        </div>
        <div class="flex items-center space-x-4">
            <?php
            // Retrieve the username from the session
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
            if ($username) {
                echo "<span class='text-pink-100'>Welcome back, $username!</span>";
            } else {
                echo "<span class='text-pink-100'>Hello user!</span>";
            }
            ?>
            <div class="relative">
                <button class="text-pink-100 font-medium" id="menu-button" role="button">
                    Menu ▼
                </button>
                <ul class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-pink-100 ring-1 ring-black ring-opacity-5 hidden" id="dropdown-menu">
                    <?php
                    $role = isset($_SESSION['role']) ? $_SESSION['roll'] : null;
                    if ($role) {
                        if ($role === 'customer') {
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="../Homepage/index.php">Home</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="../Menu.php">Bookmarks</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="../Customer/profile.php">Profile</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="logout.php">Logout</a></li>';
                        } elseif ($role === 'Staff') {
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="../Staff/manageOrder.php">Manage Orders</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="logout.php">Logout</a></li>';
                        } elseif ($role === 'manager') {
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="Admin/custData.php">Customer Data</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="Admin/kupiData.php">Kupi Data</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="Admin/staffData.php">Staff Data</a></li>';
                            echo '<li><a class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50" href="logout.php">Logout</a></li>';
                        }
                    } else {
                        echo '<li><a href="../Homepage/index.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50">Home</a></li>';
                        echo '<li><a href="../Homepage/Menu.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50">Menu</a></li>';
                        echo '<li><a href="../Customer/testlogin.php" class="text-pink-500 block px-4 py-2 text-sm hover:bg-gray-50">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </header>

    <!-- JavaScript to handle dropdown menu -->
    <script>
        const menuButton = document.getElementById('menu-button');
        const dropdownMenu = document.getElementById('dropdown-menu');

        menuButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
