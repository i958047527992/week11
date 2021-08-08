<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $username = $_SESSION['username'];
  $comment = $_POST['comment'];

  if (empty($username) || empty($comment)) {
    header('Location: index.php?errorNo=1');
    die('empty');
  }

  $postComment = "INSERT INTO yiluan_w11_comments (username, content) VALUES (?, ?)";
  $stmt = $conn->prepare($postComment);
  $stmt->bind_param('ss', $username, $comment);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: index.php?errorNo=3');
  }


?>