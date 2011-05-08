<?php

require_once('init.php');
require_once('form.php');

require_logged_in();

Atomik::setView('addedit');

$operation = A('request/operation');

$values['lists'] = $db->query('SELECT name AS id, name FROM list')->fetchAll();
$values['artist'] = $db->query('SELECT id, name FROM artist ORDER BY sortname')->fetchAll();
$boxsets = $db->query(
    'SELECT a.name, r.id, r.title '.
    'FROM artist a, record r WHERE r.box_set IS TRUE AND a.id = r.artist '.
    'ORDER BY a.sortname, r.title'
)->fetchAll();
$values['boxset'] = array();
foreach ($boxsets as $b) {
    $name = $b['name'].' - '.$b['title'];
    $values['boxset'][] = array('id' => $b['id'], 'name' => $name);
}
$values['type'] = $db->query('SELECT name AS id, name FROM type')->fetchAll();
$values['format'] = $db->query('SELECT name AS id, name FROM format')->fetchAll();
$values['packaging'] = $db->query('SELECT name AS id, name FROM packaging')->fetchAll();
$values['label'] = $db->query('SELECT id, name FROM label ORDER BY name')->fetchAll();

$values = escape_values($values);

$empty = array('id' => NULL, 'name' => NULL);

$lists = $values['lists'];
$artists = array_merge(array($empty), $values['artist']);
$boxsets = array_merge(array($empty), $values['boxset']);
$types = array_merge(array($empty), $values['type']);
$formats = array_merge(array($empty), $values['format']);
$packagings = array_merge(array($empty), $values['packaging']);
$labels = array_merge(array($empty), $values['label']);

$old_lists = NULL;
$old_artist = NULL;
$old_title = NULL;
$old_boxset = 'normal';
$old_boxid = NULL;
$old_type = NULL;
$old_first_year = NULL;
$old_this_year = NULL;
$old_format = NULL;
$old_packaging = NULL;
$old_label = NULL;
$old_limited = FALSE;
$old_ltd_num = NULL;
$old_added = NULL;
$old_lent = FALSE;
$old_borrower = NULL;
$old_annotation = NULL;

if ($operation === 'add') {

    $heading = 'Add a new record';
    $action = Atomik::url('@add');

} else {

    $id = A('request/id');

    $heading = 'Edit a record';
    $action = Atomik::url('@edit', array('id' => $id));

    $rows = $db->query(
        'SELECT list FROM record_list WHERE record = ?',
        array($id)
    )->fetchAll();

    foreach ($rows as $r) {
        $old_lists[] = Atomik::escape($r['list']);
    }

    $row = $db->query(
        'SELECT a.id AS artist, l.id AS label, r.title, r.box_set, r.box_id, '.
        'r.type, r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
        'r.ltd_num, r.added, r.lent, r.borrower, r.annotation '.
        'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
        'WHERE a.id = r.artist AND r.id = ?',
        array($id)
    )->fetch();

    $old_artist = $row['artist'];
    $old_title = Atomik::escape($row['title']);
    if ($row['box_set']) {
        $old_boxset = 'boxset';
    } elseif (!is_null($row['box_id'])) {
        $old_boxset = 'item';
        $old_boxid = $row['box_id'];
    }
    $old_type = Atomik::escape($row['type']);
    $old_first_year = $row['first_year'];
    $old_this_year = $row['this_year'];
    $old_format = Atomik::escape($row['format']);
    $old_packaging = Atomik::escape($row['packaging']);
    $old_label = $row['label'];
    $old_limited = $row['limited'];
    $old_ltd_num = $row['ltd_num'];
    $old_added = $row['added'];
    $old_lent = $row['lent'];
    $old_borrower = Atomik::escape($row['borrower']);
    $old_annotation = Atomik::escape($row['annotation']);

}

?>
