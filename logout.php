<?php
session_start();
session_destroy();

$page = $_GET['page'];

switch ($page) {
    case 'admin':
        header(header: "Location: home.php");
        break;
    case 'build':
        header(header: "Location: build.php");
        break;
    case 'buy':
        header(header: "Location: buy.php");
        break;
    default:
        header(header: "Location: home.php");
        break;
}
