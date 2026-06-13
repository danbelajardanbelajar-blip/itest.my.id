<?php
require __DIR__ . '/../config/database.php';
require __DIR__ . '/../app/core/Database.php';
$db = new Database();
$db->query("SHOW TABLES");
$tables = $db->resultSet();
foreach($tables as $t) {
    $tableName = array_values((array)$t)[0];
    echo "TABLE: " . $tableName . "\n";
    $db->query("DESCRIBE " . $tableName);
    $cols = $db->resultSet();
    foreach($cols as $c) {
        echo " - " . $c->Field . " (" . $c->Type . ")\n";
    }
}
