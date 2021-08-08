<?php
  require_once('conn.php');
  
  function getUserFromUsername($username) {
    global $conn;
    $fetchAccountsSql = "SELECT * FROM yiluan_w11_users WHERE username=?";
    $stmt = $conn->prepare($fetchAccountsSql);
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row;
  }

  function transformXSS($str) {
    return htmlspecialchars($str,ENT_QUOTES);
  }

  function identityTransform($identity) {
    if ($identity === '00') {
      return '遭停權使用者';
    } else if ($identity === '10') {
      return '一般使用者';
    } else if ($identity === '20') {
      return '管理員';
    } else {
      return '未定義';
    }
  }
?>