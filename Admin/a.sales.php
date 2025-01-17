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
  <?php include '../Homepage/header.php';?>
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
