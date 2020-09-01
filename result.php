<?php
session_start();
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');
require('dbconnect.php');
require('common.php');
require('yahoo.php');
require('rakuten.php');

if (isset($_POST['token'], $_SESSION['token'])) {
  $token = $_POST['token'];
  if ($token !== $_SESSION['token']) {
    die('CSRFトークンが無効です。フォームを再送信してください');
  }
} else {
  die('直接このページにはアクセスできません');
}

if (!isset($_POST['keyword'])) {
	header('Location: index.php');
	exit();
}

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : NULL;
$y_shop = isset($_POST['y_shop']) ? $_POST['y_shop'] : NULL;
$r_shop = isset($_POST['r_shop']) ? $_POST['r_shop'] : NULL;
$category = isset($_POST['category']) ? (int)$_POST['category'] : NULL;
$minPrice = isset($_POST['minPrice']) ? (int)$_POST['minPrice'] : NULL;
$maxPrice = isset($_POST['maxPrice']) ? (int)$_POST['maxPrice'] : NULL;
$pre = isset($_POST['pre']) ? (int)$_POST['pre'] : NULL;
$next = isset($_POST['next']) ? (int)$_POST['next'] : NULL;

$error = array();
if (!isset($y_shop) && !isset($r_shop)) {
  $error['shop'] = 'brank';
}
if ($_POST['minPrice'] >= $_POST['maxPrice']) {
  $error['price'] = 'price';
}

if (isset($_SESSION['search']['keyword'])) {
  if ($_SESSION['search']['keyword'] == $keyword) {
    if (isset($_POST['pre'])) {
      $_SESSION['search']['next_y'] -= 10;
      $_SESSION['search']['next_r'] -= 1;
    }

    if (isset($_POST['next'])) {
      $_SESSION['search']['next_y'] += 10;
      $_SESSION['search']['next_r'] += 1;
    }
  } else {
    $_SESSION['search']['next_y'] = 0;
    $_SESSION['search']['next_r'] = 0;
  }
}

$_SESSION['search']['keyword'] = $keyword;
// $_SESSION['search']['y_shop'] = $y_shop;
// $_SESSION['search']['r_shop'] = $r_shop;
// $_SESSION['search']['category'] = $category;
// $_SESSION['search']['minPrice'] = $minPrice;
// $_SESSION['search']['maxPrice'] = $maxPrice;
// $_SESSION['search']['error'] = $error;


// echo '<pre>';
// var_dump($_POST);
// var_dump($_SESSION);
// echo '</pre>';
?>
<!DOCTYPE html>
<html lang='ja'>
<head>
  <title>最安値検索結果（Yahoo!ショッピング＆楽天市場）</title>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width,initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css" media="screen and (max-width: 1000px)">
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
          <input id="keyword" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" type="search" name="keyword" size="50" maxlength="64" placeholder="検索キーワードを入力してください" value="<?php print h($keyword); ?>" required>
          <button type="submit" id="search_btn"><i class="fas fa-search"></i>検索</button>
          <input type="hidden" name="token" value="<?php echo h($token); ?>">
        </div>
      </div>
    </div>
 
    <div class="condition">
      <div class="container menu">
        <div class="condition_title">詳細条件<div class="menu_arrow">＞</div></div>
      </div>

    <div class="<?php if (empty($error)) echo 'result_item'; ?>">
      <table>
        <tr>
          <th class="subtitle">＞ECモール</th>
            <?php if ($error['shop'] === 'brank'): ?>
              <div class="result_error">* ECモール選択してください</div>
            <?php endif ?>
            
            <td class="detail">
              <table>
                <tr>
                  <td>
                    <input id="y_shop" name="y_shop" type="checkbox" value="y_shop" <?php if (isset($y_shop)) {echo 'Checked';} ?>><label for="y_shop">Yahoo!ショッピング</label>
                  </td>
                  <td>
                    <input id="r_shop" name="r_shop" type="checkbox" value="r_shop" <?php if (isset($r_shop)) {echo 'Checked';} ?>><label for="r_shop" >楽天市場</label>
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
              <option value="<?php echo $k; ?>" <?php if ($category == $k) echo 'selected'; ?>><?php echo $v; ?></option>
            <?php endforeach; ?>
          </select>
            </td>
        </tr>

        <tr>
          <th class="subtitle">＞価格帯</th>
          <?php if ($error['price'] === 'price'): ?>
            <div class="result_error">* 正しい価格帯を選択してください</div>
          <?php endif ?>

            <td class="price_range detail_item">
              <select name="minPrice" id="minPrice">
                <?php $minPrices = [1 => 下限なし, 1000 => 1000, 3000 => 3000, 5000 => 5000, 10000 => 10000, 20000 => 20000, 30000 => 30000, 50000 => 50000]; ?>
                <?php foreach ($minPrices as $k => $v): ?>
                  <option value="<?php echo $k; ?>" <?php if ($minPrice == $k) echo 'selected'; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select><span>円～</span>
              <select name="maxPrice" id="maxPrice">
                <?php $maxPrices = [1000 => 1000, 3000 => 3000, 5000 => 5000, 10000 => 10000, 20000 => 20000, 30000 => 30000, 50000 => 50000, 99999999 => 上限なし]; ?>
                <?php foreach ($maxPrices as $k => $v): ?>
                  <option value="<?php echo $k; ?>" <?php if ($maxPrice == $k) echo 'selected'; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select><span>円</span>
            </td>
        </tr>
      </table>
    </div>

    </div>

  <div class="container">
<?php
if (isset($y_shop)) {
  $y_genre = ['1','2494','2495','2496','2496','2498','2498','2499','2499','2499','2512,2513','2500','2501','2502','2502','2504','2505','2506','2507,2503','2508','2508','2509','2510','2511','2511','2511','2497','2514','2514','2516,2517','10002','47727'];
  $page = $_SESSION['search']['next_y'];
  $hits = isset($r_shop) ? 10 : 20; 

  $yahoo_relust = getYahooResult($keyword, $y_genre[$category], $minPrice, $maxPrice, $page, $hits);
}

if (isset($r_shop)) {
  $r_genre = ['0','100371','551177','558929','216129','100227','551167','100316','510915','510901','101070','100938','100939','100026','564500','211742','562637','100804','100005','215783','558944','101213','112493','566382','101205','101164','100533','101114','503190','101240','200162','101438'];
  $page = $_SESSION['search']['next_r'];
  $hits = isset($y_shop) ? 10 : 20;

  $rakuten_relust = getRakutenResult($keyword, $r_genre[$category], $minPrice, $maxPrice, $page, $hits);
}

if (isset($y_shop) && isset($r_shop)) {
  $yr_result = array_merge($yahoo_relust, $rakuten_relust);
  foreach ($yr_result as $k => $v) {
    $sort_keys[$k] = $v['price'];
  }
  array_multisort($sort_keys, SORT_ASC, $yr_result);
} elseif (isset($y_shop)) {
  $yr_result = $yahoo_relust;
} elseif (isset($r_shop)) {
  $yr_result = $rakuten_relust;
}

  // echo '<pre>';
  // var_dump($yr_result);
  // echo '</pre>';
?>
<!-- result -->
  <?php
  $num = 1;
  if (!empty($_SESSION['search']['next_y'])) {
    $num += $_SESSION['search']['next_y'] * 2;
  } elseif (!empty($_SESSION['search']['next_r'])) {
    $num += $_SESSION['search']['next_r'] * 20;
  }

  foreach ($yr_result as $item) :
    if ($item['tax'] == 0 || $item['tax'] == NULL) {
      $item['tax'] = '（税込）';
    } else {
      $item['tax'] = '（税別）';
    }
  ?>
  <div class="item_card">
    <table>
      <tr>
        <th><?php echo $num; ?></th>
          <td class="result_img"><img src="<?php echo $item['img']; ?>" width="146" height="146"></td>
          <td>
            <ul class="result_detail">
              <li class="result_name"><?php echo $item['name']; ?></li>
              <li class="result_price">価格<span><?php echo $item['price']; ?></span>円<?php echo $item['tax']; ?></li>
              <li class="result_store">店舗名／<a href="<?php echo $item['shop_url']; ?>" target="_blank"><?php echo $item['shop']; ?></a></li>
              <li><button type="submit" class="transition" formaction="<?php echo $item['url']; ?>" formtarget="_blank">ショッピングサイトへ</a></button></li>
            </ul>
          </td>
      </tr>
    </table>
  </div>
  <?php $num++; ?>
  <?php endforeach; ?>
<!-- result -->
<!-- page -->
  <?php if (empty($error)): ?>
    <div>
      <ul class="paging">
        <?php if ($_SESSION['search']['next_y'] > 1 || $_SESSION['search']['next_r'] > 1): ?>
          <li><button type="submit" name="pre">前のページへ</button></li>
        <?php endif; ?>
          <li><button type="submit" name="next">次のページへ</button></li>
      </ul>
    </div>
  <?php endif; ?>
<!-- page -->
  </form>

  </div>
</main>

<footer>
  <div class="copyright">&copy; 2020<?php if( date('Y') > "2020")//{echo "-".date('Y');}?> Samua</div>
</fotter>

  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/invalidmsg.js"></script>
  <script src="js/script.js"></script>

</body>
</html>
