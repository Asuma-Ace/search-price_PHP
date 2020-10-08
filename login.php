<?php
session_start();
require('common.php');
require('dbconnect.php');

$email = isset($_SESSION['email']) ? $_SESSION['email'] : NULL;
$password = isset($_SESSION['password']) ? $_SESSION['password'] : NULL;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : NULL;

if ($email === NULL && $password === NULL) {
  if (!empty($_COOKIE['email']) && !empty($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
  }
}

if (!isset($_SESSION['token'])) {
  $_SESSION['token'] = sha1(uniqid(mt_rand(), TRUE));
}
$token = $_SESSION['token'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="google-signin-client_id" content="511695979023-0kiein8ohpfrmbnq4uufn1cjmqavsuig.apps.googleusercontent.com">
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
  <title>ログイン</title>
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
      <div class="header-menu" id="global-navi">
        <ul class="header-menu-right">
          <li>
            <a href="<?php echo $login_out_url; ?>"><?php echo $login_out; ?></a>
          </li>
          <?php if (!isset($_SESSION['id'])): ?>
          <li>
            <a href="join/index.php">新規会員登録</a>
          </li>
          <?php endif; ?>
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
    <h1 class="text-center">ログイン</h1>
    <div class="card mt-3">

      <!-- mail address -->
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">メールアドレスでログイン</h2>

        <form method="POST" action="login_c.php">
          <div class="md-form">
            <label for="email">メールアドレス</label>
            <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="<?php print h($email); ?>" maxlength="256" required>
          </div>

          <div class="md-form">
            <label for="password">パスワード</label>
            <input class="form-control" type="password" id="password" name="password" oninvalid="InvalidPw(this);" oninput="InvalidPw(this);" value="<?php print h($password); ?>" required>
            <?php if ($error['password'] === 'tooshort_length'): ?>
              <p class="error">* 8文字以上で入力してください</p>
            <?php endif ?>
            <?php if ($error['password'] === 'toolong_length'): ?>
              <p class="error">* 128文字以内で入力してください</p>
            <?php endif ?>
            <?php if ($error['login'] =='false' ): ?>
            <p class="error">* ログインに失敗しました。正しく入力してください</p>
          <?php endif; ?>
          </div>

          <input id="save" type="checkbox" name="save" value="on" <?php  if (!empty($_COOKIE['email']) && !empty($_COOKIE['password'])) {echo 'Checked';} ?>>
          <label for="save" class="save">メールアドレスとパスワードを保存</label>

          <button class="btn btn-block btn-default mt-2 mb-2" type="submit">
            ログイン
          </button>
          <input type="hidden" name="token" value="<?php echo h($token); ?>">
          
          <div class="text-left">
            <a href="join/index.php" class="card-text">アカウントをお持ちでない方はこちら（新規会員登録）</a>
          </div>

        </form>
      </div>
      <!-- mail address -->

      <!-- sns -->
      <div class="card-body text-center snsbox">
        <h3 class="h3 card-title text-center mt-2">SNSアカウントでログイン</h3>

        <!-- <div class="g-signin2" data-onsuccess="signOut"></div> -->

        <form method="POST" action="" class="mt-3 sns sns_top">
          <button class="btn btn-block btn-danger" type="submit">
            <i class="fab fa-google mr-1"></i></i>Googleでログイン
          </button>
        </form>

        <form method="POST" action="" class="mt-3 sns">
          <button class="btn btn-block btn-info" type="submit">
            <i class="fab fa-twitter mr-1"></i></i>Twitterでログイン
          </button>
        </form>

        <form method="POST" action="" class="mt-3 sns">
          <button class="btn btn-block btn-primary" type="submit">
            <i class="fab fa-facebook-f mr-1"></i>Facebookでログイン
          </button>
        </form>

      </div>
      <!-- sns -->

    </div>
  </div>
</main>

<footer>
  <div class="copyright">&copy; 2020<?php if( date('Y') > "2020") {echo "-".date('Y');}?> Samua</div>
</fotter>

  <!-- Google API -->
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="gapi.js"></script>
  <!-- jQuery -->
  <script src="join/js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script src="join/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="join/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script src="join/js/mdb.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="js/invalidmsg.js"></script>
  <script src="js/script.js"></script>

</body>
</html>
