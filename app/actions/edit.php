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

$_id = A('request/id');

$record = $_db->query(
    'SELECT a.name AS artist, a.id AS artist_id, l.name AS label, l.id AS label_id, r.title, r.box_set, r.box_id, r.type, '.
    'r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
    'r.ltd_num, r.added, r.lent, r.borrower, r.annotation '.
    'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
    'WHERE a.id = r.artist AND r.id = ?',
    array($_id)
)->fetch();

$record['id'] = $_id;
    
?>