<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if (!$condb) {
    die("Database connection failed!"); // Extra safety check
}

// Insert data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/'; // Directory to store uploaded files
        $imageName = basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Store relative path in the database
            $imagePath = $targetFilePath;
        } else {
            die("Failed to upload image.");
        }
    } else {
        die("No image uploaded or an error occurred.");
    }

    // SQL query to insert data
    $sql = "INSERT INTO KUPI_TABLE (NAME, DESCRIPTION, PRICE, IMAGE) VALUES (:name, :description, :price, :image)";
    $stmt = oci_parse($condb, $sql);

    // Bind parameters
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":description", $description);
    oci_bind_by_name($stmt, ":price", $price);
    oci_bind_by_name($stmt, ":image", $imagePath);

    // Execute the query
    $result = oci_execute($stmt);

    if ($result) {
        echo "Kupi added successfully!";
    } else {
        $error = oci_error($stmt);
        echo "Failed to insert kupi: " . htmlspecialchars($error['message']);
    }

    // Free the statement
    oci_free_statement($stmt);
}

// Close the connection (optional; script termination will also close it)
oci_close($condb);
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Kupi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Add New Kupi</h1>
        <form method="POST" action="" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="price" name="price" step="0.01" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" id="description" name="description" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" id="image" name="image" required
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Add Kupi
                </button>
            </div>
        </form>
    </div>
</body>

</html>