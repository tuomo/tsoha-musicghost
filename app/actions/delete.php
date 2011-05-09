<?php

require_once('init.php');

require_logged_in();

$id = A('request/id');
$db->delete('record', array('id' => $id));

Atomik::redirect('@front');

?>

