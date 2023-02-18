<?php
    require 'database.php';

    if(isset($_POST['submit'])) {
        if(isset($_POST['user_id']) && isset($_POST['story_id']) && isset($_POST['comment_content'])) {
            $userid = $_POST['user_id'];
            $story_id = $_POST['story_id'];
            $content = $_POST['comment_content'];
            
            date_default_timezone_set('America/Chicago');
            $time = date("Y-m-d H:i:s");

            $stmt = $mysqli->prepare("insert into comments (user_ID, story_ID, content, time) values (?, ?, ?, ?)");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('iiss', $userid, $story_id, $content, $time);
            $stmt->execute();
            $stmt->close();

            header("Location: detailedPage.php?id=".$story_id);
        }
    }
?>