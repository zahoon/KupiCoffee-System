<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Detail</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
        background-color:rgb(255, 191, 230);
        padding-top: 100px;
        font-family: 'Lucida Sans', sans-serif;
        background-image: url(../image/bgDel.png);
        background-size: cover;
    }
    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
    
  <?php include '../Homepage/header.php';?>
  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-pink-600 mb-6">Order Detail #8242</h1>
    <div class="grid grid-cols-2 gap-6">
      <!-- Order Summary -->
      <div class="bg-pink-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Order Summary</h2>
        <div class="space-y-2">
          <p><span class="font-medium">Order ID:</span> 8242</p>
          <p><span class="font-medium">Status:</span> Ready for Pickup</p>
          <p><span class="font-medium">Total:</span>    RM20.00</p>
        </div>
      </div>

      <!-- Customer Info -->
      <div class="bg-pink-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Customer Info</h2>
        <div class="space-y-2">
          <p><span class="font-medium">Name:</span> Aina Rosdi</p>
          <p><span class="font-medium">Email:</span> aina@gmail.com</p>
          <p><span class="font-medium">Phone:</span> 123-456-7890</p>
        </div>
      </div>
    </div>

    <!-- Order Items -->
    <div class="mt-6">
      <h2 class="text-xl font-semibold text-pink-700 mb-4">Order Items</h2>
      <div class="space-y-4">
        <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
          <div>
            <p class="font-medium">Buttercreame Latte</p>
            <p class="text-sm text-gray-600">Quantity: 2</p>
          </div>
          <p class="text-pink-700">RM12.00</p>
        </div>
        <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
          <div>
            <p class="font-medium">Caramel Macchiato</p>
            <p class="text-sm text-gray-600">Quantity: 1</p>
          </div>
          <p class="text-pink-700">RM8.00</p>
        </div>
      </div>
    </div>

    <!-- Order Actions -->
    <div class="mt-6 flex justify-end space-x-4">
      <button class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Back to Orders</button>
    </div>
  </div>
</body>
</html>