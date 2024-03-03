<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,
    initial-scale=1.0">
    <title>Создать задачу</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.m
    in.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9J
    voRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container mt-4" align="center">
    <h1>Создать задачу</h1>
    <form method="POST" action="/ctask.php">
        <input class="form-control" type="text" name="describe"
               placeholder="Describe">
        <br>
        <br>
        <input class="form-control" type="date" name="deadline"
               placeholder="Deadline">
        <br>
        <br>
        <?php
            require_once('db.php');
            $cn = pg_connect("host=localhost port=5432 dbname=train
            user=postgres password = daniil2018");
            $res = pg_query($cn, "SELECT prioritet FROM prioritets");
            $r = '<select name="select1" size="1">';
            $i = 1;
            while ($row = pg_fetch_row($res)) {
                $r .= '<option value="'.$row[0].'">'.$row[0].'</option>';
                $i+= 1;
            }
            $r .= '</select><br><br>';
            echo $r;
        ?>
        <?php
        require_once('db.php');
        $cn = pg_connect("host=localhost port=5432 dbname=train
            user=postgres password = daniil2018");
        $res = pg_query($cn, "SELECT fio FROM users");
        $r = '<select name="select2" size="1">';
        $i = 1;
        while ($row = pg_fetch_row($res)) {
            $r .= '<option value="'.$row[0].'">'.$row[0].'</option>';
            $i+= 1;
        }
        $r .= '</select><br><br>';
        echo $r;
        ?>
        <button type="submit" class="btn btn-success"
                name="submit">Продолжить</button>
    </form>
</div>
</body>
</html>
<?php
$cn = pg_connect("host=localhost port=5432 dbname=train
    user=postgres password = daniil2018");
if (isset($_POST['submit'])) {
    $describe = $_POST['describe'];
    $deadline = $_POST['deadline'];
    $select1 = $_POST['select1'];
    $select2 = $_POST['select2'];
if (!$describe || !$deadline|| !$select1 || !$select2) die("Please, input all
values!");
$query = "INSERT INTO tasks (describe, dedline, fk_prioritet, fk_tasks_users ) VALUES ('$describe',
'$deadline', (SELECT id FROM prioritets WHERE prioritet = '$select1'), (SELECT id FROM users WHERE fio = '$select2'))";
    if($result = pg_query($query)){
        echo "Data Added Successfully.";
    }
    else{
        echo "Error.";
    }
}
?>
