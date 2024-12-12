<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History Details</title>
    <style>
        :root {
            --primary-red: #FF3131;
            --deep-black: #121212;
            --soft-white: #f4f4f4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .details-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .details-header h2 {
            font-weight: 300;
            color: var(--primary-red);
        }

        .close-button {
            background-color: var(--deep-black);
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 0.9em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .close-button:hover {
            background-color: #000;
        }

        .product-list {
            list-style-type: none;
            padding: 0;
        }

        .product-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9e9e9;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-price {
            color: var(--primary-red);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="details-container">
        <div class="details-header">
            <h2>Order Details</h2>
            <button class="close-button">Close</button>
        </div>
        <ul class="product-list">
            <li>
                <div class="product-info">
                    <img src="https://via.placeholder.com/50" alt="Product Image" class="product-image">
                    <div>
                        <div class="product-name">Vintage Leather Jacket</div>
                        <div class="product-price">$149.99</div>
                    </div>
                </div>
                <div class="product-quantity">1</div>
            </li>
            <li>
                <div class="product-info">
                    <img src="https://via.placeholder.com/50" alt="Product Image" class="product-image">
                    <div>
                        <div class="product-name">Classic White Shirt</div>
                        <div class="product-price">$49.50</div>
                    </div>
                </div>
                <div class="product-quantity">1</div>
            </li>
        </ul>
    </div>
</body>
</html>