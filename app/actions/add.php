<?php

require('init.php');

requireLoggedIn();

$artists = $_db->query('SELECT id, name FROM artist ORDER BY sortname')
    ->fetchAll();

$_boxsets = $_db->query(
    'SELECT a.id, a.name, r.id, r.title FROM artist a, record r '.
    'WHERE a.id = r.artist ORDER BY a.sortname, r.title'
)->fetchAll();
$boxsets = array();
foreach ($_boxsets as $_bs) {
    $_id = $_bs['a.id'].'#'.$_bs['r.id'];
    $_name = $_bs['a.name'].' - '.$_bs['r.title'];
    $boxsets[] = array('id' => $_id, 'name' => $_name);
}

$types = $_db->query('SELECT name FROM type')->fetchAll();

$formats = $_db->query('SELECT name FROM format')->fetchAll();

$packagings = $_db->query('SELECT name FROM packaging')->fetchAll();

$labels = $_db->query('SELECT id, name FROM label ORDER BY name')->fetchAll();

?>
