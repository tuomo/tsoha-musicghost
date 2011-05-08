<?php

require_once('init.php');
require_once('form.php');

require_logged_in();

$tab = A('request/tab');

$tabs = array(
    array('id' => 'artists', 'name' => 'Artists'),
    array('id' => 'labels', 'name' => 'Labels'),
);

$action = Atomik::url('@control', array('tab' => $tab));

$new = array('id' => '-1', 'name' => '[Add new]');

switch ($tab) {
case 'artists':
    $values['artist'] = $db->query('SELECT id, name FROM artist ORDER BY sortname')->fetchAll();
    $values = escape_values($values);
    $form_values = array_merge(array($new), $values['artist']);
    break;

case 'labels':
    $values['label'] = $db->query('SELECT id, name FROM label ORDER BY name')->fetchAll();
    $values = escape_values($values);
    $form_values = array_merge(array($new), $values['label']);
    break;
}

$form_selected = -1;
$form_name = NULL;
$form_sortname = NULL;
$form_homepage = NULL;
$form_annotation = NULL;

?>
