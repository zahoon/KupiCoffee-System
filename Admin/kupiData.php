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
        <div class="h-24 bg-pink-100 rounded-md mb-4">
        <img src="../image/AMERICANO.png" class="w-20">
        </div>
        <h3 class="text-pink-700 font-semibold">Caramel Latte</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
      <div class="card bg-white rounded-lg p-4">
        <div class="h-24 bg-pink-100 rounded-md mb-4">
        <img src="../image/AMERICANO.png" class="w-20">
        </div>
        <h3 class="text-pink-700 font-semibold">Caramel Latte</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
      <div class="card bg-white rounded-lg p-4">
        <div class="h-24 bg-pink-100 rounded-md mb-4">
        <img src="../image/AMERICANO.png" class="w-20">
        </div>
        <h3 class="text-pink-700 font-semibold">Caramel Latte</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
      <div class="card bg-white rounded-lg p-4">
        <div class="h-24 bg-pink-100 rounded-md mb-4">
        <img src="../image/AMERICANO.png" class="w-20">
        </div>
        <h3 class="text-pink-700 font-semibold">Caramel Latte</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
      <div class="card bg-white rounded-lg p-4">
        <div class="h-24 bg-pink-100 rounded-md mb-4">
        <img src="../image/AMERICANO.png" class="w-20">
        </div>
        <h3 class="text-pink-700 font-semibold">Caramel Latte</h3>
        <p class="text-sm text-gray-500 mb-2">Description</p>
        <button class="bg-pink-200 text-amber-950 px-4 py-2 rounded hover:bg-pink-400">Details</button>
      </div>
    </div>
  </div>
  </body>
  </html>