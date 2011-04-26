<?php

require('session.php');

$_id = A('request/id');

$debug[1] = Atomik_Db::delete('record', array('id' => $_id));

Atomik::redirect('index');

?>

