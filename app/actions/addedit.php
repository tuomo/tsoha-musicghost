<?php

require_once('init.php');

require_logged_in();

Atomik::setView('addedit');

$operation = A('request/operation');

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

$artists = array_merge(array($empty), $values['artist']);
$boxsets = array_merge(array($empty), $values['boxset']);
$types = array_merge(array($empty), $values['type']);
$formats = array_merge(array($empty), $values['format']);
$packagings = array_merge(array($empty), $values['packaging']);
$labels = array_merge(array($empty), $values['label']);

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

    $old = $db->query(
        'SELECT a.id AS artist, l.id AS label, r.title, r.box_set, r.box_id, '.
        'r.type, r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
        'r.ltd_num, r.added, r.lent, r.borrower, r.annotation '.
        'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
        'WHERE a.id = r.artist AND r.id = ?',
        array($id)
    )->fetch();

    $old_artist = $old['artist'];
    $old_title = Atomik::escape($old['title']);
    if ($old['box_set']) {
        $old_boxset = 'boxset';
    } elseif (!is_null($old['box_id'])) {
        $old_boxset = 'item';
        $old_boxid = $old['box_id'];
    }
    $old_type = Atomik::escape($old['type']);
    $old_first_year = $old['first_year'];
    $old_this_year = $old['this_year'];
    $old_format = Atomik::escape($old['format']);
    $old_packaging = Atomik::escape($old['packaging']);
    $old_label = $old['label'];
    $old_limited = $old['limited'];
    $old_ltd_num = $old['ltd_num'];
    $old_added = $old['added'];
    $old_lent = $old['lent'];
    $old_borrower = Atomik::escape($old['borrower']);
    $old_annotation = Atomik::escape($old['annotation']);

}

function escape_values($values)
{
    $result = array();
    foreach ($values as $key => $val) {
        $esc_val = array();
        foreach ($val as $item) {
            $id = Atomik::escape($item['id']);
            $name = Atomik::escape($item['name']);
            $esc_val[] = array('id' => $id, 'name' => $name);
        }
        $result[$key] = $esc_val;
    }
    return $result;
}

?>
