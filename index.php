<?php
  require "db.php";

  $connection_to_db = new mysqli($hn, $un, $pw, $db);
  if($connection_to_db -> connect_error) die($connection_to_db -> connect_error);

  $name_session = $_COOKIE['user'];
  $db_user = $connection_to_db -> query("SELECT * FROM `users` WHERE `id`='$name_session' ");
  $array_db_user = $db_user -> fetch_assoc();

  if($_COOKIE['user'] != '')
  {
    $task_array = $connection_to_db -> query("SELECT * FROM `tasks` WHERE `id_user`='$name_session' ");

  }

  $connection_to_db -> close();
?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="icon" href="/media/icon.png" type="image/png">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cuprum&display=swap" rel="stylesheet">
    <title>TODO list</title>
  </head>
  <body>


    <div id="header">


      <?php
      if($_COOKIE['user'] ==''):
      ?>
        <ul>
          <li><a href="/login.php" class="menu_item">Авторизація</a></li>
          <li><a href="/signup.php" class="menu_item">Реєстрація</a></li>
        </ul>

        <?php else:?>

          <ul>
            <li><a href="make_task.php" class="menu_item">Додати задачу</a></li>
            <li><a href="/exit.php" class="menu_item">Вийти</a></li>
          </ul>
      <?php endif;?>

    </div>

      <?php
      if($_COOKIE['user'] == ''):
      ?>
        <iframe src="https://www.youtube-nocookie.com/embed/3pWAzx7KtGI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="video_player"></iframe>

      <?php else:?>
        <div id="hello_text"><p>Привіт <?php echo($array_db_user['name']); ?>!</p></div>
        <h4> Cписок ваших справ: </h4>
        <?php
        while($row = mysqli_fetch_array($task_array))
        {
          ?>
          <div id="main">
          <?php
          printf("<p>Завдання: " .$row['name_task'] . "</p>");
          printf("<p>Дата виконання: " .$row['date_task'] . "</p>");
          printf("<p>Пріоритетність виконання: " .$row['priority_task'] . "</p>");
          printf("<p>Сфера діяльності: " .$row['place'] . "</p>");
          ?>
          </div>
          <?php
        }
         ?>
      <?php endif;?>


  </body>
</html>
