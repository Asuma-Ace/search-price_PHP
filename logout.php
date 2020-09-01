<?php
session_start();
session_regenerate_id(TRUE);

$_SESSION = array();
if (ini_get('session.use_cookies')) {
  $params = session_get_cookie_params();
  setcookie(session_name() . '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}
session_destroy();

require('common.php');
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
  <link rel="stylesheet" href="join/css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="join/css/mdb.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/responsive.css" media="screen and (max-width: 1000px)">
  <title>ログアウト</title>
</head>

<body>
<header>
  <div class="container">
    <div class="header-title">
      <div id="top-btn" class="header-logo"><a href="index.php">最安値検索<span id="shop">（Yahoo!ショッピング＆楽天市場）</span></a></div>
    </div>
    <div id="wrapper">
      <p class="btn-gnavi">
        <span></span>
        <span></span>
        <span></span>
      </p>        
      <div class="header-menu"  id="global-navi">
        <ul class="header-menu-right">
          <li>
          <a href="<?php echo $login_out_url; ?>"><?php echo $login_out; ?></a>
          </li>
          <li>
            <a href="join/index.php">新規会員登録</a>
          </li>
          <li>
            <a href="contact/index.php">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<main>
<div class="user_jc container">ようこそ、<strong><?php echo $login_user; ?></strong>さん</div>
  <div class="content">
    <h1 class="text-center">ログアウト</h1>
    <div class="card mt-3">
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">ログアウト完了</h2>
        <div id="content">
          <p>ログアウトいたしました。<br>ご利用ありがとうございました。</p>
          <p>
            <button class="btn btn-primary mt-2 mb-2" type="button" onclick="location.href='login.php'">
            ログインページへ
            </button>
          </p>
          <p>
            <button class="btn btn-blue-grey mt-2 mb-2" type="button" onclick="location.href='index.php'">
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
  <script src="join/js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script src="join/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="join/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script src="join/js/mdb.min.js"></script>
  <script src="js/script.js"></script>

</body>
</html>