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
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter your username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Endter your password" required><br>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
            <input type="submit" value="Log In">
        </form>
        <br>
        <form action="register.php" method="POST">
            <p>Not yet registered? <input type="submit" value="Register"></p>
        </form>
    </div>

    <div class='info'>
        <?php
            require 'user.php';

            session_start();
            
            $_SESSION['token'] = bin2hex(random_bytes(32));

            if(isset($_POST['login'])){
                if(isset($_POST['username']) || isset($_POST['password'])){
                    echo "<div style='text-align:center;'>Please fill in both fields.</div>";
                }
                else{
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $token = isset($_POST['token']) ? $_POST['token'] : null;
                    // test for validity of the CSRF token on the server side
                    if(!hash_equals($_SESSION['token'], $token)) {
                        $_SESSION['token'] = bin2hex(random_bytes(32));
                        echo "<div style='text-align:center;'>Invalid form submission. Please try again.</div>";
                    }
                    else{
                        $user = User::authenticate($username, $password);
                        if($user) {
                            $_SESSION['userid'] = $user->id;
                            $_SESSION['username'] = $user->username;
                            header("Location: main.php");
                        }
                        else{
                            echo "<div style='text-align:center;'>Incorrect username or password. Please try again.</div>";
                        }
                    }
                }

            }
        ?>
    </div>
</body>
</html>
