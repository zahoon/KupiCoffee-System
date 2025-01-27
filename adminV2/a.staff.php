<?php
require_once '../Homepage/session.php';
require_once '../Homepage/dbkupi.php';

// Pagination logic
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM STAFF";
$countStmt = oci_parse($condb, $countQuery);
oci_execute($countStmt);
$totalRow = oci_fetch_assoc($countStmt);
$totalPages = ceil($totalRow['TOTAL'] / $itemsPerPage);
oci_free_statement($countStmt);

// Fetch staff with total orders handled
$sql = "
    WITH StaffOrders AS (
        SELECT 
            s.STAFFID,
            s.S_USERNAME,
            s.S_EMAIL,
            s.S_PHONENUM,
            s.S_ROLE,
            COUNT(o.ORDERID) as TOTAL_ORDERS,
            ROW_NUMBER() OVER (ORDER BY s.STAFFID) AS rnum
        FROM STAFF s
        LEFT JOIN ORDERTABLE o ON s.STAFFID = o.STAFFID
        GROUP BY s.STAFFID, s.S_USERNAME, s.S_EMAIL, s.S_PHONENUM, s.S_ROLE
    )
    SELECT * FROM StaffOrders
    WHERE rnum > :offset AND rnum <= :end_row
";

$stmt = oci_parse($condb, $sql);
$endRow = $offset + $itemsPerPage;
oci_bind_by_name($stmt, ":offset", $offset);
oci_bind_by_name($stmt, ":end_row", $endRow);
oci_execute($stmt);

$staff = array();
while ($row = oci_fetch_assoc($stmt)) {
    $staff[] = $row;
}
oci_free_statement($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff List</title>
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

    .pagination a:hover :not(.active) {
      background-color: rgb(191, 41, 129);
    }
  </style>
</head>

<body class="font-sans text-gray-700">
  <?php include '../Homepage/header.php'; ?>
  <!-- Staff List Section -->
  <div class="p-8">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-pink-700" style="font-size: 35px; font-weight: bold;">Staff List</h2>
      <a href="a.add_staff.php" class="inline-block px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
        Add New Staff
      </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?php 
          echo htmlspecialchars($_SESSION['error']);
          unset($_SESSION['error']);
        ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php 
          echo htmlspecialchars($_SESSION['success']);
          unset($_SESSION['success']);
        ?>
      </div>
    <?php endif; ?>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-6">
      <table class="min-w-full border border-pink-100">
        <thead class="bg-pink-100">
          <tr>
            <th class="text-left px-4 py-2 border-b">#</th>
            <th class="text-left px-4 py-2 border-b">Name</th>
            <th class="text-center px-4 py-2 border-b">Email</th>
            <th class="text-center px-4 py-2 border-b">Phone</th>
            <th class="text-center px-4 py-2 border-b">Role</th>
            <th class="text-center px-4 py-2 border-b">Orders Handled</th>
            <th class="text-center px-4 py-2 border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($staff as $member): ?>
            <tr class="border-b hover:bg-pink-50">
              <td class="text-left px-4 py-2"><?php echo htmlspecialchars($member['STAFFID']); ?></td>
              <td class="text-left px-4 py-2"><?php echo htmlspecialchars($member['S_USERNAME']); ?></td>
              <td class="text-center px-4 py-2"><?php echo htmlspecialchars($member['S_EMAIL']); ?></td>
              <td class="text-center px-4 py-2"><?php echo htmlspecialchars($member['S_PHONENUM']); ?></td>
              <td class="text-center px-4 py-2">
                <span class="px-2 py-1 rounded text-sm <?php echo $member['S_ROLE'] === 'Admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?>">
                  <?php echo htmlspecialchars($member['S_ROLE']); ?>
                </span>
              </td>
              <td class="text-center px-4 py-2"><?php echo htmlspecialchars($member['TOTAL_ORDERS']); ?></td>
              <td class="text-center px-4 py-2">
                <a href="a.view_staff.php?id=<?php echo $member['STAFFID']; ?>" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-1">View</a>
                <a href="a.edit_staff.php?id=<?php echo $member['STAFFID']; ?>" class="inline-block px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 mr-1">Edit</a>
                <a href="a.delete_staff.php?id=<?php echo $member['STAFFID']; ?>" class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" 
                   onclick="return confirm('Are you sure you want to delete this staff member?')">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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
</body>

</html>
