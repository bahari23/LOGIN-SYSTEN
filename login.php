<?php
// login.php - User Login
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Error: All fields are required.";
        exit();
    }

    // Fetch user from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Set a cookie (expires in 1 hour)
        setcookie("user", $username, time() + 3600, "/");

        // Redirect to a dashboard or homepage
        header("Location: dashboard.php");
        exit();
    } else {
        echo "**ERROR!!: INVALID USERNAME OR PASSWORD.  PLEASE TRY AGAIN !!.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN ERROR</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>ERROR!!: INVALID USERNAME OR PASSWORD.  PLEASE TRY AGAIN !!,</h2>
        <a href="login.html" class="logout-button">RE-TRY</a>
    </div>
</body>
</html>
