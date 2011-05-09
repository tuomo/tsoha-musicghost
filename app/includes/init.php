<?php

require_once('config.user.php');

$dsn = 'pgsql:host='.A('config/db/host').';dbname='.A('config/db/dbname');
$user = A('config/db/user');
$pass = A('config/db/pass');

$db = Atomik_Db::createInstance('db', $dsn, $user, $pass);

$db->connect();
$db->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$logged_in = A('session/logged_in', false);
$logo = Atomik::appAsset('assets/images/logo.png');
$name = A('config/name');

function require_logged_in()
{
    $logged_in = A('session/logged_in', false);
    if (!$logged_in) {
        Atomik::redirect('@login');
        Atomik::end();
    }
}

?>
