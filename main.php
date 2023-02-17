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
                    <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/main.php"> -->
                    <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/main.php">
                        <img src="static/logo.png" alt="" class='logo'>
                    </a> 
                </td>
                <td>
                    <span>
                        <!-- <a href="http://18.191.24.174/~RohanSong/module3/group/post.php">Post</a> -->
                        <a href="http://ec2-3-82-231-44.compute-1.amazonaws.com/~Fiona/module3-group-510576-505908/post.php">Post</a>
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
    <table>
        <tbody>
            <?php
                require 'database.php';

                $sql = "SELECT s.id, u.username, s.title, s.time, COUNT(c.id) AS comment_count
                        FROM stories AS s
                        JOIN users AS u ON s.user_ID = u.id
                        LEFT JOIN comments AS c ON s.id = c.story_ID
                        GROUP BY s.id;";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->execute();
                    $stmt->bind_result($id, $username, $title, $time,$counts);
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

                        echo "<tr><td>" . $count . "</td><th>" . $title . "</th></tr>";
                        echo "<tr><th></th><td>by " . $username . "</td><td>" . $output . "</td><td><a href=''>".$counts." comments</a></td></tr>";
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