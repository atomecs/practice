<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <title>Создать пользователя</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.m
    in.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9J
    voRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4" align="center">
    <h1>Создание пользователя</h1>
    <form method="POST" action="/cuser.php">
        <input class="form-control" type="text" name="username"
               placeholder="Username">
        <br>
        <button type="submit" class="btn btn-success"
                name="submit">Продолжить</button>
    </form>
</div>
</body>
</html>
<?php
require_once('db.php');
    $cn = pg_connect("host=localhost port=5432 dbname=train
    user=postgres password = daniil2018");
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    if (!$username) die("Please, input all
values!");
    $query = "INSERT INTO users(fio) 
	 values ('$username')";
    if($result = pg_query($query)){
        echo "Data Added Successfully.";
    }
    else{
        echo "Error.";
    }
}
?>