document.addEventListener("DOMContentLoaded", function () {
  const cartCards = document.querySelectorAll(".cart-card");

  cartCards.forEach((card) => {
    const incrementButton = card.querySelector(".plus");
    const decrementButton = card.querySelector(".minus");
    const quantitySpan = card.querySelector(".quantity");

    incrementButton.addEventListener("click", function () {
      let quantity = parseInt(quantitySpan.textContent);
      quantity++;
      quantitySpan.textContent = quantity;
    });

    decrementButton.addEventListener("click", function () {
      let quantity = parseInt(quantitySpan.textContent);
      if (quantity > 1) {
        quantity--;
        quantitySpan.textContent = quantity;
      }
    });
  });
});