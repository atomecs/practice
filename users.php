<!DOCTYPE html>
<html>
<head>
    <title>Список пользователей</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Список пользователей</h2>
<form method="POST" action="/deleteusersphp.php">
    <?php include 'printusersphp.php'; ?>
    <button type="submit" class="btn btn-success"
            name="submit">Продолжить
    </button>
</form>
</body>
</html>
