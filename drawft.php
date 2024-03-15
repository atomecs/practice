<?php
$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
$res = "SELECT prioritet FROM prioritets";
$stmt = $cn -> query($res);
$r = '<select name="select1" size="1">';
$i = 1;
foreach ($stmt -> fetchAll(PDO::FETCH_ASSOC) as $val) {
    foreach ($val as $key => $value){
        $r .= '<option value="'.$value.'">'.$value.'</option>';
        $i+= 1;
    }

}
$r .= '</select><br><br>';
echo $r;
$res = "SELECT fio FROM users";
$stmt = $cn -> query($res);
$r = '<select name="select2" size="1">';
$i = 1;
foreach ($stmt -> fetchAll(PDO::FETCH_ASSOC) as $val) {
    foreach ($val as $key => $value){
        $r .= '<option value="'.$value.'">'.$value.'</option>';
        $i+= 1;
    }

}
$r .= '</select><br><br>';
echo $r;
?>
