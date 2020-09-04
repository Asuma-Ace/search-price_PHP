<?php
try {
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
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
  return $dbh;
} catch(PDOException $e) {
    // header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit('データベース接続エラー: '. $e->getMessage());
}
header('Content-Type: text/html; charset=utf-8');
?>