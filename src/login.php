<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login-process.php">
        <label for="username">Username:</label>
        <input type="text" name="login" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="heslo" required><br><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>