<?php
session_start();
require_once "../db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email === "" || $password === "") {
        $error = "All fields are required.";
    } else {
        // IMPORTANT: fetch name also
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                // 🔥 FIX: set the SAME session key home.php expects
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["user_name"] = $user["name"];

                header("Location: home.php");
                exit;

            } else {
                $error = "Invalid credentials.";
            }
        } else {
            $error = "Invalid credentials.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login | MedSchedule</title>
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

            <h2>User Login</h2>

            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="post">
                <div class="input-group">
                    <span class="icon">👤</span>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <p class="register-text">
                Don’t have any account?
                <a href="register.php">Create an Account</a>
            </p>
        </div>

    </div>
</section>

</body>
</html>
