<?php

  require('db.php');
  $data = $_POST;
  $name_task = $data['task_idea'];
  $date_task = $data['task_date'];
  $comment_task = $data['task_comment'];
  $priority_task = $data['task_priority'];
  $place_task = $data['task_place'];

  if(isset($data['regis_task']))
  {
    $errors = array();
    if(trim($data['task_idea']) == '' )
    {
      $errors[] = 'Введіть задачу!';
    }

    if(empty($errors))
    {
        $id_user =  $_COOKIE['user'];
        echo $name_task;
        echo $priority_task;
        if($date_task != '')
        {
          $conn = new mysqli($hn, $un, $pw, $db);
          if($conn->connect_error) die($conn->connect_error);
          $conn->query("INSERT INTO `tasks` (`name_task`, `date_task`, `comment`, `priority_task`, `place`, `id_user`) VALUES('$name_task', '$date_task', '$comment_task', '$priority_task', '$place_task', '$id_user' )");
          $conn->close();
        }
        else {
          $conn = new mysqli($hn, $un, $pw, $db);
          if($conn->connect_error) die($conn->connect_error);
          $conn->query("INSERT INTO `tasks` (`name_task`, `comment`, `priority_task`, `place`, `id_user`) VALUES('$name_task', '$comment_task', '$priority_task', '$place_task', '$id_user' )");
          $conn->close();
        }
        header('Location: /index.php');

    }
    else
    {
      echo '<div style="color: red;">'.array_shift($errors).'</div>';
    }
  }


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Додати задачу</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>


  <body>

    <?php
      if($_COOKIE['user'] == ''):
    ?>
    <br><br>
    <center><strong><h1>Ви не авторизувалися!!!</h1></strong>
    <a href="index.php"><button type="submit" class="btn btn-succes" style="background-color: green; color: white;"  name="button">Перейти на головну</button></a></center>
    <?php else:?>
  <div class='container mt-4'>
      <h1>Форма завдання</h1>
      <form action="make_task.php" method="post">

        <p>
          <p>Введіть задачу</p>
          <input type="text" name="task_idea" placeholder="Обов'язкове поле" value="<?php echo($data['task_idea']); ?>">
        </p>

        <p>
          <p>Введіть дату виконання</p>
          <input type="date" name="task_date" value="<?php echo($data['task_date']); ?>">
        </p>

        <p>
          <p>Введіть коментар до вашого завдання</p>
          <input type="text" name="task_comment" value="<?php echo($data['task_comment']); ?>">
        </p>

        <p>
        <p>Оберіть пріоритетність</p>
        <select  name="task_priority" style="background-color: white;">
          <option>Жопу рвать</option>
          <option>Ну таке, може трохи почекати</option>
          <option>Було би непогано якось зробити</option>
        </select>
        </p>

        <p>
        <p>Оберіть сферу діяльності</p>
        <select name="task_place" style="background-color: white;" >
          <option>Навчання</option>
          <option>Робота</option>
          <option>Спорт</option>
          <option>Сім'я, немає нічого важливіше сім'ї!</option>
        </select>
        </p>
        <button type="submit" name="regis_task" class="btn btn-succes" style="background-color: green; color: white;">Додати задачу</button>
      </form>
    <?php endif?>
    </div>
  </body>
</html>
