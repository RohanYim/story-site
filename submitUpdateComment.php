<?php
    require 'database.php';
    if(isset($_POST['submit'])) {
        session_start();
        if(isset($_POST['comment_id']) && isset($_POST['story_id'])){
            $id = $_POST['comment_id'];
            $story_id = $_POST['story_id'];

            if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit;
            }else{
                $user_id = $_POST['user_id'];
                if($_SESSION['userid']==$user_id){
                    $content = $_POST['comment_content'];
                    $stmt = $mysqli->prepare("update comments set content=? where id=?");
                    if (!$stmt) {
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    $stmt->bind_param('si', $content, $id);
                    $stmt->execute();
                    $stmt->close();
                
                    header("Location: detailedPage.php?id=".$story_id);
                    exit;
                }
            }
        }

    }
?>
