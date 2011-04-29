<?php

/*
function getDbColumn($db, $column, $table, $sortcolumn = NULL)
{
    if (is_null($sortcolumn)) {
        $sortcolumn = $column;
    }

    // FIXME
    //$result = $db->query('SELECT ? FROM ? ORDER BY ?', array('name', 'format', 'name'));
    $result = $db->query("SELECT $column FROM $table ORDER BY $sortcolumn");

    $rows = array();

    foreach($result as $row) {
        $rows[] = $row[$column];
    }

    return $rows;
}
*/

require('config.user.php');

$_dsn = 'pgsql:host='.A('config/db/host').';dbname='.A('config/db/dbname');
$_user = A('config/db/user');
$_pass = A('config/db/pass');

$_db = Atomik_Db::createInstance('db', $_dsn, $_user, $_pass);

$_db->connect();
$_db->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
