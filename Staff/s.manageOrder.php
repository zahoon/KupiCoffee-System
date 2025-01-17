<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Orders</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Lucida Sans', sans-serif;
      background-image: url(../image/bgDel.png);
      background-size: cover;
      color: #444;
      padding-top: 100px;
    }
    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .popup-content {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 400px;
      max-width: 90%;
    }
    .scrollable-box {
      max-height: 480px;
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
  <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-3xl font-bold text-pink-600 mb-6">Manage Orders</h1>

    <!-- Order List -->
    <div class="scrollable-box">
      <div class="space-y-4">
        <?php
        $orders = [
          ['id' => 8242, 'customer' => 'Aina Rosdi', 'total' => 20.00, 'status' => 'Pending'],
          ['id' => 8235, 'customer' => 'Nurul Asyiqin', 'total' => 15.00, 'status' => 'Pending'],
          ['id' => 8220, 'customer' => 'Humairah Shahirah', 'total' => 10.00, 'status' => 'Pending'],
        ];

        foreach ($orders as $order) {
          echo "
          <div class='flex justify-between items-center p-4 bg-pink-50 rounded-lg'>
            <div>
              <p class='font-medium'>Order #{$order['id']}</p>
              <p class='text-sm text-gray-600'>Customer: {$order['customer']}</p>
              <p class='text-sm text-gray-600'>Total: RM{$order['total']}</p>
            </div>
            <div class='flex space-x-4'>
              <button onclick='approveOrder({$order['id']})' class='bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600'>
              <i class='fas fa-check-circle'></i> <!-- Approve Icon -->
              </button>
              <button onclick='openDeclinePopup({$order['id']})' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>
                <i class='fas fa-times-circle'></i> <!-- Decline Icon -->
              </button>
            </div>
          </div>
          ";
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Decline Popup -->
  <div id="declinePopup" class="popup">
    <div class="popup-content">
      <h2 class="text-xl font-bold text-pink-700 mb-4">Decline Order</h2>
      <form onsubmit="declineOrder(event)">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Reason for Declination</label>
            <select id="declineReason" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" required>
              <option value="Out of stock">Out of stock</option>
              <option value="Not available yet">Not available yet</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div id="otherReasonContainer" class="hidden">
            <label class="block text-sm font-medium text-gray-700">Other Reason</label>
            <textarea id="otherReason" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg" rows="3"></textarea>
          </div>
        </div>
        <div class="mt-6 flex justify-end space-x-4">
          <button type="button" onclick="closeDeclinePopup()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Cancel</button>
          <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Popup -->
  <div id="successPopup" class="popup">
    <div class="popup-content">
      <h2 class="text-xl font-bold text-pink-700 mb-4">Success!</h2>
      <p class="text-gray-700">The order has been approved successfully.</p>
      <div class="mt-6 flex justify-center">
        <button onclick="closeSuccessPopup()" class="bg-pink-700  text-white px-4 py-2 rounded-lg hover:bg-pink-200">OK</button>
      </div>
    </div>
  </div>

  <script>
    let currentOrderId = null;

    function openDeclinePopup(orderId) {
      currentOrderId = orderId;
      document.getElementById('declinePopup').style.display = 'flex';
    }

    function closeDeclinePopup() {
      document.getElementById('declinePopup').style.display = 'none';
      document.getElementById('otherReasonContainer').classList.add('hidden');
      document.getElementById('declineReason').value = '';
      document.getElementById('otherReason').value = '';
    }

    function declineOrder(event) {
      event.preventDefault();
      const reason = document.getElementById('declineReason').value;
      const otherReason = document.getElementById('otherReason').value;

      const fullReason = reason === 'Other' ? otherReason : reason;

      console.log(`Order #${currentOrderId} declined. Reason: ${fullReason}`);
      closeDeclinePopup();
    }

    function approveOrder(orderId) {
      document.getElementById('successPopup').style.display = 'flex';

      setTimeout(() => {
        const orderElement = document.getElementById(`order-${orderId}`);
        if (orderElement) {
          orderElement.remove();
        }
        closeSuccessPopup();
      }, 1500);
    }

    function closeSuccessPopup() {
      document.getElementById('successPopup').style.display = 'none';
    }

    document.getElementById('declineReason').addEventListener('change', function () {
      const otherReasonContainer = document.getElementById('otherReasonContainer');
      if (this.value === 'Other') {
        otherReasonContainer.classList.remove('hidden');
      } else {
        otherReasonContainer.classList.add('hidden');
      }
    });
  </script>
</body>
</html>