<?php
try {
  $db = new PDO(
    'mysql:dbname=search_price_db;host=127.0.0.1;charset=utf8',
    'root',
    'root',
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );
} catch(PDOException $e) {
    // header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit('データベース接続エラー: '. $e->getMessage());
}
header('Content-Type: text/html; charset=utf-8');
?>