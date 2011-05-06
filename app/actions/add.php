<?php

require_once('init.php');

require_logged_in();

$artists = $_db->query('SELECT id, name FROM artist ORDER BY sortname')
    ->fetchAll();

$_boxsets = $_db->query(
    'SELECT a.id AS a_id, a.name, r.id AS r_id, r.title '.
    'FROM artist a, record r WHERE r.box_set IS TRUE AND a.id = r.artist '.
    'ORDER BY a.sortname, r.title'
)->fetchAll();
$boxsets = array();
foreach ($_boxsets as $_bs) {
    $_id = $_bs['a_id'].'#'.$_bs['r_id'];
    $_name = $_bs['name'].' - '.$_bs['title'];
    $boxsets[] = array('id' => $_id, 'name' => $_name);
}

$types = $_db->query('SELECT name FROM type')->fetchAll();

$formats = $_db->query('SELECT name FROM format')->fetchAll();

$packagings = $_db->query('SELECT name FROM packaging')->fetchAll();

$labels = $_db->query('SELECT id, name FROM label ORDER BY name')->fetchAll();

?>
