<?php
session_start();
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"]) && 
    !empty(trim($_POST["username"])) && !empty(trim($_POST["password"]))) {

    $username = $_POST["username"];
    $inputPassword = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        echo header("Location: login.php");
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Invalid username or password'); window.location.href = 'login.php';</script>";
        exit();
    }

    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    if (!password_verify($inputPassword, $hashedPassword)) {
        echo "<script>alert('Invalid username or password'); window.location.href = 'login.php';</script>";
        exit();
    }

    $_SESSION["name"] = $row["name"];
    $_SESSION["user_id"] = $row["id"];
    $_SESSION["role"] = $row["role_id"];
    $_SESSION["is_logged_in"] = true;

    if ($row["role_id"] == 1) {
        header("Location: admin.php");
    } else {
        header("Location: home.php");
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="utf-8">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CT ZONE</title>
    <link rel="icon" href="pictures/loginlogo.png">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img src="pictures/loginlogo.png" alt="CT ZONE Logo">
        </div>
        <h1><i class="fas fa-computer"></i> Welcome Back</h1>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
                <i class="input-icon fas fa-user"></i>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password"
                    minlength="8" id="typepass" required>
                <i class="input-icon fas fa-lock"></i>
            </div>
            <div class="show-password">
                <input type="checkbox" onclick="Toggle()" id="showPass">
                <label for="showPass"><i class="far fa-eye"></i> Show Password</label>
            </div>
            <button type="submit"><i class="fas fa-right-to-bracket"></i> Sign In</button>
            <button type="button" class="create-account"
                onclick="window.location.href='createAccount.php'">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
            <a href="home.php" class="guest-link">
                <i class="fas fa-user-secret"></i> Continue as Guest
            </a>
        </form>
    </div>

    <script>
        function Toggle() {
            let txtPass = document.getElementById("typepass");
            txtPass.type = txtPass.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>