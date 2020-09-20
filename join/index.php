<?php
session_start();
require('common.php');
require('../dbconnect.php');

$name = isset($_SESSION['join']['name']) ? $_SESSION['join']['name'] : NULL;
$email = isset($_SESSION['join']['email']) ? $_SESSION['join']['email'] : NULL;
$password = isset($_SESSION['join']['password']) ? $_SESSION['join']['password'] : NULL;
$password_c = isset($_SESSION['join']['password_c']) ? $_SESSION['join']['password_c'] : NULL;
$error = isset($_SESSION['join']['error']) ? $_SESSION['join']['error'] : NULL;

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
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="css/mdb.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="css/join.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <title>新規会員登録</title>
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

      <!-- mail address -->
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">メールアドレスで登録</h2>

        <form method="POST" action="check.php">
          <div class="md-form">

            <label for="name">ユーザー名</label>
            <input class="form-control" type="text" id="name" name="name" oninvalid="InvalidName(this);" oninput="InvalidName(this);" value="<?php print h($name); ?>" required>
            <?php if ($error['name'] === 'space'): ?>
					    <p class="error">* 半角/全角スペースは使用しないでください</p>
            <?php endif ?>
            <?php if ($error['name'] === 'length'): ?>
              <p class="error">* 50文字以内で入力してください</p>
            <?php endif ?>
          </div>

          <div class="md-form">
            <label for="email">メールアドレス</label>
            <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="<?php print h($email); ?>" maxlength="256" required>
            <?php if ($error['email'] === 'duplicate'): ?>
					    <p class="error">* このメールアドレスは既に使用されています</p>
            <?php endif ?>
          </div>

          <div class="md-form">
            <label for="password">パスワード [8文字以上]</label>
            <input class="form-control" type="password" id="password" name="password" oninvalid="InvalidPw(this);" oninput="InvalidPw(this);" value="<?php print h($password); ?>" required>
            <?php if ($error['password'] === 'tooshort_length'): ?>
              <p class="error">* 8文字以上で入力してください</p>
            <?php endif ?>
            <?php if ($error['password'] === 'toolong_length'): ?>
              <p class="error">* 128文字以内で入力してください</p>
            <?php endif ?>
          </div>

          <div class="md-form">
            <label for="password_c">パスワード（確認用）</label>
            <input class="form-control" type="password" id="password_c" name="password_c" oninvalid="InvalidPwc(this);" oninput="InvalidPwc(this);" value="<?php print h($password_c); ?>" required>
            <?php if ($error['password_c'] === 'match'): ?>
              <p class="error">* 同じパスワードを入力してください</p>
            <?php endif ?>
          </div>

          <button class="btn btn-block btn-default mt-2 mb-2" type="submit">
            確認画面へ
          </button>
          <input type="hidden" name="token" value="<?php echo h($token); ?>">

          <div class="text-left">
            <a href="../login.php" class="card-text">アカウントを既にお持ちの方はこちら（ログイン）</a>
          </div>

        </form>
      </div>
      <!-- mail address -->

      <!-- sns -->
      <div class="card-body text-center snsbox">
        <h3 class="h3 card-title text-center mt-2">SNSアカウントで登録</h3>

        <form method="POST" action="" class="mt-3 sns sns_top">
          <button class="btn btn-block btn-danger" type="submit">
            <i class="fab fa-google mr-1"></i></i>Googleで登録
          </button>
        </form>

        <form method="POST" action="" class="mt-3 sns">
          <button class="btn btn-block btn-info" type="submit">
            <i class="fab fa-twitter mr-1"></i></i>Twitterで登録
          </button>
        </form>

        <form method="POST" action="" class="mt-3 sns">
          <button class="btn btn-block btn-primary" type="submit">
            <i class="fab fa-facebook-f mr-1"></i>Facebookで登録
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
  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script src="js/mdb.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="../js/invalidmsg.js"></script>
  <script src="../js/script.js"></script>

</body>
</html>