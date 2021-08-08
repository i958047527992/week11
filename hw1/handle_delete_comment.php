<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $id = intval($_GET['id']);
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username); 
  if (empty($id) || empty($username)) {
    header('Location: index.php?errorNo=4');
    die('empty');
  }

  // 管理員可以直接刪除留言
  if($user['identity']==='20') {
    $postComment = "UPDATE yiluan_w11_comments SET is_deleted=1 WHERE id=?";
    $stmt = $conn->prepare($postComment);
    $stmt->bind_param("i", $id);
  } else {
    $postComment = "UPDATE yiluan_w11_comments SET is_deleted=1 WHERE username=? AND id=?";
    $stmt = $conn->prepare($postComment);
    $stmt->bind_param("si", $username, $id);
  }
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: index.php?errorNo=5');
  }


?>