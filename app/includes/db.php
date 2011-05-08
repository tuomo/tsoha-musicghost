<?php

require('config.user.php');

$dsn = 'pgsql:host='.A('config/db/host').';dbname='.A('config/db/dbname');
$user = A('config/db/user');
$pass = A('config/db/pass');

$db = Atomik_Db::createInstance('db', $dsn, $user, $pass);

$db->connect();
$db->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
