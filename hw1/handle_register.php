<?php
  require_once('conn.php');
  session_start();
  // 如果暱稱、帳密任一個沒填，用 get 傳錯誤訊息回 register.php 
  if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: register.php?errorNo=1');
    die('資料不全');
  }
  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);

  $registerSql = "INSERT INTO yiluan_w11_users (nickname, username, password) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($registerSql);
  $stmt->bind_param('sss', $nickname, $username, $password);
  $result = $stmt->execute();

  if ($result === TRUE) {
    $_SESSION['username'] = $username;
    header('Location: index.php?register=1');
  } else {
    // 如果帳密有重複或註冊失敗，用 get 傳錯誤訊息回 register.php 
    header('Location: register.php?errorNo=3');
  }


?>