<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  $item_per_page=5;
  $page = 1;
  if(isset($_GET['page'])) {
    $page = intval($_GET['page']);
  }
  $offset = ($page - 1) * 5;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>留言板</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class='warning'>
    <strong>
    注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。
    </strong>
  </header>
  <main class="board">
    
    
    
      <div class="new-comment__nickname-area">
        
        
        
        <?php 
          $username = NULL;
          if (isset($_SESSION['username'])) {
            $user = getUserFromUsername($_SESSION['username']);
            $nickname = $user['nickname'];
            echo '<a href="handle_logout.php" class="btn login-logout">登出</a>';
            echo '<span class="btn change_nickname_btn">編輯暱稱</span>';
            if ($user['identity'] === '20') {
              echo '<a href="edit_authority.php" class="btn authority-btn">後台</a>';
            }
          if (!empty($_GET['errorNo'])){
            if ($_GET['errorNo'] === '2') {
              echo "<h3 class='errorMessage'>新暱稱未填寫</h3>";
            }
          }
        ?>
        <div class="change_nickname hidden">
          <form class="change_nickname_form" action="handle_change_nickname.php" method="post">
            <label for="change_nickname_input">新的暱稱：</label>
            <input class="change_nickname_input" type="text" name="nickname" id="change_nickname_input">
            <br>
            <input class="new-comment__submit-btn btn" type="submit">
          </form>
        </div>
        <?php
            echo sprintf("<h3>你好，%s</h3>",$nickname);
        ?>


        <?php } else {?>
          <a href="login.php" class="btn login-btn">登入</a>
          <a href="register.php" class="btn register-btn">註冊</a>
        <?php
            if (!empty($_GET['errorNo'])){
              if ($_GET['errorNo'] === '1') {
                echo "<h3 class='errorMessage'>留言未填寫，請再輸入一次。</h3>";
              } else if ($_GET['errorNo'] === '3') {
                echo "<h3 class='errorMessage'>Something wrong.</h3>";
              }
            }
            if (!empty($_GET['register']) and $_GET['register'] === '1') {
              echo "<h3 class='errorMessage'>註冊成功!</h3>";
            }
          }
        ?>
      </div>
    <h1 class="title">Comments</h1>
    <form action="board_add_comment.php" class="new-comment" method="post">
      <textarea class="new-comment__text" name="comment"rows="6"></textarea>
      <?php if (isset($_SESSION['username'])) { 
            if ($user['identity'] !== '00'){?>
        <input class="new-comment__submit-btn btn" type="submit">
      <?php }else{
              echo "<h3>你已被停權</h3>";
            }
      } else {
          echo "<h3>登入後才能發布評論</h3>";
      }
      ?>
        
    </form>
    <div class="hr">
    </div>
    <?php
      
      $fetchCommentsSql = 
      "SELECT C.content as content, C.created_at as created_at,
      U.nickname as nickname, U.username as username, C.id as id
      FROM yiluan_w11_comments as C
      LEFT JOIN yiluan_w11_users as U 
      ON C.username=U.username
      WHERE is_deleted IS NULL
      ORDER BY id DESC
      LIMIT ? OFFSET ?";
      $stmt = $conn->prepare($fetchCommentsSql);
      $stmt->bind_param('ii', $item_per_page, $offset);
      $stmt->execute();
      $result = $stmt->get_result();
      while ($row = $result->fetch_assoc()) {
    ?>
      <div class="card">
        <div class="card__avatar"></div>
        <div class="card__part">
          <div class="card__user">
            <span class="card__nickname"><?php echo transformXSS($row['nickname']);?></span>
            (@ <span class="card__nickname"><?php echo transformXSS($row['username']);?></span>)
            <span class="card__time"><?php echo transformXSS($row['created_at']);?></span>
            <!-- 如果是使用者本人或 admin，才能編輯或刪除留言 -->
            <?php if(!empty($_SESSION)) {
              if($_SESSION['username'] === $row['username'] || $user['identity'] === '20'){
              ?>
              <a href="edit_comment.php?id=<?php echo $row['id'];?>">編輯</a>
              <a href="handle_delete_comment.php?id=<?php echo $row['id'];?>">刪除</a>
            <?php }}?>
          </div>
          <div class="card__comment"><?php echo transformXSS($row['content']);?></div>
        </div>
      </div>
    <?php }  ?>
    <div class="end">
      <?php
      $fetchCommentsSql = 
      "SELECT C.content as content, C.created_at as created_at,
      U.nickname as nickname, U.username as username, C.id as id
      FROM yiluan_w11_comments as C
      LEFT JOIN yiluan_w11_users as U 
      ON C.username=U.username
      WHERE is_deleted IS NULL";
      $stmt = $conn->prepare($fetchCommentsSql);
      $stmt->execute();
      $result = $stmt->get_result();
      $total = intval(ceil(($result->num_rows)/$item_per_page));
      if ($total===0){
        $total = 1;
      }
      ?>
      <span class="total"><?php echo $page;?> / <?php echo $total;?></span>
      <br>
      <?php if($page !== 1) {?>
        <a class="btn" href="index.php?page=1">首頁</a>
        <a class="btn" href="index.php?page=<?php echo $page - 1;?>">上一頁</a>
      <?php }?>
      <?php if($page !== $total) {?>
        <a class="btn" href="index.php?page=<?php echo $page + 1;?>">下一頁</a>
        <a class="btn" href="index.php?page=<?php echo $total;?>">末頁</a>
      <?php }?>
    </div>
  </main>
  <script>
    document.querySelector('.change_nickname_btn').addEventListener('click',  (e) => {
      document.querySelector('.change_nickname').classList.toggle('hidden');
    })
  </script>
</body>
</html>