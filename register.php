<?php
// register.php - User Registration
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Error: All fields are required.";
        exit();
    }

    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $userExists = $stmt->fetchColumn();

    if ($userExists) {
        echo "ERROR!!: USERNAME ALREADY EXIST.  PLEASE USE ANOTHER USERNAME !!.";
    } else {
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $hashedPassword])) {
            // Redirect to login page
            header("Location: login.html");
            exit();
        } else {
            echo "Error registering user.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>ERROR!!: USERNAME ALREADY EXIST.  PLEASE USE ANOTHER USERNAME !!.</h2>
        <a href="register.html" class="logout-button">TRY AGAIN</a>
    </div>
</body>
</html>
