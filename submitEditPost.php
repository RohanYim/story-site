<?php
    require 'database.php';
    session_start();
    $user_ID = $_SESSION['userid'];
    $storyid = $_POST['storyid'];

    if($user_ID==$_POST['userid']){
        if(isset($_POST['submit'])) {
            $title = $_POST['title'];
            $url = $_POST['url'];
            $content = $_POST['content'];

            $stmt = $mysqli->prepare("update stories set title=?,content=?,link=? where id=?");
            if (!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->bind_param('sssi', $title, $content,$url, $storyid);
            if(!$stmt->execute()) {
                echo "error";
            }
            $stmt->close();
        
            header("Location: detailedPage.php?id=".$storyid);
            exit;
        }
    }
?>