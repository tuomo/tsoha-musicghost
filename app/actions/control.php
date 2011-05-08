<?php

require_once('init.php');

$tab = A('request/tab');

$tabs = array(
    array('id' => 'artists', 'name' => 'Artists'),
    array('id' => 'labels', 'name' => 'Labels'),
    array('id' => 'types', 'name' => 'Types'),
    array('id' => 'formats', 'name' => 'Formats'),
    array('id' => 'packagings', 'name' => 'Packagings'),
);

$form_name = NULL;
$form_homepage = NULL;
$form_annotation = NULL;

?>
