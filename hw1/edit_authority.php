<?php
  require_once('conn.php');
  require_once('utils.php');
  session_start();
  if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    die('非 admin');
  } else {
    $user = getUserFromUsername($_SESSION['username']);
    if ($user['identity'] !== '20') {
      header('Location: index.php');
      die('非 admin');
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>後台</title>
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
          if (!empty($_GET['errorNo'])){
            if ($_GET['errorNo'] === '1') {
              echo "<h3 class='errorMessage'>未選擇權限。</h3>";
            } else if ($_GET['errorNo'] === '2') {
              echo "<h3 class='errorMessage'>修改失敗。</h3>";
            }
          }
          $username = NULL;
          $user = getUserFromUsername($_SESSION['username']);
          $nickname = $user['nickname'];
          echo '<a href="index.php" class="btn login-logout">返回首頁</a>';
          echo sprintf("<h3>你好，%s</h3>",$nickname);
        ?>



      </div>
    <h1 class="title">後台</h1>
    
    <div class="hr">
    </div>
    <div class="users">
      <?php
        
        $fetchUsersSql = 
        "SELECT id, nickname, username, created_at, identity
        FROM yiluan_w11_users";
        $stmt = $conn->prepare($fetchUsersSql);
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
            <a class="change_authority_btn" href="#">編輯權限</a>
            <div class="change_authority hidden">
              <form class="change_authority_form" action="handle_change_authority.php" method="post">
                <label><input type="radio" name="identity" value="00"/> 停權</label>
                <label><input type="radio" name="identity" value="10"/> 一般</label>
                <label><input type="radio" name="identity" value="20"/> 管理員</label>
                <input class="hidden" type="text" name="id" value="<?php echo $row['id']; ?>">
                <br>
                <input class="new-comment__submit-btn btn" type="submit">
              </form>
            </div>
            <div class="card__comment"><?php echo transformXSS(identityTransform($row['identity']));?></div>
          </div>

        </div>
      </div>
      <?php }  ?>
    </div>
    <div class="end">
      <?php
      $fetchUsersSql = 
      "SELECT nickname, username, identity
      FROM yiluan_w11_users";
      $stmt = $conn->prepare($fetchUsersSql);
      $stmt->execute();
      $result = $stmt->get_result();
      // $total = intval(ceil(($result->num_rows)/$item_per_page));
      ?>
      <!-- <span class="total"><?php echo $page;?> / <?php echo $total;?></span> -->
      <br>
      <!-- <?php if($page !== 1) {?>
        <a class="btn" href="index.php?page=1">首頁</a>
        <a class="btn" href="index.php?page=<?php echo $page - 1;?>">上一頁</a>
      <?php }?>
      <?php if($page !== $total) {?>
        <a class="btn" href="index.php?page=<?php echo $page + 1;?>">下一頁</a>
        <a class="btn" href="index.php?page=<?php echo $total;?>">末頁</a>
      <?php }?> -->
    </div>
  </main>
  <script>
    document.querySelector('.users').addEventListener('click',  (e) => {
      if(e.target.classList.contains('change_authority_btn')) {
        e.target.closest('.card__user').querySelector('.change_authority').classList.toggle('hidden')
        e.target.closest('.card__user').querySelector('.card__comment').classList.toggle('hidden')
      }
    })
  </script>
</body>
</html>