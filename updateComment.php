<?php
    require 'database.php';

    $stmt = $mysqli->prepare("update comments set content=? where id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $content, $id);
    $stmt->execute();
    $stmt->close();
?>