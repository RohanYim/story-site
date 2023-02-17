<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post News</title>
    <link rel="stylesheet" type="text/css" href="style/post.css">
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td>
                    <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/main.php"> -->
                    <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/main.php">
                        <img src="static/logo.png" alt="" class='logo'>
                    </a> 
                </td>
                <td>
                    <span>
                        <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/main.php">Main Page</a> -->
                        <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/main.php">Main Page</a>
                        |
                        <!-- <?php
                            session_start();
                            if($_SESSION['token']){
                                echo $_SESSION['token'];
                            }
                        ?> -->
                        <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/login.php">Login</a> -->
                        <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/login.php">Login</a>
                        |
                        <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/register.php">Register</a>  -->
                        <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/register.php">Register</a> 
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <html>
        <head>
            <title>Upload Your Story</title>
        </head>
        <body>
            <h1>Upload Your Story</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required><br><br>
                <label for="title">URL:</label>
                <input type="text" name="url" id="url" required><br><br>
                <label for="content">Content:</label>
                <textarea name="content" id="content" rows="10" cols="50" required></textarea><br><br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </body>

        <?php
            require 'database.php';
            if(isset($_POST['submit'])) {
                if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['url'])) {
                    $title = $_POST['title'];
                    $url = $_POST['url'];
                    $content = $_POST['content'];
                    date_default_timezone_set('America/Chicago');
                    $time = date("Y-m-d H:i:s");

                    # subject to change
                    $user_ID = 1;

                    $stmt = $mysqli->prepare("insert into stories (user_ID, title, content, link, time) values (?, ?, ?, ?, ?)");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('issss', $user_ID, $title, $content, $url, $time);
                    $stmt->execute();
                    $stmt->close();

                    header("Location: main.php");
                }
            }
        ?>

    </html>




</body>
</html>