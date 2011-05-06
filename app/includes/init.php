<?php

function require_logged_in()
{
    $logged_in = A('session/logged_in', false);
    if (!$logged_in) {
        Atomik::redirect('@login');
        Atomik::end();
    }
}

require_once('db.php');

$logo = Atomik::appAsset('assets/images/logo.png');
$logged_in = A('session/logged_in', false);
$name = A('config/name');

?>
