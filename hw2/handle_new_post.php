<?php
  require_once('conn.php');
  session_start();
  $username = $_SESSION['username'];
  $title = $_POST['title'];
  $content = $_POST['content'];

  if (empty($username)) {
    header('Location: index.php');
    die('unauthrized');
  }
  if (empty($title) || empty($content)) {
    header('Location: new_post.php?errorNo=1');
    die('empty');
  }

  $postContent = "INSERT INTO yiluan_w11_blog_posts (title, content) VALUES (?, ?)";
  $stmt = $conn->prepare($postContent);
  $stmt->bind_param('ss', $title, $content);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: admin.php');
  } else {
    header('Location: new_post.php?errorNo=2');
  }


?>