<?php
// logout.php - User Logout
session_start();
session_destroy();
setcookie("user", "", time() - 3600, "/"); // Expire the cookie

header("Location: login.html");
exit();
?>
