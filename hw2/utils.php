<?php
  require_once('conn.php');
  function transformXSS($str) {
    return htmlspecialchars($str,ENT_QUOTES);
  }

?>