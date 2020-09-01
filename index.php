<?php
session_start();
require('common.php');
// require('dbconnect.php');

$_SESSION['search']=array();

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
  <link href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css" media="screen and (max-width: 1000px)">
  <title>最安値検索（Yahoo!ショッピング＆楽天市場）</title>
</head>

<body>
<header>
  <div class="container">
    <div class="header-title">
      <div id="top-btn" class="header-logo"><a href="index.php">最安値検索<span id="shop">（Yahoo!ショッピング＆楽天市場）</span></a></div>
    </div>
    <div id="wrapper">
      <p class="btn-gnavi btn-re">
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
  <form  action="result.php" method="post">

    <div class="search">
      <div class="container">
        <div class="user_jc">ようこそ、<strong><?php echo $login_user; ?></strong>さん</div>
        <div class="search_key">
          <input id="keyword" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" type="search" name="keyword" size="50" maxlength="64" placeholder="検索キーワードを入力してください" value="" required>
          <button type="submit" id="search_btn"><i class="fas fa-search"></i>検索</button>
          <input type="hidden" name="token" value="<?php echo h($token); ?>">
        </div>
      </div>
    </div>

    <div class="condition">
      <div class="container menu">
        <div class="condition_title">詳細条件<script class="menu_arrow open">＞</script></div>
      </div>

      <div class="menu_item">
        <table>
          <tr>
            <th class="subtitle">＞ECモール</th>
              <td class="detail">
                <table>
                  <tr>
                    <td>
                      <input id="y_shop" name="y_shop" type="checkbox" value="y_shop" Checked><label for="y_shop">Yahoo!ショッピング</label>
                    </td>
                    <td>
                      <input id="r_shop" name="r_shop" type="checkbox" value="r_shop" Checked><label for="r_shop">楽天市場</label>
                    </td>
                  </tr>
                </table>
              </td>
          </tr>
          
          <tr>
            <th class="subtitle">＞カテゴリ</th>
              <td class="detail detail_item">
                <select name="category" id="category">
                  <?php $categories = [すべてのカテゴリ, レディースファッション, メンズファッション, 腕時計, ジュエリー・アクセサリー, 食品,スイーツ・お菓子, 水・ソフトドリンク, ビール・洋酒, 日本酒・焼酎, スポーツ・アウトドア, ダイエット・健康, 美容・コスメ, パソコン・周辺機器, スマートフォン・タブレット, TV・オーディオ・カメラ, 家電, 家具・インテリア, 花・ガーデン・DIY, 日用品・雑貨・文具, キッチン用品, 生き物・ペット用品, 楽器・音響機器, おもちゃ, TVゲーム, ホビー, キッズ・ベビー・マタニティ, 車・バイク, 車用品・バイク用品, CD・DVD, 本・雑誌・コミック, サービス・レンタル];?>
                  <?php foreach ($categories as $k => $v) : ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
          </tr>

          <tr>
            <th class="subtitle">＞価格帯</th>
              <td class="price_range detail_item">
                <select name="minPrice" id="minPrice">
                  <?php $minPrices = [1 => 下限なし, 1000 => 1000, 3000 => 3000, 5000 => 5000, 10000 => 10000, 20000 => 20000, 30000 => 30000, 50000 => 50000]; ?>
                  <?php foreach ($minPrices as $k => $v): ?>
                    <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select><span>円～</span>
                <select name="maxPrice" id="maxPrice">
                  <?php $maxPrices = [1000 => 1000, 3000 => 3000, 5000 => 5000, 10000 => 10000, 20000 => 20000, 30000 => 30000, 50000 => 50000, 99999999 => 上限なし]; ?>
                  <?php foreach ($maxPrices as $k => $v): ?>
                    <option value="<?php echo $k; ?>"<?php if ($k == 99999999) echo 'selected'; ?>><?php echo $v; ?></option>
                  <?php endforeach; ?>
                </select><span>円</span>
              </td>
          </tr>
        </table>
      </div>    
    </div>

  </form>
</main>

<footer>
  <div class="copyright">&copy; 2020<?php if( date('Y') > "2020") {echo "-".date('Y');}?> Samua</div>
</fotter>

  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/invalidmsg.js"></script>
  <script src="js/script.js"></script>

</body>
</html>
