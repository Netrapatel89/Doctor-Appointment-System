<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

<h2>Login</h2>

<form action="login.php" method="POST">

    <input 
        type="email" 
        name="email" 
        placeholder="Email"
        required
    >
    <br><br>

    <input 
        type="password" 
        name="password"
        placeholder="Password"
        required
    >
    <br><br>

    <button type="submit">Login</button>

</form>

<p>
    New user?
    <a href="register.php">Register here</a>
</p>

</body>
</html>
