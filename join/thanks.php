<?php
session_start();
session_regenerate_id(TRUE);
require('common.php');
require('../dbconnect.php');

if (isset($_POST['token'], $_SESSION['token'])) {
  $token = $_POST['token'];
  if ($token !== $_SESSION['token']) {
    die('CSRFトークンが無効です。フォームを再送信してください');  
  }
} else {
  header('location: index.php');
  exit();
}

if (!empty($_SESSION['join'])) {
	$statement = $db->prepare('INSERT INTO heroku_30ebda75726157d.users SET name=?, email=?, password=?, created=NOW()');
	$statement->execute([
		$_SESSION['join']['name'],
		$_SESSION['join']['email'],
		sha1($_SESSION['join']['password']),
  ]);
	unset($_SESSION['join'], $_SESSION['token']);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="css/mdb.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="css/join.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <title>新規会員登録完了画面</title>
</head>

<body>
<header>
  <div class="container">
    <div class="header-title">
      <div id="top-btn" class="header-logo"><a href="../index.php">最安値検索<span id="shop">（Yahoo!ショッピング＆楽天市場）</span></a></div>
    </div>
    <div id="wrapper">
      <p class="btn-gnavi">
        <span></span>
        <span></span>
        <span></span>
      </p>        
      <div class="header-menu" id="global-navi">
        <ul class="header-menu-right">
          <li>
            <a href="<?php echo $login_out_url; ?>"><?php echo $login_out; ?></a>
          </li>
          <?php if (!isset($_SESSION['id'])): ?>
          <li>
            <a href="index.php">新規会員登録</a>
          </li>
          <?php endif; ?>
          <li>
            <a href="../contact/index.php">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<main>
<div class="user_jc container">ようこそ、<strong><?php echo $login_user; ?></strong>さん</div>
  <div class="content">
    <h1 class="text-center">新規会員登録</h1>
    <div class="card mt-3">
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">新規会員登録完了</h2>
        <div id="content">
          <p>会員登録が完了しました</p>
          <p>
            <button class="btn btn-primary mt-2 mb-2" type="button" onclick="location.href='../login.php'">
              ログインする
            </button>
          </p>
          <p>
            <button class="btn btn-blue-grey mt-2 mb-2" type="button" onclick="location.href='../index.php'">
              トップへ戻る
            </button>
          </p>
        </div>
      </div>
    </div>
  </div>
</main>

<footer>
  <div class="copyright">&copy; 2020<?php if( date('Y') > "2020") {echo "-".date('Y');}?> Samua</div>
</fotter>

  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script src="js/mdb.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="../js/script.js"></script>

</body>
</html>