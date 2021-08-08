<?php
  require_once('conn.php');
  session_start();
  $id = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
  <link rel="stylesheet" href="style.css">
  <title>發表文章</title>
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
        <?php if(!isset($_SESSION['username'])) { ?>
          <a class="option" href="login.php">登入</a>
        <?php } else { ?>
          <a class="option" href="handle_logout.php">登出</a>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="wallpaper">
    <div class="wallpaper__welcome">
      <h2 class="wallpaper__welcome-title">存放心得之地</h2>
      <h3 class="wallpaper__welcome-subtitle">Welcome to my blog</h3>
    </div>
  </div>
  <div class="posts">
    <?php
      $fetchPostsSql = 
      "SELECT *
      FROM yiluan_w11_blog_posts
      WHERE id=?";
      $stmt = $conn->prepare($fetchPostsSql);
      $stmt->bind_param('s',$id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
    ?>
    <div class="new-post">
      <form action="handle_edit_post.php" method="post">
        <div class="post-create">
          <span>修改文章：</span>
        </div>
        <input class="hidden" type="text" name="id" value="<?php echo $row['id']; ?>">
        <div class="new-post-title">
          <input class="new-post-title-input" type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="請輸入文章標題">
        </div>
        <div class="new-post-content">
          <textarea class="new-post-content-input" name="content" rows="18"><?php echo $row['content']; ?></textarea>
        </div>
        <input class="new-post-submit" type="submit" value="送出文章">
      </form>
    </div>
  </div>
  <div class="footer">
    Copyright © 2021 Yiluan's Blog All Rights Reserved.
  </div>
</body>
</html>