<?php
//signup.php регістрація

  include 'checker.php';
  require_once('db.php');
  $data = $_POST;
  $login_form = $data['login'];
  $email_form = $data['email'];
  $password_form = md5($data['password']);

  if(isset($data['do_signup']) )
  {
    // isset повератє FALSE якщо зміна пуста null, або TRUE якщо значення коректне
    //якщо натиснута button do_signup із массива POST, то починаємо запис даних


    //Перевірка на наявність некоректних даних та додавання проблем в масив помилок
    $errors = array();
    if(trim($data['login']) == '' )
    {
      $errors[] = 'Введіть ваше імʼя!';
    }
    if(trim($data['password']) == '' )
    {
      $errors[] = 'Введіть пароль!';
    }
    if(trim($data['email']) == '' )
    {
      $errors[] = 'Введіть Email!';
    }
    if( ($data['password']) != ($data['password_2']) )
    {
      $errors[] = 'Повторний пароль невірний';
    }

    $conn = new mysqli($hn, $un, $pw, $db);
    if($conn->connect_error) die($conn->connect_error);
    $account_check = $conn -> query("SELECT * FROM `users` WHERE `email` = '$email_form' ");
    $account_check_array = $account_check->fetch_assoc();
    if(isset($account_check_array))
    {
      $errors[] = 'already used email';
    }
    $conn->close();


    if(empty($errors))
    {
    //Всі дані коректні та правильно заповнені, передаємо дані в БД
      $conn = new mysqli($hn, $un, $pw, $db);
      if($conn->connect_error) die($conn->connect_error);
      $conn->query("INSERT INTO `users` (`name`, `password`, `email`) VALUES('$login_form', '$password_form', '$email_form')");
      $conn->close();
      header('Location: /transfer.php');
    }

    else
    {
    // 2) Ввивід першої помилки користувачу
      echo '<div style="color: red;">'.array_shift($errors).'</div>';
    }


  }

?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Форма реєстрації</title>
</head>

<body>
  <div class='container mt-4'>
    <h1>Форма для реєстрації аккаунта</h1>
    <br>
    <form action="/signup.php" method="post">
      <p>
        <p><strong>Як до вас звертатися?</strong></p>
        <input type="text" name="login" value="<?php echo($data['login']); ?>">
      </p>

      <p>
        <p><strong>Ваш email</strong></p>
        <input type="email" name="email" value="<?php echo($data['email']);  ?>"><br>
      </p>

      <p>
        <p><strong>Ваш пароль</strong></p>
        <input type="password" name="password"><br>
      </p>

      <p>
        <p><strong>Введіть пароль ще раз</strong></p>
        <input type="password" name="password_2"><br>
      </p>

      <p>
        <button type="submit" class="btn btn-succes" style="background-color: green; color: white;" name="do_signup">Зареєструватися</button>
      </p>
    </form>
</div>
</body>

</html>
