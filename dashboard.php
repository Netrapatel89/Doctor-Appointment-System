<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}
?>

<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<a href="profile.php">Profile</a> |
<a href="logout.php">Logout</a>
