<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];
  $id = $_GET['id'];

  if (empty($username)) {
    header('Location: index.php');
    die('unauthrized');
  }

  $postEdit = "UPDATE yiluan_w11_blog_posts SET is_deleted=1 WHERE id=?";
  $stmt = $conn->prepare($postEdit);
  $stmt->bind_param('s', $id);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: post-edit.php?errorNo=2');
  }


?>