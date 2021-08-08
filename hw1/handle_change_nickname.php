<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $nickname = $_POST['nickname'];
  $username = $_SESSION['username'];
  if (empty($username) || empty($nickname)) {
    header('Location: index.php?errorNo=2');
    die('empty');
  }

  $postComment = "UPDATE yiluan_w11_users SET nickname=? WHERE username=?";
  $stmt = $conn->prepare($postComment);
  $stmt->bind_param('ss', $nickname, $username);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: index.php?errorNo=3');
  }


?>