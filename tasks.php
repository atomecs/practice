<!DOCTYPE html>
<html>
<head>
    <title>Список Задач</title>
    <meta charset="utf-8" />
</head>
<body>
<h2>Список Задач</h2>
<form method="POST" action="/deletetasksphp.php">
    <?php include 'printtasksphp.php'; ?>
    <button type="submit" class="btn btn-success"
            name="submit">Продолжить</button>
</form>
</body>
</html>
