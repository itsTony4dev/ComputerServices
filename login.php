<?php

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];


    $stmt = $conn->prepare(query: "SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");

    $stmt->bind_param("ss", $username,  $password);

    $stmt->execute();

    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $role = $row["role_id"];

        session_start();
        $_SESSION["name"] = $row["name"];
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["role"] = $role;
        $_SESSION["is_logged_in"] = true;

        if ($role == 1) {
            header(header: "Location: admin.php");
        } else {
            header(header: "Location: home.php");
        }
    }

    $conn->close();
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
        <h1>Login</h1>
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
            <input type="checkbox" onclick="Toggle()">
            <strong>Show Password</strong>
            <button type="submit">Login</button>
            <button><a href="createAccount.php" style="text-decoration: none; color:black;">Create Account</a></button>
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