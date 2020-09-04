<?php
function dbConnect(){
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db['heroku_30ebda75726157d'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['us-cdbr-east-02.cleardb.com']};dbname={$db['heroku_30ebda75726157d']};charset=utf8";
  $user = $db['b080b700f88850'];
  $password = $db['ad84688d'];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
  );
  $dbh = new PDO($dsn,$user,$password,$options);
  return $dbh;
  }
  ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
  $dbh = dbConnect();
?>