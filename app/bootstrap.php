<?php

require('config.user.php');

$loggedIn = A('session/logged_in', false);

$_dsn = 'pgsql:host='.A('config/db/host').';dbname='.A('config/db/dbname');
$_user = A('config/db/user');
$_pass = A('config/db/pass');

$_db = Atomik_Db::createInstance('db', $_dsn, $_user, $_pass);

$_db->connect();
$_db->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
