<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
?>

<h2>User Profile</h2>
<p>This is a profile page.</p>

<a href="dashboard.php">Back to Dashboard</a>
