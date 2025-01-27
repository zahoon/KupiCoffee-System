<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $k_name = $_POST['k_name'] ?? '';
    $k_desc = $_POST['k_desc'] ?? '';
    $k_price = $_POST['k_price'] ?? '';
    
    // Validate inputs
    $errors = array();
    
    if (empty($k_name)) {
        $errors[] = "Name is required";
    }
    if (empty($k_price) || !is_numeric($k_price)) {
        $errors[] = "Valid price is required";
    }
    
    // Handle image upload
    $k_image = null;
    if (isset($_FILES['k_image']) && $_FILES['k_image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['k_image']['tmp_name'];
        $k_image = file_get_contents($tmp_name);
    }
    
    if (empty($errors)) {
        // Insert new KUPI
        $sql = "INSERT INTO KUPI (K_NAME, K_DESC, K_PRICE, K_IMAGE) VALUES (:k_name, :k_desc, :k_price, EMPTY_BLOB()) RETURNING K_IMAGE INTO :k_image";
        
        $stmt = oci_parse($condb, $sql);
        
        // Bind parameters
        oci_bind_by_name($stmt, ":k_name", $k_name);
        oci_bind_by_name($stmt, ":k_desc", $k_desc);
        oci_bind_by_name($stmt, ":k_price", $k_price);
        
        // Bind the BLOB descriptor
        $blob = oci_new_descriptor($condb, OCI_D_LOB);
        oci_bind_by_name($stmt, ":k_image", $blob, -1, SQLT_BLOB);
        
        if (oci_execute($stmt, OCI_DEFAULT)) {
            if ($k_image !== null) {
                $blob->save($k_image);
            }
            oci_commit($condb);
            $_SESSION['success'] = "KUPI added successfully";
            header("Location: a.kupi.php");
            exit;
        } else {
            $e = oci_error($stmt);
            $errors[] = "Database error: " . htmlspecialchars($e['message']);
        }
        
        $blob->free();
        oci_free_statement($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New KUPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">Add New KUPI</h2>
                <a href="a.kupi.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Back to List
                </a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="k_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="k_name" id="k_name" 
                               value="<?php echo htmlspecialchars($_POST['k_name'] ?? ''); ?>"
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                               required>
                    </div>

                    <div>
                        <label for="k_desc" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="k_desc" id="k_desc" rows="3" 
                                  class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                        ><?php echo htmlspecialchars($_POST['k_desc'] ?? ''); ?></textarea>
                    </div>

                    <div>
                        <label for="k_price" class="block text-sm font-medium text-gray-700">Price (RM)</label>
                        <input type="number" name="k_price" id="k_price" step="0.01" min="0"
                               value="<?php echo htmlspecialchars($_POST['k_price'] ?? ''); ?>"
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500"
                               required>
                    </div>

                    <div>
                        <label for="k_image" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" name="k_image" id="k_image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                      file:rounded file:border-0 file:text-sm file:font-semibold
                                      file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100">
                        <p class="mt-1 text-sm text-gray-500">PNG, JPG or GIF</p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                            Add KUPI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
