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
  <!-- Data Tables -->
    <div class="p-8">
    <h2 class="text-xl font-semibold text-pink-700 mb-4">Customer Info</h2>
    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-lg shadow-md table-fixed">
        <thead class="bg-pink-100">
            <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Phone Number</th>
            <th class="px-4 py-2">Email</th>
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

</body>
</html>
