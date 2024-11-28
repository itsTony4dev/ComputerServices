<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["password"] == $_POST["confirm-password"]) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $conn = new mysqli(hostname: "localhost", username: "root", password: "", database: "computerservices");
        $stmt = $conn->prepare(query: "INSERT INTO `user`( `username`, `password`, `role`) VALUES (?,?,0)");

        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo "<script>alert('User registered successfully!')</script>";
            header(header: "Location: login.php");
        } else {
            echo "<script> alert('Error: " . $stmt->error . "')</script>";
        }
        $stmt->close();
    } else {
        echo "<script> alert('Passwords does not match!') </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="utf-8">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="icon" href="pictures/loginlogo.png">
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
        <img src="pictures/loginlogo.png" alt="">
        <h1>Create Account</h1>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" minlength="8" id="typepass"
                    required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm-password" placeholder="Re-enter your password" minlength="8"
                    id="typepass" required>
            </div>
            <input type="checkbox" onclick="Toggle()">
            <strong>Show Password</strong>
            <button type="submit">Sign Up</button>
        </form>
        <script>
        function Toggle() {
            let txtPass = document.getElementById("typepass");

            if (txtPass.type === "password") {
                txtPass.type = "text";
            } else {
                txtPass.type = "password";
            }
        }
        </script>
    </div>
</body>

</html>