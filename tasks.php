<!DOCTYPE html>
<html>
<head>
    <title>Список Задач</title>
    <meta charset="utf-8" />
</head>
<body>
<h2>Список Задач</h2>
<form method="POST" action="/tasks.php">
    <?php
    $cn = pg_connect("host=localhost port=5432 dbname=train
    user=postgres password = daniil2018");
    $res = pg_query($cn, "SELECT t.id, t.describe, t.dedline, p.prioritet, u.fio
          FROM tasks t
          JOIN prioritets p ON t.fk_prioritet = p.id
          JOIN users u ON t.fk_tasks_users = u.id");
    echo "<table><tr><th>Id</th><th>Describe</th><th>Dedline</th><th>Prioritet</th><th>User</th></tr>";
    while ($row = pg_fetch_row($res)) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
        echo "<td>" . $row[4] . "</td>";
        echo "<td><input type='checkbox' name='delete' value=$row[0]> Delete</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <button type="submit" class="btn btn-success"
            name="submit">Продолжить</button>
</form>
</body>
</html>
<?php
require_once('db.php');
$cn = pg_connect("host=localhost port=5432 dbname=train
    user=postgres password = daniil2018");
if (isset($_POST['submit'])) {
    $delete = $_POST['delete'];
    if (!$delete) die("Please, input all
values!");
    $query = "DELETE FROM users WHERE id = $delete";
    if($result = pg_query($query)){
        echo "Data Added Successfully.";
    }
    else{
        echo "Error.";
    }
}
?>