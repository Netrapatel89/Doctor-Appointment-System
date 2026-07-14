<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>

<h2>Register</h2>

<form action="register_action.php" method="POST">

    <input 
        type="text" 
        name="name" 
        placeholder="Full Name" 
        required
    >
    <br><br>

    <input 
        type="email" 
        name="email" 
        placeholder="Email Address" 
        required
    >
    <br><br>

    <input 
        type="password" 
        name="password"
        placeholder="Password"
        required
        pattern="(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&]).{6,}"
        title="Password must be at least 6 characters and include one uppercase letter, one number, and one special character"
    >
    <br><br>

    <button type="submit">Register</button>

</form>

<p>
    Already registered?
    <a href="index.php">Login here</a>
</p>

</body>
</html>
