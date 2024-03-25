<?php
include 'dataBase.php';
$result = "SELECT * FROM prioritets";
$stmt = $connect->query($result);
$writerHtml = '<select name="prioritet" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
    $key = $value['id'];
    $writerHtml .= '<option value="' . $key . '">' . $value['prioritet'] . '</option>';

}

$writerHtml .= '</select><br><br>';
echo $writerHtml;
$result = "SELECT * FROM users";
$stmt = $connect->query($result);
$writerHtml = '<select name="user1" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
    $key = $value['id'];
    $writerHtml .= '<option value="' . $key . '">' . $value['fio'] . '</option>';
}
$writerHtml .= '</select><br><br>';
echo $writerHtml;
$result = "SELECT * FROM users";
$stmt = $connect->query($result);
$writerHtml = '<select name="user2" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
    $key = $value['id'];
    $writerHtml .= '<option value="' . $key . '">' . $value['fio'] . '</option>';
}
$writerHtml .= '</select><br><br>';
echo $writerHtml;
?>
