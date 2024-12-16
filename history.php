<?php
    $page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - CT ZONE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background-image: url('pictures/pc2-backg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            z-index: -1;
        }

        .purchase-container {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            overflow: hidden;
            z-index: 1000;
        }

        .purchase-header {
            background: #c70000;
            color: white;
            padding: 25px;
            text-align: center;
        }

        .purchase-header h1 {
            font-size: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .purchase-table {
            width: 100%;
            border-collapse: collapse;
        }

        .purchase-table th,
        .purchase-table td {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .purchase-table th {
            background: rgba(0, 0, 0, 0.5);
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .purchase-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .order-date {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }

        .total-price {
            color: #c70000;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .view-details {
            background: #c70000;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 0.9rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-details:hover {
            background: #ff0000;
            transform: translateY(-2px);
        }

        .back-button {
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .back-button a {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-button a:hover {
            background: #c70000;
            transform: translateY(-2px);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .details-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            color: white;
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .details-header h2 {
            color: #c70000;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close-button {
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-button:hover {
            background: #c70000;
        }

        .product-list {
            list-style: none;
        }

        .product-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }

        .product-name {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .product-price {
            color: #c70000;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="purchase-container">
        <div class="purchase-header">
            <h1><i class="fas fa-history"></i> Purchase History</h1>
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
            <a href="<?=$page?? 'home'?>.php"><i class="fa-solid fa-left-long fa-xl"></i> Back</a>
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
        function closeModal() {
            document.getElementById('purchaseHistoryModal').style.display = 'none';
        }

        function openModal() {
            document.getElementById('purchaseHistoryModal').style.display = 'flex';
        }
    </script>
</body>

</html>