<?php

require('db.php');

$logo = Atomik::appAsset('assets/images/logo.png');
$loggedIn = A('session/logged_in', false);
$name = A('config/name');

?>
