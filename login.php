<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
    <h1>Login System</h1><br><br>
    <div class = "login">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <label>Username: </label>
            <input type="text" name="username" id="username" placeholder="Please input your username" required><br><br>
            <label>Password: </label>
            <input type="password" name="password" id="password" placeholder="Please input your password" required><br><br>
            <input type="submit" value="Log In">
        </form>
        <form action="register.php" method="POST">
            Not yet register as a user?&nbsp;&nbsp;<input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
