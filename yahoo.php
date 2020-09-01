<?php
function getYahooResult ($keyword, $genre, $min_price, $max_price, $start, $hits) {

  // ベースリクエストURL
  $baseurl = 'https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch';

  // 入力パラメータ作成
  $params = array();
  // アプリケーションID
  $params['appid'] = 'dj00aiZpPVNZU1BIZ3p2eGNRQiZzPWNvbnN1bWVyc2VjcmV0Jng9NDI-';
  // 検索キーワード、UTF-8
  $params['query'] = rawurlencode($keyword);
  // ジャンルカテゴリID(カンマ区切りで複数指定)
  $params['genre_category_id'] = $genre;
  // 最小価格
  $params['price_from'] = $min_price;
  // 最大価格
  $params['price_to'] = $max_price;
  // 返却結果の先頭位置
  $params['start'] = 1+$start;
  // 検索結果の返却数
  $params['results'] = $hits;
  // 並び順、utf-8
  $params['sort'] = rawurlencode('+price');

  // used: 中古、new: 新品
  $params['condition'] = 'new';
  // true：在庫ありのみ, false：在庫なしのみ
  $params['in_stock'] = 'true';

  // 入力パラメータリクエストURL
  $params_url='';
  foreach($params as $key => $value) {
      $params_url .= '&' . $key . '=' . $value;
  }
  $params_url = substr($params_url, 1);

  // リクエストURL
  $url = $baseurl . '?' . $params_url;
  // echo $url . "<br>";

  // JSON文字列を取得＆デコード
  $yahoo_json = json_decode(file_get_contents($url), true);
  // echo '<pre>';
  // var_dump($yahoo_json);
  // echo '</pre>';

  // 出力パラメータ作成
  $counts_y = (int)$yahoo_json['totalResultsAvailable'];
  echo '<div>yahoo!ショッピング／' . $counts_y . '件</div>';

  $items = array();
  foreach($yahoo_json['hits'] as $item){
    $items[] = array(
      'name' => (string)$item['name'],
      'url' => (string)$item['url'],
      'img' => (string)$item['image']['medium'],
      'price' => (int)$item['price'],
      'shop' => (string)$item['seller']['name'],
      'shop_url' => (string)$item['seller']['url'],
    );
  }
  return $items;
}
?>