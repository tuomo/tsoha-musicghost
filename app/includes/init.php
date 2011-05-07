<?php

require_once('db.php');

function require_logged_in()
{
    $logged_in = A('session/logged_in', false);
    if (!$logged_in) {
        Atomik::redirect('@login');
        Atomik::end();
    }
}

$logged_in = A('session/logged_in', false);
$logo = Atomik::appAsset('assets/images/logo.png');
$name = A('config/name');

?>
