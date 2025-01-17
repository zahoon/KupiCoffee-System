<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      body {
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        background-color: rgb(249, 223, 239);
        margin: 0;
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
      .staff-image {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
      }
    </style>
  </head>
  <body class="text-gray-700">
    <?php include '../Homepage/header.php';?>
    <!-- Staff List Section -->
    <div class="p-8">
      <h2 class="text-pink-700 mb-4" style="font-size: 35px; font-weight: bold;">Staff List</h2>
      <div class="overflow-x-auto bg-white rounded-lg shadow-md p-6">
        <table class="min-w-full border border-blue-100">
          <thead class="bg-pink-100">
            <tr>
              <th class="text-center px-4 py-2 border-b"></th>
              <th class="text-left px-4 py-2 border-b">Name</th>
              <th class="text-left px-4 py-2 border-b">Role</th>
              <th class="text-left px-4 py-2 border-b">Email</th>
              <th class="text-left px-4 py-2 border-b">Phone</th>
              <th class="text-left px-4 py-2 border-b">Join Date</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            // Dummy staff data with image URLs
            $staff = [
              ['id' => 1, 'name' => 'Zahin Eifwat', 'role' => 'Store Manager', 'email' => 'zahin@gmail.com', 'phone' => '123-456-7890', 'join_date' => '2021-01-12', 'image' => '../image/staff1.jpg'],
              ['id' => 2, 'name' => 'Sharifah Nur Ain', 'role' => 'Head Barista', 'email' => 'Ipahh@gmail.com', 'phone' => '987-654-3210', 'join_date' => '2021-02-05', 'image' => '../image/staff2.jpg'],
              ['id' => 3, 'name' => 'Asyraf Haziq', 'role' => 'Supervisor', 'email' => 'asyraf@gmail.com', 'phone' => '456-789-1230', 'join_date' => '2021-03-22', 'image' => '../image/staff3.jpg'],
              ['id' => 4, 'name' => 'Rina Kartika', 'role' => 'Latte Artist', 'email' => 'rinahs@gmail.com', 'phone' => '321-654-9870', 'join_date' => '2021-04-10', 'image' => '../image/staff4.jpg'],
              ['id' => 5, 'name' => 'Wafiuddin', 'role' => 'Marketing Specialist', 'email' => 'wafi@gmail.com', 'phone' => '111-222-3333', 'join_date' => '2021-05-01', 'image' => '../image/staff5.jpg'],
            ];

            // Pagination logic
            $itemsPerPage = 5; // Number of items per page
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;
            $paginatedStaff = array_slice($staff, $offset, $itemsPerPage);

            foreach ($paginatedStaff as $staffMember) {
              echo "
              <tr class='border-b hover:bg-blue-50'>
                <td class='px-4 py-2 flex justify-center items-center'> <!-- Centered cell -->
                  <img src='{$staffMember['image']}' alt='{$staffMember['name']}' class='staff-image'>
                </td>
                <td class='px-4 py-2'>{$staffMember['name']}</td>
                <td class='px-4 py-2'>{$staffMember['role']}</td>
                <td class='px-4 py-2'>{$staffMember['email']}</td>
                <td class='px-4 py-2'>{$staffMember['phone']}</td>
                <td class='px-4 py-2'>{$staffMember['join_date']}</td>
              </tr>
              ";
            }
            ?>
          </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination">
          <?php
          $totalPages = ceil(count($staff) / $itemsPerPage);
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