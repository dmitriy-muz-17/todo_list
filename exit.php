<?php
 setcookie('user', $array_db_user['login'], time() - 18000, "/");
 header('Location: /index.php');
 ?>
