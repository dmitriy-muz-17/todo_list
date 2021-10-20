<?php

include 'checker.php';
require_once('db.php');

$data = $_POST;
$email_form = trim($data['email']);
$password_form = md5($data['password']);


if(isset($data['do_login']))
{
  $connection_to_db = new mysqli($hn, $un, $pw, $db);
  if($connection_to_db -> connect_error) die($connection_to_db -> connect_error);

  $db_user = $connection_to_db -> query("SELECT * FROM `users` WHERE `email`='$email_form' AND `password`='$password_form'  ");
  $array_db_user = $db_user -> fetch_assoc();

  if(isset($array_db_user))
  {

       setcookie('user', $array_db_user['id'], time() + 18000, "/");
       header('Location: /index.php');
  }
  else
  {
    echo '<div style="color: red;">Логін або пароль невірний. До речі, у нас немає системи відновлення паролю</div>';
  }

  $connection_to_db -> close();

}

?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Форма авторизації</title>
</head>

<body>
  <div class='container mt-4'>
    <h1>Форма для авторизації</h1>
    <form action="/login.php" method="post">


      <p>
        <p><strong>Ваш email</strong></p>
        <input type="email" name="email" value="<?php echo($data['email']);  ?>"><br>
      </p>

      <p>
        <p><strong>Ваш пароль</strong></p>
        <input type="password" name="password"><br>
      </p>

      <p>
        <button type="submit" class="btn btn-succes" style="background-color: green; color: white;" name="do_login">Вхід</button>
      </p>
    </form>
</div>
</body>

</html>
