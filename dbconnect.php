<?php
try {
  $url = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db_name = ltrim($url['path'], '/');
  $db_host = 'us-cdbr-east-02.cleardb.com';
  $user = 'b080b700f88850';
  $password = 'ad84688d';
  $dsn = 'mysql:dbname='.$db_name.';host='.$db_host.';charset=utf8';

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