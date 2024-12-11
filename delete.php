<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($_GET['cat_id'] == 1) {
                header("Location: adminBuy.php");
                exit();
            } else {
                header("Location: adminBuild.php");
                exit();
            }
        }
        $conn->close();
    }
}
