<?php
try {
  $db = parse_url($_SERVER['mysql://b080b700f88850:ad84688d@us-cdbr-east-02.cleardb.com/heroku_30ebda75726157d?reconnect=true']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $user = $db['user'];
  $password = $db['pass'];

  $dbh = new PDO($dsn, $user, $password, 
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