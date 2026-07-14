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

/* FETCH APPOINTMENTS WITH DOCTOR DATA */
$query = "
SELECT a.*, d.name, d.specialization, d.image, d.experience, d.location, d.fee
FROM appointments a
JOIN doctors d ON a.doctor_id = d.id
WHERE a.user_id = $user_id
ORDER BY 
CASE 
    WHEN a.priority = 'Emergency' THEN 1
    WHEN a.priority = 'Urgent' THEN 2
    ELSE 3
END,
a.date ASC,
a.time ASC
";

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upcoming Appointments | MedSchedule</title>
<link rel="stylesheet" href="css/dashboard.css?v=6">
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
    <a href="upcoming.php" class="active">Upcoming Appointments</a>
</nav>

<!-- PAGE -->
<div class="upcoming-wrapper">

<?php if ($result->num_rows > 0) { ?>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <div class="appointment-card">

            <!-- LEFT IMAGE -->
            <div class="left">
                <img src="<?= $row['image'] ?>" class="doc-img">
            </div>

            <!-- RIGHT INFO -->
            <div class="right">

                <h3><?= $row['name'] ?></h3>
                <p class="spec"><?= $row['specialization'] ?></p>

                <p><?= $row['experience'] ?></p>
                <p><?= $row['location'] ?></p>
                <p class="fee">₹<?= $row['fee'] ?> Consultation fee</p>

                <hr>

                <p><strong>Date:</strong> <?= $row['date'] ?></p>
                <p><strong>Time:</strong> <?= $row['time'] ?></p>
                <p class="priority <?= strtolower($row['priority']) ?>">
                     <?= $row['priority'] ?>
                </p>
                <br>

                <a href="cancel.php?id=<?= $row['id'] ?>" 
                    class="cancel-btn"
                    onclick="return confirmCancel();">
                    Cancel Appointment
                </a>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <p style="text-align:center; margin-top:50px;">
        No upcoming appointments.
    </p>

<?php } ?>

</div>

</body>
</html>
<script>
function confirmCancel() {
    return confirm("Are you sure you want to cancel this appointment?");
}
</script>