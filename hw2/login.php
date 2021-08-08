<?php
  require_once('conn.php');
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
  <link rel="stylesheet" href="style.css">
  <title>登入</title>
</head>
<body>
  <div class="navbar">
    <div class="navbar__left">
      <a href="index.php" class="index"><h2 class="navbar__logo">Yiluan's Blog</h2></a>
      <ul class="navbar__left-list">
        <a class="option" href="#">文章列表</a>
        <a class="option" href="#">分類專區</a>
        <a class="option" href="#">關於我</a>
      </ul>
    </div>
    <div class="navbar__right">
      <ul class="navbar__right-list">
        <a class="option" href="admin.php">管理後台</a>
        <a class="option" href="login.php">登入</a>
      </ul>
    </div>
  </div>
  <div class="wallpaper">
    <div class="wallpaper__welcome">
      <h2 class="wallpaper__welcome-title">存放心得之地</h2>
      <h3 class="wallpaper__welcome-subtitle">Welcome to my blog</h3>
    </div>
  </div>
  <div class="login">
    <form action="handle_login.php" method="post">
      <h2 class="title">Login</h2>
      <?php
            if (!empty($_GET)){
              if ($_GET['errorNo'] === '1') {
                echo "<h3 class='errorMessage'>帳號或密碼未填寫，請再輸入一次。</h3>";
              } else if ($_GET['errorNo'] === '2') {
                echo "<h3 class='errorMessage'>帳號或密碼輸入錯誤，請重新輸入。</h3>";
              }
            }
      ?>
      <div class="username">
        <div class="input_label">
          <label for="username">USERNAME</label>
        </div>
        <input type="text" name="username" id="username">
      </div>
      <div class="password">
        <div class="input_label">
          <label for="password">PASSWORD</label>
        </div>
        <input type="password" name="password" id="password">
      </div>
      <input class="login-submit" type="submit" value="登入">
    </form>
  </div>
</body>
</html>