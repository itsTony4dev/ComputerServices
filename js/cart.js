document.addEventListener("DOMContentLoaded", function () {
  const updateQuantity = (cartId, action) => {
    fetch("updateCartQuantity.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ cart_id: cartId, action: action }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const quantityElement = document.getElementById(`qtty-${cartId}`);
          quantityElement.textContent = data.new_quantity;
          calculateTotal();
        } else {
          alert(data.message);
        }
      })
      .catch((error) => console.error("Error:", error));
  };

  document.querySelectorAll(".quantity-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const cartId = button.getAttribute("data-cart-id");
      const action = button.classList.contains("plus")
        ? "increase"
        : "decrease";
      updateQuantity(cartId, action);
    });
  });
});

const show = () => {
  if (document.getElementById("dropdown-menu").style.display != "block") {
    document.getElementById("dropdown-menu").style.display = "block";
  } else {
    return (document.getElementById("dropdown-menu").style.display = "none");
  }
};

const calculateTotal = () => {
  let total = 0;
  const cartItems = document.querySelectorAll(".cart-card");
  cartItems.forEach((item) => {
    const priceText = item.querySelector(".product-price").textContent.replace('$', '');
    const price = parseFloat(priceText);
    const quantity = parseInt(item.querySelector(".quantity").textContent);
    total += price * quantity;
  });
  document.getElementById("total-price").textContent = `Total: $${total}`;
};
