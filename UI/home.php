<?php
session_start();
require_once "../db.php";

/* AUTH CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

/* FETCH USER DATA (name + photo) */
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

$username = $userData['name'];
$img = !empty($userData['profile_photo']) ? $userData['profile_photo'] : "images/user.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | MedSchedule</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="header-wrapper">
<!-- ================= TOP BAR ================= -->
<header class="top-bar">
    <div class="logo">
        <img src="images/logo.png" alt="MedSchedule Logo">
    </div>

    <div class="user-area">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- ================= NAV BAR ================= -->
<nav class="nav-bar">
    <a href="home.php" class="active">Home</a>
    <a href="doctors.php">Doctors</a>
    <a href="upcoming.php">Upcoming Appointments</a>
</nav>
</div>

<!-- ================= WELCOME ================= -->
<section class="welcome">
    <div class="welcome-box">
        <a href="profile.php" title="Profile">
            <img src="<?= $img ?>" 
     style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
        </a>
        <h3>WELCOME <?= htmlspecialchars($username) ?>.</h3>
    </div>
</section>

<!-- ================= ABOUT ================= -->
<section class="about">
    <h2>WHAT IS MEDSCHEDULE ?</h2>
    <br>
    <br>
    <p>
        MedSchedule is a smart, streamlined way to book doctor appointments online.
        Patients can view available doctors, choose a suitable time, and confirm their visit
        within seconds — no calls, no waiting lines.
        <br><br>
        It delivers a clean, reliable, and hassle-free scheduling experience for both patients
        and healthcare providers.
    </p>
</section>

<!-- ================= STEPS ================= -->
<section class="steps">
    <h2>3 Step Easy Appointment Booking Process</h2>

    <div class="step-cards">
        <div class="step">
            🔍
            <p>Find yourself a doctor</p>
        </div>

        <div class="arrow">→</div>

        <div class="step">
            📅
            <p>Select Date for Appointment</p>
        </div>
        <div class="arrow">→</div>

        <div class="step">
            👍
            <p>All Done!</p>
        </div>
    </div>
</section>
<!-------trust-------->
<section class="trust">
    <h2>Why Choose MedSchedule?</h2>
    <div class="trust-cards">
        <div class="trust-card">✔ Verified Doctors</div>
        <div class="trust-card">✔ Secure Appointments</div>
        <div class="trust-card">✔ Easy & Fast Booking</div>
        <div class="trust-card">✔ Patient Friendly Interface</div>
    </div>
</section>
<!-------footer-------->
<footer class="footer">
    <div class="footer-content">

        <div class="footer-brand">
            <p>Smart & hassle-free doctor appointment scheduling.</p>
        </div>

        <div class="footer-links">
            <a href="home.php">Home</a>
            <a href="doctors.php">Doctors</a>
            <a href="appointments.php">Appointments</a>
        </div>

    </div>

    <div class="footer-bottom">
        © 2025 MedSchedule. All rights reserved.
    </div>
</footer>

</body>
</html>
