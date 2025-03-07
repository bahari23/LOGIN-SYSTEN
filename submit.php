<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    if (empty($content)) {
        echo "Error: Submission content cannot be empty.";
        exit();
    }

    // Insert submission into database
    $stmt = $pdo->prepare("INSERT INTO submissions (user_id, content) VALUES (?, ?)");
    if ($stmt->execute([$user_id, $content])) {
        echo "Submission successful!";
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error submitting data.";
    }
}
?>
