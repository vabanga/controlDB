<?php
$db_host = '127.0.0.1:3306';
$db_user = 'root';
$db_password = '';
$db_name = 'controlDB';

require_once __DIR__.'/classes/db.class.php';

$allTable = [];
try {
    $db = new DB($db_host, $db_user, $db_password, $db_name);

    //Создал две таблицы
    /*$addOne = $db->query("
        CREATE TABLE my_table (
        id INT AUTO_INCREMENT,
        name VARCHAR(30),
        age TINYINT,
        phone VARCHAR(15),
        PRIMARY KEY (id)
    );");
    $addTwo = $db->query("
        CREATE TABLE my_table_2 (
        id INT AUTO_INCREMENT,
        name VARCHAR(30),
        age TINYINT,
        phone VARCHAR(15),
        PRIMARY KEY (id)
    );");*/
    $allTable = $db->query("SHOW TABLES");

} catch (Exception $e) {
    echo $e->getMessage() . ':(';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Таблицы</title>
</head>
<body>
<h2>Таблицы из бд <?=$db_name;?></h2>
<table border="1">
    <tr>
        <th>Имя таблицы</th>
        <th>Просмотр</th>
    </tr>
    <?php
    foreach ($allTable as $table) {
        ?>
        <tr>
            <td><?=$table["Tables_in_controldb"]?></td>
            <td>
                <a href="table.php?nameTab=<?=$table["Tables_in_controldb"]?>">Просмотреть</a>
            </td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>
