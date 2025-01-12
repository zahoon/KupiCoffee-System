<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee System Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #fff5f7;
    }
    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body class="font-sans text-gray-700">
  <?php include '../Homepage/header.html';?>

  <!-- Content Section -->
  <div class="p-8">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
      <h2 class="text-xl font-semibold text-pink-700">Admin Page</h2>
      <div class="flex space-x-2">
        <button class="bg-amber-950 text-white px-4 py-2 rounded hover:bg-pink-600">Coffee</button>
        <button class="bg-white border border-amber-950 text-amber-950 px-4 py-2 rounded hover:bg-amber-950">Non-Coffee</button>
      </div>
    </div>

    <!-- Coffee Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="card bg-white rounded-lg p-4">
        <div class="h-24 bg-pink-100 rounded-md mb-4"></div>
        <h3 class="text-pink-700 font-semibold">Name</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
      <!-- Duplicate above div for more cards -->
    </div>
  </div>

  <!-- Data Tables -->
<div class="p-8">
  <h2 class="text-xl font-semibold text-pink-700 mb-4">Customer Info</h2>
  <div class="overflow-x-auto">
    <table class="w-full bg-white rounded-lg shadow-md table-fixed">
      <thead class="bg-pink-100">
        <tr>
          <th class="px-4 py-2 w-1/4">ID</th>
          <th class="px-4 py-2 w-1/4">Name</th>
          <th class="px-4 py-2 w-1/4">Phone Number</th>
          <th class="px-4 py-2 w-1/4">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t">
          <td class="px-4 py-2">1</td>
          <td class="px-4 py-2">Sharifah Ain</td>
          <td class="px-4 py-2">123456789</td>
          <td class="px-4 py-2">ipah@gmail.com</td>
        </tr>
        <tr class="border-t">
          <td class="px-4 py-2">2</td>
          <td class="px-4 py-2">Rinahs</td>
          <td class="px-4 py-2">987654321</td>
          <td class="px-4 py-2">rina@gmail.com</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


  <!-- Statistics Section -->
  <div class="p-8">
    <h2 class="text-xl font-semibold text-pink-700 mb-4">Statistics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white rounded-lg p-6 shadow-md">
        <h3 class="text-pink-700 font-semibold mb-2">Total Sales</h3>
        <div class="h-40 bg-pink-100 rounded-md"></div>
      </div>
      <div class="bg-white rounded-lg p-6 shadow-md">
        <h3 class="text-pink-700 font-semibold mb-2">Total Purchases</h3>
        <div class="h-40 bg-pink-100 rounded-md"></div>
      </div>
    </div>
  </div>
</body>
</html>
