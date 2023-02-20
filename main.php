<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WashU News</title>
    <link rel="stylesheet" type="text/css" href="style/main.css">
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
                        <a href="post.php">Post</a>
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
    <table>
        <tbody>
            <?php
                require 'database.php';

                $sql = "SELECT u.id, s.id, u.username, s.title, s.time, s.clicks, COUNT(c.id) AS comment_count 
                        FROM stories AS s
                        JOIN users AS u ON s.user_ID = u.id
                        LEFT JOIN comments AS c ON s.id = c.story_ID
                        GROUP BY s.id
                        ORDER BY s.clicks DESC;";
                        
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->execute();
                    $stmt->bind_result($userid, $id, $username, $title, $time, $clicks, $counts);
                    $count = 0;
                    while ($stmt->fetch()) {
                        $count += 1;
                        date_default_timezone_set('America/Chicago');
                        $currenttime = time();
                        $timestamp = strtotime($time);
                        $diff = $currenttime - $timestamp;
                        $days = floor($diff / (60 * 60 * 24));
                        $hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
                        $minutes = floor(($diff % (60 * 60)) / 60);
                        $seconds = $diff % 60;
                        $output = $days . " days " . $hours . " hours " . $minutes . " minutes " . $seconds . " seconds ago";

                        echo "<tr><td>" . $count . "</td><th><a href='detailedPage?id=".$id."'>".$title."</a></th>";
                        if($_SESSION['userid']==$userid) {
                            echo "<td><a href='editPost.php?storyid=".$id."&userid=".$userid."'>edit</a></td><td><a href='deletePost.php?storyid=".$id."&userid=".$userid."'>delete</a></td>";
                        }
                        echo "</tr>";
                        echo "<tr><th></th><td>by " . $username . "</td><td>" . $output . "</td><td><a href=''>".$counts." comments</a></td><td>" .$clicks." clicks</td></tr>";
                    }
                    $stmt->close();
                } else {
                    echo "Error: " . $mysqli->error;
                }
            ?>
        </tbody>
    </table>



</body>
</html>