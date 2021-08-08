<?php
  require_once('conn.php');
  session_start();
  $username = $_POST['username'];
  $password = hash('sha256', $_POST['password']);
  if (empty($username) || empty($password)) {
    header('Location: login.php?errorNo=1');
    die("帳密未填寫");
  }
  $fetchAccountSql = "SELECT * FROM yiluan_w11_blog_users WHERE username=? and password=?";
  $stmt = $conn->prepare($fetchAccountSql);
  $stmt->bind_param('ss', $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows < 1) {
    header('Location: login.php?errorNo=2');
  } else {
    $_SESSION['username'] = $username;
    header('Location: admin.php');
  }

?>