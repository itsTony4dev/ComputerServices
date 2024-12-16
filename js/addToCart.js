document.addEventListener("DOMContentLoaded", function () {
    const addToCart = (componentId) => {
        fetch("addToCart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ component_id: componentId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding to the cart.');
        });
    };

    document.querySelectorAll(".addToCartBtn").forEach((button) => {
        button.addEventListener("click", () => {
            const componentId = button.getAttribute('data-component-id');
            if (componentId) {
                addToCart(componentId);
            } else {
                alert('Component ID not found');
            }
        });
    });
});