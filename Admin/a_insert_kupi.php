<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Kupi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('../image/kupiOrder.png'); /* Add a coffee-related background image */
            background-size: cover;
            background-position: center;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background */
            backdrop-filter: blur(10px); /* Blur effect for a modern look */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <?php include '../Homepage/header.php'; ?>
    <div class="form-container p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold text-brown-900 mb-6 text-center">Add New Kupi</h1>
        <form method="POST" action="../Admin/insertkupi.php" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-brown-700">Coffee Name</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 sm:text-sm">
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-brown-700">Price</label>
                <input type="number" id="price" name="price" required
                    class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 sm:text-sm">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-brown-700">Description</label>
                <textarea id="description" name="description" required
                    class="mt-1 block w-full rounded-md border-brown-300 shadow-sm focus:border-brown-500 focus:ring-brown-500 sm:text-sm"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-brown-600 text-white py-2 px-4 rounded-md hover:bg-brown-700 focus:outline-none focus:ring-2 focus:ring-brown-500 focus:ring-offset-2">
                    Add Kupi
                </button>
            </div>
        </form>
    </div>
</body>
</html>