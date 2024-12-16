<?php

session_start();
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true || $_SESSION['role'] !== 1) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $cat_id = $_GET['cat_id'];

    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $image_path = 'uploads/' . $row['image'];

        $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {

            if (file_exists($image_path)) {
                unlink($image_path);
            }

            if ($cat_id == 1) {
                header("Location: adminBuy.php");
            } else {
                header("Location: adminBuild.php");
            }
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

        $delete_stmt->close();
    }

    $stmt->close();
}

$conn->close();
