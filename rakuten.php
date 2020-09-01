<?php 
function getRakutenResult($keyword, $genre, $min_price, $max_price, $page, $hits) {

  // ベースリクエストURL
  $baseurl = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706';

  // 入力パラメータ作成
  $params = array();
  // アプリID
  $params['applicationId'] = '1021198561298606380';
  // 検索キーワード、UTF-8
  $params['keyword'] = rawurlencode($keyword);
  // ジャンルID
  $params['genreId'] = $genre;
  // 最小価格
  $params['minPrice'] = $min_price;
  // 最大価格
  $params['maxPrice'] = $max_price;
  // 取得ページ(1~100)
  $params['page'] = 1+$page; 
  // 1ページあたりの取得件数(1~30)
  $params['hits'] = $hits; 
  // ソート（並べ方）、UTF-8
  $params['sort'] = rawurlencode('+itemPrice'); 

  // 0：すべての商品, 1：販売可能な商品のみ
  $params['availability'] = 1; 
  // 0 : すべての商品を検索対象, 1 : 商品画像ありの商品のみを検索対象
  $params['imageFlag'] = 1; 
  // PC: 0, mobile: 1, smartphone: 2
  $params['carrire'] = 0; 
  // 0 :すべての商品, 1 :送料込み／送料無料の商品のみ
  $params['postageFlag'] = 0; 
  // 0 :ジャンルごとの商品数の情報を取得しない, 1 :取得する
  $params['genreInformationFlag'] = 1;

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
  $rakuten_json=json_decode(file_get_contents($url), true);
  // echo '<pre>';
  // var_dump($rakuten_json);
  // echo '</pre>';

  // 出力パラメータ作成
  $counts_r = (int)$rakuten_json['count'];
  echo '<div>楽天市場／' . $counts_r . '件</div>';

  $items = array();
  foreach ($rakuten_json['Items'] as $item) {
    $items[] = array(
      'name' => (string)$item['Item']['itemName'],
      'url' => (string)$item['Item']['itemUrl'],
      'img' => (string)$item['Item']['mediumImageUrls'][0]['imageUrl'],
      'price' => (int)$item['Item']['itemPrice'],
      'tax' => (int)$item['Item']['taxFlag'],
      'shop' => (string)$item['Item']['shopName'],
      'shop_url' => (string)$item['Item']['shopUrl'],
    );
  }
  return $items;
}
?>