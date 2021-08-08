<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $id = intval($_GET['id']);
  $fetchCommentsSql = 
      "SELECT id, content
      FROM yiluan_w11_comments
      WHERE id=?";
      $stmt = $conn->prepare($fetchCommentsSql);
      $stmt->bind_param('i',$id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc()
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>編輯留言</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class='warning'>
    <strong>
    注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。
    </strong>
  </header>
  <main class="board">
    <h1 class="title">編輯留言</h1>
    <form action="handle_edit_comment.php" class="new-comment" method="post">
      <textarea class="new-comment__text" name="comment"rows="6"><?php echo $row['content'] ;?></textarea>
      <input class="hidden" type="number" name="id" value="<?php echo $row['id']; ?>">
      <?php
        if (!empty($_GET['errorNo'])){
          if ($_GET['errorNo'] === '1') {
            echo "<h3 class='errorMessage'>留言未填寫，請再輸入一次。</h3>";
          }
        }
      ?>
      <input class="new-comment__submit-btn btn" type="submit">
        
    </form>
    <div class="hr">
    </div>
    
  </main>

</body>
</html>