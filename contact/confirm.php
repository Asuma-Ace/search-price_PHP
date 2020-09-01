<?php
session_start();
require('../join/common.php');
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
$subject = isset($_POST['subject']) ? $_POST['subject'] : NULL;
$inquiry = isset($_POST['inquiry']) ? $_POST['inquiry'] : NULL;

$error = array();
if (preg_match("/( |　)/",$name)) {
  $error['name'] = 'space';
} elseif (mb_strlen($name) > 50) {
  $error['name'] = 'length';
}
if (mb_strlen($subject) > 50) {
  $error['subject'] = 'length';
}
if (mb_strlen($inquiry) > 1000) {
  $error['inquiry'] = 'length';
}

$_SESSION['contact']['name'] = $name;
$_SESSION['contact']['email'] = $email;
$_SESSION['contact']['subject'] = $subject;
$_SESSION['contact']['inquiry'] = $inquiry;
$_SESSION['contact']['error'] = $error;

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
  <link rel="stylesheet" href="../join/css/bootstrap.min.css">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="../join/css/mdb.min.css">
  <!-- Custom styles -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="css/contact.css">
  <link rel="stylesheet" href="../css/responsive.css">
  <title>お問い合わせフォーム 内容確認画面</title>
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
            <a href="../join/index.php">新規会員登録</a>
          </li>
          <?php endif; ?>
          <li>
            <a href="index.php">お問い合わせ</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<main>
<div class="user_jc container">ようこそ、<strong><?php echo $login_user; ?></strong>さん</div>
  <div class="content_form">
    <h1 class="text-center">お問い合わせフォーム</h1>
    <div class="card mt-3">
      <!-- contact form -->
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">お問い合わせ 内容確認</h2>

          <dl>
            <div class="md-form check">
              <dt class="h5">お名前（ユーザー名）</dt>
              <dd><?php print h($name); ?></dd>
            </div>
            <div class="md-form check">
              <dt class="h5">メールアドレス</dt>
              <dd><?php print h($email); ?></dd>
            </div>
            <div class="md-form check">
              <dt class="h5">件名</dt>
              <dd><?php print h($subject); ?></dd>
            </div>
            <div class="md-form check">
              <dt class="h5">お問い合わせ内容</dt>
              <dd><?php print nl2br(h($inquiry)); ?></dd>
            </div>
          </dl>
          
        <form action="index.php" method="POST">
          <button class="btn btn-blue-grey mt-2 mb-2" type="submit">
            戻る
          </button>
        </form>
        <form action="complete.php" method="POST">
          <button class="btn btn-default mt-2 mb-2" type="submit">
            上記の内容で送信
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
  <script src="../join/js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script src="../join/js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="../join/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script src="../join/js/mdb.min.js"></script>
  <!-- Custom JavaScript -->
  <script src="../js/invalidmsg.js"></script>
  <script src="../js/script.js"></script>

</body>
</html>