<?php

require('init.php');

if (isset($_POST['submit']))
{
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($password == A('config/password')) {
        Atomik::set('session/logged_in', true);
        Atomik::redirect('index');
    }
}
