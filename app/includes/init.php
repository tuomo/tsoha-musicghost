<?php

function requireLoggedIn()
{
    $loggedIn = A('session/logged_in', false);
    if (!$loggedIn) {
        Atomik::redirect('@login');
        Atomik::end();
    }
}

require_once('db.php');

$logo = Atomik::appAsset('assets/images/logo.png');
$loggedIn = A('session/logged_in', false);
$name = A('config/name');

?>
