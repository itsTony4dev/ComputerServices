<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'computer_services';

$conn = new mysqli(hostname: $host, username: $username, password: $password, database: $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
