<?php
require_once "../db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Password rule:
    // min 6 chars, 1 uppercase, 1 number, 1 special char
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
        $error = "Password must be at least 6 characters with 1 uppercase, 1 number, and 1 special character.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hash);

        if ($stmt->execute()) {
            $success = "Registration successful. You can login now.";
        } else {
            $error = "Email already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | MedSchedule</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<section class="login-wrapper">
    <div class="login-box">

        <!-- LEFT IMAGE -->
        <div class="login-left">
            <img src="images/vector.png" alt="Illustration">
        </div>

        <!-- RIGHT FORM -->
        <div class="login-right">
            <img src="images/logo.png" class="login-logo" alt="MedSchedule">

            <h2>Create Account</h2>

            <?php if ($error): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="success"><?= $success ?></p>
            <?php endif; ?>

            <form method="post">
                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="text" name="name" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <span class="icon">📧</span>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="login-btn">Register</button>
            </form>

            <p class="register-text">
                Already have an account?
                <a href="login.php">Login</a>
            </p>
        </div>

    </div>
</section>

</body>
</html>
