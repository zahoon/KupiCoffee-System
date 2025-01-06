let cartItems = [];

// Function to display the cart items
function displayCartItems() {
  const cartItemsContainer = document.getElementById("cart-items-container");
  cartItemsContainer.innerHTML = "";

  // Iterate over the cart items and generate the cart view
  cartItems.forEach((item) => {
    const itemElement = document.createElement("div");
    itemElement.innerHTML = `
      <p>Name: ${item.name}</p>
      <p>Price: ${item.price}</p>
      <p>Quantity: ${item.quantity}</p>
    `;
    cartItemsContainer.appendChild(itemElement);
  });
}

// Event listener for the "View Cart" button
const viewCartButton = document.getElementById("view-cart-button");
viewCartButton.addEventListener("click", () => {
  displayCartItems();
});

// Example function to add an item to the cart
function addItemToCart(item) {
  cartItems.push(item);
}

// Example usage
const selectedItem = {
  name: "Coffee Name",
  price: 10,
  quantity: 1,
};

addItemToCart(selectedItem);