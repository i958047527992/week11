<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $id = intval($_POST['id']);
  $identity = $_POST['identity'];
  $username = $_SESSION['username'];
  $user = getUserFromUsername($username); 
  if (empty($id) || empty($identity)) {
    header('Location: edit_authority.php?errorNo=1');
    die('empty');
  }

  $postComment = "UPDATE yiluan_w11_users SET identity=? WHERE id=?";
  $stmt = $conn->prepare($postComment);
  $stmt->bind_param("si", $identity, $id);
  $result = $stmt->execute();

  if ($result === TRUE) {
    header('Location: edit_authority.php');
  } else {
    header('Location: edit_authority.php?errorNo=2');
  }


?>