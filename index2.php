<?php
session_start();
if(!$_SESSION['login']){
    header('Location: login.php');
}
?>
<html>
<body>
    ログイン成功！    
</body>
</html>
