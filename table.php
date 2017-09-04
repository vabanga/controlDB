<?php
$db_host = '127.0.0.1:3306';
$db_user = 'root';
$db_password = '';
$db_name = 'controlDB';

$nameGet = $_GET['nameTab'];
$tables = [];
require_once __DIR__.'/classes/db.class.php';
if(!isset($nameGet)){
    echo 'Не пришло название таблицы';
}
try {
    $db = new DB($db_host, $db_user, $db_password, $db_name);
    $tables = $db->query("SELECT * FROM $nameGet");
} catch (Exception $e) {
    echo $e->getMessage() . ':(';
}
if($_POST['del']){
    $id = $_POST['change_id'];
    try {
        $db = new DB($db_host, $db_user, $db_password, $db_name);
        $db->query("DELETE FROM $nameGet WHERE id = $id");
    } catch (Exception $e) {
        echo $e->getMessage() . ':(';
    }
    header("Location: table.php?nameTab=$nameGet");
}
if($_POST['change']){
    $id = $_POST['change_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    if(!empty($name)){
        try {
            $db = new DB($db_host, $db_user, $db_password, $db_name);
            $db->query("UPDATE my_table_2 SET name = '$name' WHERE my_table_2.id = $id");
        } catch (Exception $e) {
            echo $e->getMessage() . ':(';
        }
    }
    if(!empty($age)){
        try {
            $db = new DB($db_host, $db_user, $db_password, $db_name);
            $db->query("UPDATE my_table_2 SET age = $age WHERE my_table_2.id = $id");
        } catch (Exception $e) {
            echo $e->getMessage() . ':(';
        }
    }
    if(!empty($phone)){
        try {
            $db = new DB($db_host, $db_user, $db_password, $db_name);
            $db->query("UPDATE my_table_2 SET phone = '$phone' WHERE my_table_2.id = $id");
        } catch (Exception $e) {
            echo $e->getMessage() . ':(';
        }
    }
    header("Location: table.php?nameTab=$nameGet");
}
$types = [
    '0' => 'INT',
    '1' => 'VARCHAR',
    '3' => 'TEXT',
    '4' => 'DATE'
];
$typeInt = [
    '0' => 'TINYINT',
    '1' => 'SMALLINT',
    '3' => 'MEDIUMINT',
    '4' => 'INT',
    '5' => 'BIGINT',
    '6' => 'DECIMAL',
    '7' => 'FLOAT',
    '8' => 'DOUBLE',
    '9' => 'REAL',
    '10' => 'BIT',
    '11' => 'BOOLEAN',
    '12' => 'SERIAL'
];
$typeDate = [
    '0' => 'DATE',
    '1' => 'DATETIME',
    '3' => 'TIMESTAMP',
    '4' => 'TIME',
    '5' => 'YEAR'
];
$typeSymbol = [
    '0' => 'CHAR',
    '1' => 'VARCHAR',
    '3' => 'TINYTEXT',
    '4' => 'TEXT',
    '5' => 'MEDIUMTEXT',
    '6' => 'BINARY',
    '7' => 'VARBINARY',
    '8' => 'TINYBLOB',
    '9' => 'BLOB',
    '10' => 'LONGBLOB',
    '11' => 'ENUM',
    '12' => 'SET'
];
$typeSpace = [
    '0' => 'GEOMETRY',
    '1' => 'POINT',
    '3' => 'LINESTRING',
    '4' => 'POLYGON',
    '5' => 'MULTIPOINT',
    '6' => 'MULTILINESTRING',
    '7' => 'MULTIPOLYGON',
    '8' => 'GEOMETRYCOLLECTION'
];
$typeJson = [
    '0' => 'JSON'
];
$typeName='';

if($_POST['change_type_name2']){
    $typeName = $_POST['change_type_name'];
    $long = $_POST['long'];
    try {
        $db = new DB($db_host, $db_user, $db_password, $db_name);
        $db->query("ALTER TABLE `$nameGet` CHANGE name name $typeName($long) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;");
    } catch (Exception $e) {
        echo $e->getMessage() . ':(';
    }
}
if($_POST['change_type_age2']){
    $typeName = $_POST['change_type_age'];
    $long = $_POST['long'];
    try {
        $db = new DB($db_host, $db_user, $db_password, $db_name);
        $db->query("ALTER TABLE `$nameGet` CHANGE age age $typeName($long) NULL DEFAULT NULL;");
    } catch (Exception $e) {
        echo $e->getMessage() . ':(';
    }
}
if($_POST['change_type_phone2']){
    $typeName = $_POST['change_type_phone'];
    $long = $_POST['long'];
    try {
        $db = new DB($db_host, $db_user, $db_password, $db_name);
        $db->query("ALTER TABLE `$nameGet` CHANGE phone phone $typeName($long) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;");
    } catch (Exception $e) {
        echo $e->getMessage() . ':(';
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Просмотр</title>
</head>
<body>
<h2>Таблица <?=$nameGet;?></h2>
<table border="1">
    <tr>
        <th>id</th>
        <th>name</th>
        <th>age</th>
        <th>phone</th>
    </tr>
    <?php
    foreach ($tables as $table) {
        ?>
        <tr>
            <td><?=$table['id'];?></td>
            <td><?=$table['name'];?></td>
            <td><?=$table['age'];?></td>
            <td><?=$table['phone'];?></td>
        </tr>
        <?php
    }
    ?>
</table>
<h3>Форма для изменения таблицы</h3>
<form method="POST">
    Выберите:
    <select name="change_id">
        <?php
        foreach ($tables as $table) {
            ?>
            <option value="<?= $table['id']; ?>"><?= $table['id']; ?></option>
            <?php
        }
        ?>
    </select> <b>id</b> <input type="submit" name="del" value="Удалить"><br>
    <input type="text" name="name" placeholder="изменить колонку name"><br>
    <form method="POST">
        <b>Тип:</b>
        <select name="change_type_name">
            <?php
            foreach ($types as $type) {
                ?>
                <option value="<?= $type; ?>"><?= $type; ?></option>
                <?php
            }
            ?>
            <optgroup label="Числовые">
            <?php
            foreach ($typeInt as $type) {
                ?>
                <option value="<?= $type; ?>"><?= $type; ?></option>
                <?php
            }
            ?>
            </optgroup>
            <optgroup label="Дата и время">
                <?php
                foreach ($typeDate as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Символьные">
                <?php
                foreach ($typeSymbol as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Пространственные">
                <?php
                foreach ($typeSpace as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="JSON">
                <?php
                foreach ($typeJson as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
        </select>
        <input type="text" name="long" placeholder="Длина значений:">
        <input type="submit" name="change_type_name2" value="Изменить">
    </form>
    <input type="text" name="age" placeholder="изменить колонку age">
    <form method="POST">
        <b>Тип:</b>
        <select name="change_type_age">
            <?php
            foreach ($types as $type) {
                ?>
                <option value="<?= $type; ?>"><?= $type; ?></option>
                <?php
            }
            ?>
            <optgroup label="Числовые">
                <?php
                foreach ($typeInt as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Дата и время">
                <?php
                foreach ($typeDate as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Символьные">
                <?php
                foreach ($typeSymbol as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Пространственные">
                <?php
                foreach ($typeSpace as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="JSON">
                <?php
                foreach ($typeJson as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
        </select>
        <input type="text" name="long" placeholder="Длина значений:">
        <input type="submit" name="change_type_age2" value="Изменить">
    </form>
    <input type="text" name="phone" placeholder="изменить колонку phone">
    <form method="POST">
        <b>Тип:</b>
        <select name="change_type_phone">
            <?php
            foreach ($types as $type) {
                ?>
                <option value="<?= $type; ?>"><?= $type; ?></option>
                <?php
            }
            ?>
            <optgroup label="Числовые">
                <?php
                foreach ($typeInt as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Дата и время">
                <?php
                foreach ($typeDate as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Символьные">
                <?php
                foreach ($typeSymbol as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="Пространственные">
                <?php
                foreach ($typeSpace as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
            <optgroup label="JSON">
                <?php
                foreach ($typeJson as $type) {
                    ?>
                    <option value="<?= $type; ?>"><?= $type; ?></option>
                    <?php
                }
                ?>
            </optgroup>
        </select>
        <input type="text" name="long" placeholder="Длина значений:">
        <input type="submit" name="change_type_phone2" value="Изменить">
    </form>
    <br>
    <input type="submit" name="change" value="Изменить">
</form>
</body>
</html>
