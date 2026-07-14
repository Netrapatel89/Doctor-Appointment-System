<?php
session_start();
require_once "../db.php";

/* AUTH CHECK FIRST */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* FETCH USER (for image + name) */
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

$username = $userData['name'];
$img = !empty($userData['profile_photo']) ? $userData['profile_photo'] : "images/user.png";

/* FETCH DOCTORS */
$result = $conn->query("SELECT * FROM doctors");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Doctors | MedSchedule</title>
<link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<!-- TOP BAR -->
<header class="top-bar">
    <div class="logo">
        <img src="images/logo.png" alt="MedSchedule">
    </div>

    <div class="user-area">
        <a href="profile.php">
            <img src="<?= $img ?>"
            style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
        </a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- NAVBAR -->
<nav class="nav-bar">
    <a href="home.php">Home</a>
    <a href="doctors.php" class="active">Doctors</a>
    <a href="upcoming.php">Upcoming Appointments</a>
</nav>

<!-- PAGE CONTENT -->
<section class="doctor-list">

    <h2 class="page-heading">Select Doctor for Your Appointment</h2>

    <!-- Doctor Card -->
    <div class="doctor-list">

<?php while ($row = $result->fetch_assoc()) { ?>

    <div class="doctor-card">

        <img src="<?= $row['image'] ?>" class="doctor-img" alt="Doctor">

        <div class="doctor-info">
            <h3><?= $row['name'] ?></h3>
            <p class="spec"><?= $row['specialization'] ?></p>
            <p><?= $row['experience'] ?></p>
            <p><?= $row['location'] ?></p>
            <p class="fee">₹<?= $row['fee'] ?> Consultation fee at clinic</p>
        </div>

        <div class="doctor-action">
            <a href="appointments.php?doctor_id=<?= $row['id'] ?>">
                <button class="book-btn">Book Clinic Visit</button>
            </a>
        </div>

    </div>

<?php } ?>

</div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>© 2025 MedSchedule. All rights reserved.</p>
</footer>

</body>
</html>
