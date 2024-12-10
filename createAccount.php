<?php

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirm-password"])) {
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
    <title>Login Form</title>
    <link rel="icon" href="pictures/loginlogo.png">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <img src="pictures/loginlogo.png" alt="">
        <h1>Create Account</h1>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" minlength="8" id="passType"
                    required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm-password" placeholder="Re-enter your password" minlength="8"
                    id="confirmPassType" required>
            </div>
            <input type="checkbox" onclick="Toggle()">
            <strong>Show Password</strong>
            <button type="submit">Sign Up</button>
        </form>
        <a href="login.php" style="text-decoration: none; color: red;"><b>Already have an account?</b> Login here</a>
        <script>
            function Toggle() {
                let txtPass = document.getElementById("passType");
                let txtConfirmPass = document.getElementById("confirmPassType");

                if (txtPass.type === "password") {
                    txtPass.type = "text";
                    txtConfirmPass.type = "text";
                } else {
                    txtPass.type = "password";
                    txtConfirmPass.type = "password";
                }
            }
        </script>
    </div>
</body>

</html>