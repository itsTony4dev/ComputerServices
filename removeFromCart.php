<?php
session_start();
require_once 'connection.php';

$id = $_GET['id'];
$stmt = "DELETE FROM `cart` WHERE `id` = $id";
$conn->query($stmt);
header("location: cart.php");
?>