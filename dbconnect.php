<?php
try {
  $db = new PDO(
    'mysql:dbname=heroku_30ebda75726157d;host=us-cdbr-east-02.cleardb.com;charset=utf8',
    'b080b700f88850',
    'ad84688d',
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