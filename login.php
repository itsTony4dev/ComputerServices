<?php
require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $username = $_POST["username"];
    $inputPassword = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
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
    <title>Login Form</title>
    <link rel="icon" href="pictures/loginlogo.png">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
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
            <a href="home.php" style="text-decoration: none; color:#c70000;"><i class="fa-solid fa-user fa-sm"></i>&nbsp; Enter as Guest</a>
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