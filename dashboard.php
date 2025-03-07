<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Fetch user submissions
$stmt = $pdo->prepare("SELECT * FROM submissions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$submissions = $stmt->fetchAll();
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
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="logout.php" class="logout-button">Logout</a>
        <a href="submission.html" class="submit-button">Submit Data</a>

        <h3>Your Submissions:</h3>
        <?php if ($submissions): ?>
            <ul>
                <?php foreach ($submissions as $submission): ?>
                    <li><?php echo htmlspecialchars($submission['content']); ?> <small>(<?php echo $submission['created_at']; ?>)</small></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No submissions yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
