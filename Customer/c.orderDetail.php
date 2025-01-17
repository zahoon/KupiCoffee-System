<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Detail</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: rgb(255, 191, 230);
      padding-top: 100px;
      font-family: 'Lucida Sans', sans-serif;
      background-image: url(../image/bgDel.png);
      background-size: cover;
    }
    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .scrollable-box {
      max-height: 180px; 
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #f9a8d4 #f9fafb;
    }
    .scrollable-box::-webkit-scrollbar {
      width: 8px;
    }
    .scrollable-box::-webkit-scrollbar-thumb {
      background-color: #f9a8d4;
      border-radius: 4px;
    }
    .scrollable-box::-webkit-scrollbar-track {
      background-color: #f9fafb;
    }
  </style>
</head>
<body>
  <?php include '../Homepage/header.php'; ?>
  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-pink-600 mb-6">Order Detail #8242</h1>
    <div class="grid grid-cols-2 gap-6">
      <!-- Order Summary -->
      <div class="bg-pink-50 p-4 rounded-lg">
        <h2 class="text-xl font-semibold text-pink-700 mb-4">Order Summary</h2>
        <div class="space-y-2">
          <p><span class="font-medium">Order ID:</span> 8242</p>
          <p><span class="font-medium">Status:</span> Ready for Pickup</p>
          <p><span class="font-medium">Total:</span> RM20.00</p>
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
      <div class="scrollable-box">
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
          <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
            <div>
              <p class="font-medium">Espresso</p>
              <p class="text-sm text-gray-600">Quantity: 3</p>
            </div>
            <p class="text-pink-700">RM15.00</p>
          </div>
          <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
            <div>
              <p class="font-medium">Cappuccino</p>
              <p class="text-sm text-gray-600">Quantity: 1</p>
            </div>
            <p class="text-pink-700">RM10.00</p>
          </div>
          <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
            <div>
              <p class="font-medium">Mocha</p>
              <p class="text-sm text-gray-600">Quantity: 2</p>
            </div>
            <p class="text-pink-700">RM14.00</p>
          </div>
          <div class="flex justify-between items-center p-4 bg-pink-50 rounded-lg">
            <div>
              <p class="font-medium">Americano</p>
              <p class="text-sm text-gray-600">Quantity: 1</p>
            </div>
            <p class="text-pink-700">RM9.00</p>
          </div>
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