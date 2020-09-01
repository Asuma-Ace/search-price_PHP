<?php
function h($str) {
  if(is_array($str)){
    return array_map('h', $str);
  }else{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}

$login_out_url = '../login.php';
$login_out = 'ログイン';
$login_user = 'ゲスト';

if (isset($_SESSION['id'])) {
  $login_out_url = '../logout.php';
  $login_out = 'ログアウト';
  $login_user = '<a href="../login_m.php" class="login_user">' .$_SESSION['name'] . '</a>';
  if ($_SESSION['save'] === 'on' && $_SESSION['time'] + 3600*24*30 > time()) {
    $_SESSION['time'] = time();
  } elseif ($_SESSION['time'] + 3600*24 > time()) {
    $_SESSION['time'] = time();
  } else {
    header('Location: ../logout.php');
    exit();
  }
}
?>