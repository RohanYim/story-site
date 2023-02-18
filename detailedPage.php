<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" type="text/css" href="style/detailedPage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
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
                                echo '<a href="">'.$_SESSION['username'].'</a>
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
        <body>
            <?php
                require "database.php";
                $id = $_GET['id'];
                $sql = "SELECT u.username, s.title, s.time, s.content, s.link
                FROM stories AS s
                JOIN users AS u ON s.user_ID = u.id
                WHERE s.id = ".$id.";";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->execute();
                    $stmt->bind_result($username, $title, $time, $content, $link);
                    $stmt->fetch();
                    $stmt->close();
                } else {
                    echo "Error: " . $mysqli->error;
                }
            ?>
            <h1><?php echo htmlspecialchars($title); ?></h1>
            <div class="post-info">
                <p>Written by <?php echo htmlspecialchars($username); ?>&nbsp;</p>
                <p>on <?php echo htmlspecialchars($time); ?>&nbsp;CDT</p>
            </div>
            <div class="container">
                <p class="content"><?php echo htmlspecialchars($content); ?></p>
                <div class="linkdiv">
                    From: <a class="link" href="<?php echo htmlspecialchars($link); ?>"><?php echo htmlspecialchars($link); ?></a>
                </div>
            </div>

        
            <h2>Comments</h2>

            <?php
                require 'database.php';
                session_start();
                $id = $_GET['id'];
                $sql = "select c.id, u.id,u.username,c.content,c.time
                from comments as c
                join users as u on c.user_ID = u.id
                where c.story_ID = ".$id.";";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->execute();
                    $stmt->bind_result($commentid, $userid, $username, $content, $time);
                    while ($stmt->fetch()) {
                        echo '<div class="comment">';
                        echo '<p>Comment by ' . htmlspecialchars($username) . ' on ' . htmlspecialchars($time);
                        if($_SESSION['username']==$username) {
                            echo '<form action="deleteComment.php" method="POST">';
                            echo '<input type="hidden" name="comment_id" value="' . $commentid . '">';
                            echo '<i class="fas fa-edit"></i>';
                            echo '</form></p>';
                            echo '<form action="deleteComment.php" method="POST">';
                            echo '<input type="hidden" name="comment_id" value="' . $commentid . '">';
                            echo '<input type="hidden" name="story_id" value="' . $id . '">';
                            echo '<button type="submit" style="border: none; background: none;">';
                            echo '<i class="fas fa-trash-alt"></i>';
                            echo '</button>';
                            echo '</form></p>';
                        }else{
                            echo '</p>';
                        }
                        echo '<p>' . htmlspecialchars($content) . '</p>';
                        echo '</div>';                        
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $mysqli->error;
                }

                if(isset($_SESSION['username'])) {
                    // User is logged in
                    $userid = $_SESSION['userid'];
                    echo '<form action="addComment.php" method="POST">
                            <label for="comment_content">'.$_SESSION['username'].', add a comment:</label><br>
                            <textarea id="comment_content" name="comment_content"></textarea><br>
                            <input type="hidden" name="story_id" value="'.$id.'">
                            <input type="hidden" name="user_id" value="'.$userid.'">
                            <input type="submit" name="submit" value="Submit">
                        </form>';
                } else {
                    // User is not logged in
                    echo '<a href="login.php">Please log in before making comments!</a>';
                } 
            ?>
        </body>

    </html>

</body>
</html>