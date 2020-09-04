<?php
session_start();
session_regenerate_id(TRUE);
require('../join/common.php');
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

if (!empty($_SESSION['contact'])) {
	$statement = $db->prepare('INSERT INTO heroku_30ebda75726157d.contact SET name=?, email=?, subject=?, inquiry=?, created=NOW()');
	$statement->execute([
		$_SESSION['contact']['name'],
    $_SESSION['contact']['email'],
    $_SESSION['contact']['subject'],
    $_SESSION['contact']['inquiry'],
  ]);
	unset($_SESSION['contact'], $_SESSION['token']);
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
      <div class="card-body mail_box">
        <h2 class="h3 card-title text-center mt-2">お問い合わせ 送信完了</h2>
        <div id="content">
          <p>お問い合わせ頂き、ありがとうございました。<br>
             入力頂いたメールアドレスに受付完了のメールを自動送信しています。<br>
             メールが届かない場合、送信エラーの可能性もありますのでお手数ですが再度お問い合わせください。
          </p>
          <p>なお、お問い合わせ内容に関しましては内容を確認の上、回答させて頂きます。<br>
          しばらくお待ちくださいませ。
          </p>
          <p class="text-center">
            <button class="text-center btn btn-blue-grey mt-2 mb-2" type="button" onclick="location.href='../index.php'">
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