<?php

Atomik::set(array (
    'app' =>
    array (
        'layout' => '_layout',
        'default_action' => 'index',
        'views' =>
        array (
            'file_extension' => '.phtml',
        ),
    ),
    'atomik' =>
    array (
        'start_session' => true,
        'class_autoload' => true,
        'trigger' => 'action',
        'catch_errors' => true,
        'display_errors' => true,
        'debug' => true,
        //'url_rewriting' => true,
    ),
    'plugins' =>
    array (
        0 => 'Cache',
        1 => 'Db',
    ),
    'style' => 'assets/css/style.css',
));

Atomik::set('app/routes', array(
    'info/:id' => array(
        '@name' => 'info',
        'action' => 'info'
    ),
    'login' => array(
        '@name' => 'login',
        'action' => 'login',
    ),
    'logout' => array(
        '@name' => 'logout',
        'action' => 'logout',
    ),
    'add' => array(
        '@name' => 'add',
        'action' => 'add',
    ),
    'edit/:id' => array(
        '@name' => 'edit',
        'action' => 'edit',
    ),
    'delete/:id' => array(
        '@name' => 'delete',
        'action' => 'delete',
    ),
));

?>
