<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>留言板-註冊</title>
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
    註冊
    </h1>
    <form action="handle_register.php" class="new-comment" method="post">
      <div class="new-comment__nickname-area">
        <div class="btns">
          <a href="index.php" class="btn login-btn">回留言板</a>
          <a href="login.php" class="btn register-btn">登入</a>
          <?php
            if (!empty($_GET)){
              if ($_GET['errorNo'] === '1') {
                echo "<h3 class='errorMessage'>帳號或密碼未填寫，請再輸入一次。</h3>";
              } else if ($_GET['errorNo'] === '3') {
                echo "<h3 class='errorMessage'>帳號重複，請換別的。</h3>";
              }
            }
          ?>
        </div>
        <span>暱稱：</span>
        <input class="new-comment__nickname" type="text" name="nickname">
        <br>
        <span>帳號：</span>
        <input class="new-comment__nickname" type="text" name="username">
        <br>
        <span>密碼：</span>
        <input class="new-comment__nickname" type="password" name="password">
      </div>
      <input class="new-comment__submit-btn" type="submit" value="註冊">
    </form>
    <div class="hr">
    </div>
  </main>
</body>
</html>