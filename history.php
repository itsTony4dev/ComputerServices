<?php
    $page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: url('pictures/home.webp');
        }

        .purchase-container {
            width: 100%;
            max-width: 750px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            z-index: 1000;
        }

        .purchase-header {
            background-color: #FF3131;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .purchase-header h1 {
            font-weight: 800;
            letter-spacing: 1px;
        }

        .purchase-table {
            width: 100%;
            border-collapse: collapse;
        }

        .purchase-table th,
        .purchase-table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e9e9e9;
            font-weight: 800;
        }

        .purchase-table td:nth-child(2){
            font-size: 21px;
        }

        .purchase-table th {
            background-color: #121212;
            color: white;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
        }

        .purchase-table tr:hover {
            background-color: #f8f8f8;
            transition: background-color 0.3s ease;
        }

        .order-date {
            color: #666;
            font-size: 1em;
        }

        .total-price {
            font-weight: bold;
            color: #FF3131;
            font-size: 1.2em;
        }

        @media (max-width: 600px) {
            .purchase-container {
                width: 100%;
                border-radius: 0;
            }
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
        }

        .view-details {
            background-color: #FF3131;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 0.9em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-details:hover {
            background-color: #d42424;
        }

        #logo {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            width: 190px;
            height: 120px;
            z-index: 100022;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .back-button a {
            background-color: #121212;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 0.9em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin-left: 35px;
            margin-bottom: 5px;
        }

        .back-button a:hover {
            background-color: #FF3131;
        }

        .back-button i {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <img src="pictures/loginlogo.png" alt="" id="logo">
    <div class="purchase-container">
        <div class="purchase-header">
            <h1>Purchase History</h1>
        </div>
        <table class="purchase-table">
            <thead>
                <tr>
                    <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="order-date">January 15, 2024</td>
                    <td class="total-price">$349.49</td>
                    <td><button class="view-details" onclick="openModal()">View Details</button></td>
                </tr>
                <tr>
                    <td class="order-date">February 03, 2024</td>
                    <td class="total-price">$279.50</td>
                    <td><button class="view-details" onclick="openModal()">View Details</button></td>
                </tr>
                <tr>
                    <td class="order-date">March 22, 2024</td>
                    <td class="total-price">$728.99</td>
                    <td><button class="view-details" onclick="openModal()">View Details</button></td>
                </tr>
                <tr>
                    <td class="order-date">April 10, 2024</td>
                    <td class="total-price">$199.75</td>
                    <td><button class="view-details" onclick="openModal()">View Details</button></td>
                </tr>
            </tbody>
        </table>
        <div class="back-button">
            <a href="<?=$page?>.php"><i class="fa-solid fa-left-long fa-xl"></i> Back</a>
        </div>
    </div>
    <div class="modal-overlay" id="purchaseHistoryModal">
        <div class="details-container">
            <div class="details-header">
                <h2>Order Details</h2>
                <button class="close-button" onclick="closeModal()">Close</button>
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
    </div>

    <script>
        // Function to close the modal
        function closeModal() {
            document.getElementById('purchaseHistoryModal').style.display = 'none';
        }

        // Optional: Open modal function if you want to trigger it programmatically
        function openModal() {
            document.getElementById('purchaseHistoryModal').style.display = 'flex';
        }
    </script>
</body>

</html>

<style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .details-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 600px;
            width: 100%;
            position: relative;
        }
        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .details-header h2 {
            font-weight: 300;
            color:#FF3131;
        }
        .close-button {
            background-color: #121212;
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
            color:#FF3131;
            font-weight: bold;
        }
    </style>