<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
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
        background:rgb(114, 113, 113);
        border-radius: 50%;
        cursor: pointer;
      }
      .pagination a.active {
        background-color: #ec4899;
        color: white;
        border: 1px solid #ec4899;
      }
      .pagination a:hover :not(.active) {
        background-color:rgb(191, 41, 129);
      }
    </style>
  </head>
  <body class="font-sans text-gray-700">
    <?php include '../Homepage/header.php';?>
    <!-- Customer List Section -->
    <div class="p-8">
      <h2 class="text-pink-700 mb-4" style="font-size: 35px; font-weight: bold;">Customer List</h2>
      <div class="overflow-x-auto bg-white rounded-lg shadow-md p-6">
        <table class="min-w-full border border-pink-100">
          <thead class="bg-pink-100">
            <tr>
              <th class="text-left px-4 py-2 border-b">#</th>
              <th class="text-left px-4 py-2 border-b">Name</th>
              <th class="text-center px-4 py-2 border-b">Email</th>
              <th class="text-center px-4 py-2 border-b">Phone</th>
              <th class="text-center px-4 py-2 border-b">Registration Date</th>
              <th class="text-right px-4 py-2 border-b">Total Orders</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            // Dummy data
            $customers = [
              ['id' => 1, 'name' => 'Asyraf Haziq', 'email' => 'asyraf@gmail.com', 'phone' => '123-456-7890', 'date' => '2023-01-12', 'orders' => 15],
              ['id' => 2, 'name' => 'Zahin Eifwat', 'email' => 'zahin@gmail.com', 'phone' => '987-654-3210', 'date' => '2023-02-05', 'orders' => 9],
              ['id' => 3, 'name' => 'Wafiuddin', 'email' => 'wafi@gmail.com', 'phone' => '456-789-1230', 'date' => '2023-03-22', 'orders' => 22],
              ['id' => 4, 'name' => 'Sharifah Nur Ain', 'email' => 'Ipahh@gmail.com', 'phone' => '321-654-9870', 'date' => '2023-04-10', 'orders' => 7],
              ['id' => 5, 'name' => 'Rina Kartika', 'email' => 'rinahs@gmail.com', 'phone' => '890-213-5436', 'date' => '2023-10-21', 'orders' => 10],
            ];

            // Pagination logic
            $itemsPerPage = 10;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;
            $paginatedCustomers = array_slice($customers, $offset, $itemsPerPage);

            foreach ($paginatedCustomers as $customer) {
              echo "
              <tr class='border-b hover:bg-pink-50'>
                <td class='text-left px-4 py-2'>{$customer['id']}</td>
                <td class='text-left px-4 py-2'>{$customer['name']}</td>
                <td class='text-center px-4 py-2'>{$customer['email']}</td>
                <td class='text-center px-4 py-2'>{$customer['phone']}</td>
                <td class='text-center px-4 py-2'>{$customer['date']}</td>
                <td class='text-right px-4 py-2'>{$customer['orders']}</td>
              </tr>
              ";
            }
            ?>
          </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination">
          <?php
          $totalPages = ceil(count($customers) / $itemsPerPage);
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