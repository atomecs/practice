<?php
include 'db.php';
$res = "SELECT * FROM prioritets";
$stmt = $cn->query($res);
$r = '<select name="prioritet" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    $key = $val['id'];
    $r .= '<option value="' . $key . '">' . $val['prioritet'] . '</option>';

}

$r .= '</select><br><br>';
echo $r;
$res = "SELECT * FROM users";
$stmt = $cn->query($res);
$r = '<select name="user1" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    $key = $val['id'];
    $r .= '<option value="' . $key . '">' . $val['fio'] . '</option>';
}
$r .= '</select><br><br>';
echo $r;
$res = "SELECT * FROM users";
$stmt = $cn->query($res);
$r = '<select name="user2" size="1">';
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    $key = $val['id'];
    $r .= '<option value="' . $key . '">' . $val['fio'] . '</option>';
}
$r .= '</select><br><br>';
echo $r;
?>
