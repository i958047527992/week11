<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $id = intval($_POST['id']);
  $comment = $_POST['comment'];
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username); 
  if (empty($id) || empty($comment)) {
    header('Location: index.php?errorNo=4');
    die('empty');
  }

  // 管理員可以直接編輯留言
  if($user['identity']==='20') {
    $postComment = "UPDATE yiluan_w11_comments SET content=? WHERE id=?";
    $stmt = $conn->prepare($postComment);
    $stmt->bind_param("si", $comment, $id);
  } else {
    $postComment = "UPDATE yiluan_w11_comments SET content=? WHERE username=? AND id=?";
    $stmt = $conn->prepare($postComment);
    $stmt->bind_param("ssi", $comment, $username, $id);
  }
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: index.php');
  } else {
    header('Location: edit_comment.php?errorNo=1');
  }


?>