<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

/* OPTIONAL backend safety check (recommended) */
if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&]).{6,}$/', $password)) {
    die("Password does not meet requirements");
}

/* Hash password before storing */
$hashed = password_hash($password, PASSWORD_DEFAULT);

/* Insert into database */
mysqli_query(
    $conn,
    "INSERT INTO users (name, email, password)
     VALUES ('$name', '$email', '$hashed')"
);

/* Redirect to login page */
header("Location: index.php");
?>
