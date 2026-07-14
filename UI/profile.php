<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* FETCH USER */
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* UPDATE PROFILE */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $blood = $_POST['blood_group'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $allergies = $_POST['allergies'];
    $conditions = $_POST['conditions'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    /* PHOTO */
    $photoPath = $user['profile_photo'] ?? '';

    if (!empty($_FILES['photo']['name'])) {
        $fileName = time() . "_" . basename($_FILES["photo"]["name"]);
        $target = "uploads/" . $fileName;

        move_uploaded_file($_FILES["photo"]["tmp_name"], $target);
        $photoPath = $target;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo "Invalid phone number";
    exit;
}

    /* UPDATE QUERY */
    $stmt = $conn->prepare("UPDATE users SET 
        phone=?, gender=?, dob=?, blood_group=?, city=?, address=?, 
        allergies=?, conditions=?, height=?, weight=?, profile_photo=? 
        WHERE id=?");

    $stmt->bind_param(
        "ssssssssdssi",
        $phone,
        $gender,
        $dob,
        $blood,
        $city,
        $address,
        $allergies,
        $conditions,
        $height,
        $weight,
        $photoPath,
        $user_id
    );

    $stmt->execute();

    header("Location: profile.php");
    exit;
}

/* IMAGE */
$img = !empty($user['profile_photo']) ? $user['profile_photo'] : "images/user.png";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile | MedSchedule</title>
<link rel="stylesheet" href="css/dashboard.css?v=20">
</head>
<body>
    <header class="top-bar">
    <div class="logo">
        <img src="images/logo.png" alt="MedSchedule Logo">
    </div>

    <div class="user-area">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<!-- NAVBAR -->
<nav class="nav-bar">
    <a href="home.php">Home</a>
    <a href="doctors.php">Doctors</a>
    <a href="upcoming.php">Upcoming Appointments</a>
    <a href="profile.php" class="active">Profile</a>
</nav>

<div class="profile-wrapper">

    <h2>My Profile</h2>

    <!-- PROFILE IMAGE -->
    <img src="<?= $img ?>" class="profile-pic">

    <form method="post" enctype="multipart/form-data" class="profile-form">

        <div class="form-group">
            <label>Upload Photo</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        <!-- BASIC -->
        <div class="section">
            <h3>Basic Information</h3>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" value="<?= $user['name'] ?>" disabled>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?= $user['email'] ?>" disabled>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" 
                    pattern="[0-9]{10}" 
                    maxlength="10" 
                    placeholder="10-digit number"
                    value="<?= $user['phone'] ?>" required>
            </div>
        </div>

        <!-- PERSONAL -->
        <div class="section">
            <h3>Personal Details</h3>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
                    <option value="">Select</option>
                    <option value="Male" <?= $user['gender']=="Male"?"selected":"" ?>>Male</option>
                    <option value="Female" <?= $user['gender']=="Female"?"selected":"" ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?= $user['dob'] ?>">
            </div>

            <div class="form-group">
                <label>Blood Group</label>
                <input type="text" name="blood_group" value="<?= $user['blood_group'] ?>">
            </div>
        </div>

        <!-- ADDRESS -->
        <div class="section">
            <h3>Address</h3>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="<?= $user['city'] ?>">
            </div>

            <div class="form-group">
                <label>Full Address</label>
                <textarea name="address"><?= $user['address'] ?></textarea>
            </div>
        </div>

        <!-- MEDICAL -->
        <div class="section">
            <h3>Medical Info</h3>

            <div class="form-group">
                <label>Allergies</label>
                <textarea name="allergies"><?= $user['allergies'] ?></textarea>
            </div>

            <div class="form-group">
                <label>Existing Conditions</label>
                <textarea name="conditions"><?= $user['conditions'] ?></textarea>
            </div>
        </div>

        <!-- BODY -->
        <div class="section">
            <h3>Body Details</h3>

            <div class="form-group">
                <label>Height (cm)</label>
                <input type="number" step="0.01" name="height" value="<?= $user['height'] ?>">
            </div>

            <div class="form-group">
                <label>Weight (kg)</label>
                <input type="number" step="0.01" name="weight" value="<?= $user['weight'] ?>">
            </div>
        </div>

        <button type="submit" class="save-btn">Save Profile</button>

    </form>

</div>

</body>
</html>