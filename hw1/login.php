<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>留言板-登入</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class='warning'>
    <strong>
    注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。
    </strong>
  </header>
  <main class="board">
    <h1 class="title">
    登入
    </h1>
    <form action="handle_login.php" class="new-comment" method="post">
      <div class="new-comment__nickname-area">
        <div class="btns">
          <a href="index.php" class="btn login-btn">回留言板</a>
          <a href="register.php" class="btn register-btn">註冊</a>
          <?php
            if (!empty($_GET)){
              if ($_GET['errorNo'] === '1') {
                echo "<h3 class='errorMessage'>帳號或密碼未填寫，請再輸入一次。</h3>";
              } else if ($_GET['errorNo'] === '2') {
                echo "<h3 class='errorMessage'>帳號或密碼輸入錯誤，請重新輸入。</h3>";
              }
            }
          ?>
        </div>
        <span>帳號：</span>
        <input class="new-comment__nickname" type="text" name="username">
        <br>
        <span>密碼：</span>
        <input class="new-comment__nickname" type="password" name="password">
      </div>
      <input class="new-comment__submit-btn" type="submit" value="登入">
    </form>
    <div class="hr">
    </div>
  </main>
</body>
</html>