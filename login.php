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
        <!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"> -->
        <form action="login.php" method="POST">
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

    <?php
        session_start();

        require 'database.php';
        
        $_SESSION['token'] = bin2hex(random_bytes(32));

        if(!isset($_POST['username']) || !isset($_POST['password'])){
            echo "<p>Please fill in both fields.</p>";
        }
        else{
            $username = $_POST['username'];
            $password = $_POST['password'];
            printf("username: %s", $username);
            printf("password: %s", $password);
            $token = isset($_POST['token']) ? $_POST['token'] : null;
            // test for validity of the CSRF token on the server side
            if(!hash_equals($_SESSION['token'], $token)) {
                echo "<p>Invalid form submission.</p>";
            }
            else{
                $stmt = $mysqli->prepare("select id, username, password from users where username=?");
                if(!$stmt){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                // $stmt->bind_param('s', $username);
                $stmt->execute();
                $stmt->bind_result($id, $username, $password);
                $stmt->fetch();
                $stmt->close();
                if(!password_verify($password, $hash)){
                    echo "<p>Incorrect username or password.</p>";
                    exit;
                }
                else{
                    header("Location: main.php");
                    exit;
                }
            // }
        }
    ?>

</body>
</html>
