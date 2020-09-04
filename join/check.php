<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

session_start();
require('common.php');
require('../dbconnect.php');

if (isset($_POST['token'], $_SESSION['token'])) {
  $token = $_POST['token'];
  if ($token !== $_SESSION['token']) {
    die('CSRFトークンが無効です。フォームを再送信してください');
  }
} else {
  die('直接このページにはアクセスできません');
}

$name = isset($_POST['name']) ? $_POST['name'] : NULL;
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$password = isset($_POST['password']) ? $_POST['password'] : NULL;
$password_c = isset($_POST['password_c']) ? $_POST['password_c'] : NULL;

$error = array();
if (preg_match("/( |　)/",$name)) {
  $error['name'] = 'space';
} elseif (mb_strlen($name) > 50) {
    $error['name'] = 'length';
}
if (mb_strlen($password) < 8) {
  $error['password'] = 'tooshort_length';
} elseif (mb_strlen($password) > 128) {
    $error['password'] = 'toolong_length';
}
if ($password_c !== $password) {
  $error['password_c'] = 'match';
}

if (empty($error)) {
  $user = $db->prepare('SELECT COUNT(*) AS cnt FROM heroku_30ebda75726157d.users WHERE email=?');
  $user->execute([$email]);
  $record = $user->fetch();
  if ($record['cnt'] > 0) {
    $error['email'] = 'duplicate';
  }
}

$_SESSION['join']['name'] = $name;
$_SESSION['join']['email'] = $email;
$_SESSION['join']['password'] = $password;
$_SESSION['join']['password_c'] = $password_c;
$_SESSION['join']['error'] = $error;

if (count($error) > 0) {
  header('location: index.php');
  exit();
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
  <title>新規会員登録確認画面</title>
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
        <h2 class="h3 card-title text-center mt-2">入力内容の確認</h2>

          <dl>
            <div class="md-form check">
              <dt class="h5">ユーザー名</dt>
              <dd><?php print h($name); ?></dd>
            </div>
            <div class="md-form check">
              <dt class="h5">メールアドレス</dt>
              <dd><?php print h($email); ?></dd>
            </div>
            <div class="md-form check">
              <dt class="h5">パスワード</dt>
              <dd>【表示されません】</dd>
            </div>
          </dl>

        <form action="index.php" method="POST">
          <button class="btn btn-blue-grey mt-2 mb-2" type="submit">
            戻る
          </button>
        </form>
        <form action="thanks.php" method="POST">
          <button class="btn btn-default mt-2 mb-2" type="submit">
            上記の内容で登録
          </button>
          <input type="hidden" name="token" value="<?php echo h($token); ?>">
        </form>

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