<?php  
session_start();  
include '../Admin/kupi.php'; // Include your database connection file  

// Handle addition of new coffee item  
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {  
    $name = $_POST['name'];  
    $description = $_POST['description'];  
    $price = $_POST['price'];  

    $conn = getConnection();  
    $sql = 'INSERT INTO KUPI (K_NAME, K_DESC, K_PRICE) VALUES (:name, :description, :price)';  
    $stmt = oci_parse($conn, $sql);  
    oci_bind_by_name($stmt, ':name', $name);  
    oci_bind_by_name($stmt, ':description', $description);  
    oci_bind_by_name($stmt, ':price', $price);  
    oci_execute($stmt);  
    oci_free_statement($stmt);  
    oci_close($conn);  
}  

// Handle deletion of coffee item  
if (isset($_GET['delete'])) {  
    $id = $_GET['delete'];  

    $conn = getConnection();  
    $sql = 'DELETE FROM KUPI WHERE KUPID = :id';  
    $stmt = oci_parse($conn, $sql);  
    oci_bind_by_name($stmt, ':id', $id);  
    oci_execute($stmt);  
    oci_free_statement($stmt);  
    oci_close($conn);  
}  

// Fetch all coffee items  
$conn = getConnection();  
$sql = 'SELECT * FROM KUPI';  
$stmt = oci_parse($conn, $sql);  
oci_execute($stmt);  
$coffeeItems = oci_fetch_all($stmt, $results, 0, -1, OCI_FETCHSTATEMENT_BY_ROW);  
oci_free_statement($stmt);  
oci_close($conn);  
?>  

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Coffee Management</title>  
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
</head>  
<body class="bg-gray-100">  
    <?php include '../Homepage/header.php'; ?>  

    <div class="p-8">  
        <h2 class="text-2xl font-bold mb-6">Manage Coffee Items</h2>  

        <!-- Add Coffee Item Form -->  
        <form action="a_kupi.php" method="POST" class="mb-8">  
            <input type="text" name="name" placeholder="Name" required class="p-2 border border-gray-300 rounded">  
            <input type="text" name="description" placeholder="Description" required class="p-2 border border-gray-300 rounded">  
            <input type="number" name="price" placeholder="Price" step="0.01" required class="p-2 border border-gray-300 rounded">  
            <button type="submit" name="add" class="bg-blue-500 text-white p-2 rounded">Add Coffee Item</button>  
        </form>  

        <!-- Coffee Items Table -->  
        <table class="min-w-full bg-white border border-gray-300">  
            <thead>  
                <tr>  
                    <th class="border px-4 py-2">KUPID</th>  
                    <th class="border px-4 py-2">Name</th>  
                    <th class="border px-4 py-2">Description</th>  
                    <th class="border px-4 py-2">Price</th>  
                    <th class="border px-4 py-2">Actions</th>  
                </tr>  
            </thead>  
            <tbody>  
                <?php foreach ($results as $item): ?>  
                    <tr>  
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['KUPID']) ?></td>  
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['K_NAME']) ?></td>  
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['K_DESC']) ?></td>  
                        <td class="border px-4 py-2"><?= htmlspecialchars($item['K_PRICE']) ?></td>  
                        <td class="border px-4 py-2">  
                            <a href="a_kupi.php?delete=<?= htmlspecialchars($item['KUPID']) ?>" class="text-red-500">Delete</a>  
                        </td>  
                    </tr>  
                <?php endforeach; ?>  
            </tbody>  
        </table>  
    </div>  
</body>  
</html>