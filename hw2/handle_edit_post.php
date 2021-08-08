<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $id = $_POST['id'];

  if (empty($username)) {
    header('Location: index.php');
    die('unauthrized');
  }
  if (empty($title) || empty($content)) {
    header('Location: post-edit.php?errorNo=1');
    die('empty');
  }
  $postEdit = "UPDATE yiluan_w11_blog_posts SET title=? ,content=? WHERE id=?";
  $stmt = $conn->prepare($postEdit);
  $stmt->bind_param('sss', $title, $content, $id);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: post-edit.php?errorNo=2');
  }


?>