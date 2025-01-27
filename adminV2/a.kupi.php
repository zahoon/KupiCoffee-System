<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

// Pagination logic
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM KUPI";
$countStmt = oci_parse($condb, $countQuery);
oci_execute($countStmt);
$totalRow = oci_fetch_assoc($countStmt);
$totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);
oci_free_statement($countStmt);

// Get KUPI items with pagination
$sql = "
    SELECT k.*, ROWNUM as rnum
    FROM (
        SELECT 
            KUPIID,
            K_NAME,
            K_DESC,
            K_PRICE,
            ROWNUM as row_num
        FROM KUPI
        ORDER BY KUPIID
    ) k
    WHERE ROWNUM <= :end_row
    AND row_num > :offset
";

$stmt = oci_parse($condb, $sql);
$endRow = $offset + $itemsPerPage;
oci_bind_by_name($stmt, ":offset", $offset);
oci_bind_by_name($stmt, ":end_row", $endRow);
oci_execute($stmt);

$items = array();
while ($row = oci_fetch_assoc($stmt)) {
    $items[] = $row;
}
oci_free_statement($stmt);

// Handle success/error messages
$message = '';
$messageType = '';
if (isset($_SESSION['success'])) {
    $message = $_SESSION['success'];
    $messageType = 'success';
    unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    $messageType = 'error';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUPI Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f0f4f8;
            padding-top: 70px;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 10px;
        }
        .pagination a {
            width: 10px;
            height: 10px;
            background: rgb(114, 113, 113);
            border-radius: 50%;
            cursor: pointer;
        }
        .pagination a.active {
            background-color: #ec4899;
            color: white;
            border: 1px solid #ec4899;
        }
        .pagination a:hover:not(.active) {
            background-color: rgb(191, 41, 129);
        }
    </style>
</head>
<body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php'; ?>
    
    <div class="p-8">
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-pink-700 text-3xl font-bold">KUPI Management</h2>
                <a href="a.kupi_add.php" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                    Add New KUPI
                </a>
            </div>

            <?php if ($message): ?>
                <div class="mb-4 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-pink-100">
                        <thead class="bg-pink-50">
                            <tr>
                                <th class="text-left px-4 py-2 border-b">Name</th>
                                <th class="text-left px-4 py-2 border-b">Description</th>
                                <th class="text-right px-4 py-2 border-b">Price (RM)</th>
                                <th class="text-center px-4 py-2 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr class="border-b hover:bg-pink-50">
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($item['K_NAME'] ?? ''); ?></td>
                                    <td class="px-4 py-2"><?php echo htmlspecialchars($item['K_DESC'] ?? ''); ?></td>
                                    <td class="px-4 py-2 text-right"><?php echo number_format($item['K_PRICE'], 2); ?></td>
                                    <td class="px-4 py-2 text-center space-x-2">
                                        <a href="a.kupi_edit.php?id=<?php echo $item['KUPIID']; ?>" 
                                           class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Edit
                                        </a>
                                        <a href="a.kupi_delete.php?id=<?php echo $item['KUPIID']; ?>" 
                                           class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                           onclick="return confirm('Are you sure you want to delete this item?')">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = $i === $currentPage ? 'active' : '';
                        echo "<a href='?page=$i' class='$activeClass'></a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
