<?php
    require 'database.php';

    if(isset($_POST['comment_id'])) {
        $id = $_POST['comment_id'];
        $story_id = $_POST['story_id'];
        

        $stmt = $mysqli->prepare("delete from comments where id = ?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        header("Location: detailedPage.php?id=". $story_id);
    }
?>