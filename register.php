<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
    <h1>Register System</h1><br><br>
    <div class = "login">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="hidden" name="register" value="1">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Endter your password" required><br><br>
            <input type="submit" value="Register">
        </form>
    </div>
    <br><br><br><br>
    <form class = "back" action="login.php">
        <input type="submit" value="Back to Log In Page!">
    </form>
    <?php
        require 'user.php';

        if(isset($_POST['register']) && $_POST['register'] == 1){
            $res = user::register($_POST['username'], $_POST['password']);
            if ($res == 1) {
                echo "<p>Username has already taken, please choose a new one!</p>";
            }
            else if($res == 2){
                echo "<p>Invalid username!</p>";
            }
            else{
                echo "<p>You have successfully registered! Redirect to login page in 3 seconds.</p>";
                header("refresh:3; url=login.php");
            }
        }
    ?>
</body>
</html>