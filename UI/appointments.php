<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, profile_photo FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$userData = $stmt->get_result()->fetch_assoc();

$username = $userData['name'];
$img = !empty($userData['profile_photo']) ? $userData['profile_photo'] : "images/user.png";

/* GET DOCTOR FROM DB */
$doctor_id = $_GET['doctor_id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();

if (!$doctor) {
    echo "Doctor not found";
    exit;
}

/* HANDLE FORM */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    $priority = $_POST['priority'];

    /* NEW TIME INPUT */
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];

    /* VALIDATION */
    if (empty($hour) || empty($minute)) {
        echo "<script>alert('Please select time properly');</script>";
        exit;
    }

    if (!in_array($minute, ['00','15','30','45'])) {
        echo "<script>alert('Invalid time slot');</script>";
        exit;
    }

    /* COMBINE TIME */
    $time = sprintf("%02d:%s", $hour, $minute);

    /* OPTIONAL: PREVENT DOUBLE BOOKING */
    $check = $conn->prepare("SELECT id FROM appointments 
                             WHERE doctor_id = ? AND date = ? AND time = ?");
    $check->bind_param("iss", $doctor_id, $date, $time);
    $check->execute();
    $res = $check->get_result();

    /* INSERT */
    $stmt = $conn->prepare("INSERT INTO appointments  (user_id, doctor_id, date, time, priority) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $user_id, $doctor_id, $date, $time, $priority);
    $stmt->execute();

    header("Location: upcoming.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Appointment | MedSchedule</title>
<link rel="stylesheet" href="css/dashboard.css?v=5">
</head>
<body>
    <!DOCTYPE html>
<html>
<head>
<title>Upcoming Appointments</title>
<link rel="stylesheet" href="css/dashboard.css?v=2">
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
    <a href="doctors.php">Doctors</a>
    <a href="upcoming.php">Upcoming Appointments</a>
</nav>

<!-- WRAPPER -->
<div class="appointment-wrapper">

    <!-- BACKGROUND -->
    <div class="appointment-bg"></div>

    <!-- CARD -->
    <div class="appointment-card">

        <!-- LEFT -->
        <div class="left-section">
            <img src="<?= $doctor['image'] ?>" class="doc-img">
        </div>

        <!-- RIGHT -->
        <div class="right-section">

            <!-- DOCTOR INFO -->
            <div class="doc-info">
                <h2><?= $doctor['name'] ?></h2>
                <p class="specialization"><?= $doctor['specialization'] ?></p>
                <p><?= $doctor['experience'] ?></p>
                <p><?= $doctor['location'] ?></p>
                <p class="fee">₹<?= $doctor['fee'] ?> Consultation fee</p>
            </div>

            <!-- FORM -->
            <form method="post" class="appointment-form">

                <input type="hidden" name="doctor_id" value="<?= $doctor['id'] ?>">

                <div class="form-group">
                    <label>Date: </label>
                    <input type="date" name="date" min="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="form-group">
                   <div class="time-row">

    <!-- HOUR -->
    <select name="hour" required>
        <option value="">Hour</option>
        <?php
        for ($h = 9; $h <= 17; $h++) {
            echo "<option value='$h'>" . sprintf("%02d", $h) . "</option>";
        }
        ?>
    </select>
    <span class="colon">:</span>

    <!-- MINUTES -->
    <select name="minute" required>
        <option value="">Min</option>
        <option value="00">00</option>
        <option value="15">15</option>
        <option value="30">30</option>
        <option value="45">45</option>
    </select>

</div>
                </div>

                <div class="form-group">
                    <label>Priority: </label>
                    <select name="priority" required>
                        <option value="">Select Priority</option>
                        <option value="Normal">Normal</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit">Confirm</button>
                    <a href="doctors.php" class="cancel-btn">Cancel</a>
                </div>

            </form>

        </div>

    </div>
</div>

</body>
</html>