<?php

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["username"]) 
                            && isset($_POST["password"]) && isset($_POST["confirm-password"])) {
    if (
        empty(trim($_POST["name"])) || empty(trim($_POST["username"])) ||
        empty(trim($_POST["password"])) || empty(trim($_POST["confirm-password"]))
    ) {
        echo "<script>alert('All fields are required. Please fill out the form completely.');</script>";
        exit();
    }

    if ($_POST["password"] !== $_POST["confirm-password"]) {
        echo "<script>alert('Passwords do not match. Please try again.'); window.location.href = 'createAccount.php';</script>";
        exit();
    }

    $name = htmlspecialchars($_POST["name"]);
    $username = htmlspecialchars($_POST["username"]);
    $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO `users`(`name`, `username`, `password`, `role_id`) VALUES (?, ?, ?, 2)");
    $stmt->bind_param("sss", $name, $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully!');</script>";
        header("Location: login.php");
        exit();
    } else {
        if ($conn->errno === 1062) {
            echo "<script>alert('Error: This username is already taken. Please choose a different username.');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
    }
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="utf-8">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - CT ZONE</title>
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
        <h1><i class="fas fa-user-plus"></i> Create Account</h1>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
                <i class="input-icon fas fa-user"></i>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Choose a username" required>
                <i class="input-icon fas fa-at"></i>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create a password"
                    minlength="8" id="passType" required>
                <i class="input-icon fas fa-lock"></i>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm-password"
                    placeholder="Confirm your password" minlength="8"
                    id="confirmPassType" required>
                <i class="input-icon fas fa-shield"></i>
            </div>
            <div class="show-password">
                <input type="checkbox" onclick="Toggle()" id="showPass">
                <label for="showPass"><i class="far fa-eye"></i> Show Password</label>
            </div>
            <button type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
            <a href="login.php" class="guest-link">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </form>
    </div>

    <script>
        function Toggle() {
            let txtPass = document.getElementById("passType");
            let txtConfirmPass = document.getElementById("confirmPassType");
            const type = txtPass.type === "password" ? "text" : "password";
            txtPass.type = type;
            txtConfirmPass.type = type;
        }
    </script>
</body>

</html>