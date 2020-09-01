<?php
session_start();
require('../join/common.php');

$name = isset($_SESSION['contact']['name']) ? $_SESSION['contact']['name'] : NULL;
$email = isset($_SESSION['contact']['email']) ? $_SESSION['contact']['email'] : NULL;
$subject = isset($_SESSION['contact']['subject']) ? $_SESSION['contact']['subject'] : NULL;
$inquiry = isset($_SESSION['contact']['inquiry']) ? $_SESSION['contact']['inquiry'] : NULL;
$error = isset($_SESSION['contact']['error']) ? $_SESSION['contact']['error'] : NULL;

if (isset($_SESSION['id'])) {
  if (!empty($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
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
  <title>お問い合わせフォーム 内容入力画面</title>
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
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">お問い合わせ 内容入力</h2>
        <form method="POST" action="confirm.php">
          
          <div class="md-form">
            <label for="name">お名前（ユーザー名）<span class="error">*必須</span></label>
            <input class="form-control" type="text" id="name" name="name" oninvalid="InvalidName(this);" oninput="InvalidName(this);" value="<?php print h($name); ?>" required>
            <?php if ($error['name'] === 'space'): ?>
					    <p class="error">* 半角/全角スペースは使用しないでください</p>
            <?php endif; ?>
            <?php if ($error['name'] === 'length'): ?>
              <p class="error">* 50文字以内で入力してください</p>
            <?php endif; ?>
          </div>

          <div class="md-form">
            <label for="email">メールアドレス<span class="error">*必須</span></label>
            <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="<?php print h($email); ?>" maxlength="256" required>
          </div>

          <div class="md-form">
            <label for="subject">件名（50文字以内）<span class="error">*必須</span><span id="s_count"></span>/50</label>
            <input class="form-control" type="text" id="subject" name="subject" oninvalid="InvalidSubject(this);" oninput="InvalidSubject(this);" value="<?php print h($subject); ?>" required>
            <?php if ($error['subject'] === 'length'): ?>
              <p class="error">* 50文字以内で入力してください</p>
            <?php endif; ?>
          </div>

          <div class="md-form">
            <label for="inquiry" class="inquirylabel">お問い合わせ内容（1000文字以内）<span class="error">*必須</span><span id="b_count"></span>/1000</label>
            <textarea  class="form-control" id="inquiry" name="inquiry" cols="35" rows="9" oninvalid="InvalidInquiry(this);" oninput="InvalidInquiry(this);" value="<?php print h($inquiry); ?>" required><?php echo h($inquiry); ?></textarea>
            <?php if ($error['inquiry'] === 'length'): ?>
              <p class="error">* 1000文字以内で入力してください</p>
            <?php endif; ?>
          </div>

          <button class="btn btn-default mt-2 mb-2" type="submit">
            確認画面へ
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
  <script src="js/script.js"></script>
  <script src="../js/script.js"></script>

</body>
</html>