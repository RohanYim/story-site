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
                    <a href="main.php">
                        <img src="static/logo.png" alt="" class='logo'>
                    </a> 
                </td>
                <td>
                    <span>
                        <a href="main.php">Main Page</a>
                        |
                        <?php
                            session_start();
                            if(isset($_SESSION['username'])) {
                                // User is logged in
                                echo '<a href="profile.php?id='.$_SESSION['userid'].'">'.$_SESSION['username'].'</a>
                                |
                                <a href="logout.php">Logout</a>';
                            } else {
                                // User is not logged in
                                echo '<a href="login.php">Login</a>
                                |
                                <a href="register.php">Register</a>';
                            }                            
                        ?>
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
            $user_ID = $_SESSION['userid'];
            if(isset($_POST['submit'])) {
                if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['url'])) {
                    $title = $_POST['title'];
                    $url = $_POST['url'];
                    $content = $_POST['content'];
                    //date_default_timezone_set('America/Chicago');
                    //$time = date("Y-m-d H:i:s");

                    $stmt = $mysqli->prepare("insert into stories (user_ID, title, content, link) values (?, ?, ?, ?)");
                    if(!$stmt){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('isss', $user_ID, $title, $content, $url);
                    if(!$stmt->execute()) {
                        echo "error";
                    }
                    $stmt->close();

                    header("Location: main.php");
                }
            }
        ?>

    </html>




</body>
</html>