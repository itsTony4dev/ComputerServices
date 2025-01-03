<?php
session_start();
$page = $_GET['page'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - CT ZONE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/history.css">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
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
                <?php
                require_once "connection.php";
                $stmt = $conn->prepare("SELECT * FROM `orders` WHERE `user_id` = ?");
                $stmt->bind_param("i", $_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $dateString = $row["created_at"];
                    $timestamp = strtotime($dateString);
                    $formattedDate = date('F j, Y', $timestamp);
                    echo "<tr >";
                    echo "<td class='order-date'>" .  $formattedDate   . "</td>";
                    echo "<td class='total-price'>$" . $row["total_price"] . "</td>";
                    echo "<td><button class='view-details' data-order-id='" . $row["id"] . "' onclick='openModal(" . $row["id"] . ")'>View Details</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="back-button">
            <a href="<?= $page ?? 'home' ?>.php"><i class="fa-solid fa-left-long fa-xl"></i> Back</a>
        </div>
    </div>

    <div class="modal-overlay" id="purchaseHistoryModal">
        <div class="details-container">
            <div class="details-header">
                <h2>Order Details</h2>
                <button class="close-button" onclick="closeModal()">Close</button>
            </div>
            <ul class="product-list" id="modalProductList">
            </ul>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('purchaseHistoryModal').style.display = 'none';
        }

        function openModal(orderId) {
            fetch('getOrderItems.php?order_id=' + orderId)
                .then(response => response.json())
                .then(data => {
                    updateModalContent(data);
                    document.getElementById('purchaseHistoryModal').style.display = 'flex';
                });
        }

        function updateModalContent(data) {
            const productList = document.getElementById('modalProductList');
            productList.innerHTML = data.items.map(item => `
       <li>
           <div class="product-info">
               <img src="uploads/${item.image}" alt="Product Image" class="product-image">
               <div>
                   <div class="product-name">${(item.name).trim() == '' ? 'Gaming Pc' : item.name}</div>
                   <div class="product-price">$${item.price}</div>
           </div>
           <div class="product-quantity">Quantity: ${item.quantity}</div>
       </li>
   `).join('');
        }
    </script>
</body>
</div>

</html>