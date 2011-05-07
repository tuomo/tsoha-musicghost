<?php

require_once('init.php');
require_once('addedit.php');

require_logged_in();

Atomik::setView('addedit');

$_operation = A('request/operation');

$_values = get_record_field_values($_db);
$_empty = array('id' => NULL, 'name' => NULL);

$artists = array_merge(array($_empty), $_values['artist']);
$boxsets = array_merge(array($_empty), $_values['boxset']);
$types = array_merge(array($_empty), $_values['type']);
$formats = array_merge(array($_empty), $_values['format']);
$packagings = array_merge(array($_empty), $_values['packaging']);
$labels = array_merge(array($_empty), $_values['label']);

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

if ($_operation === 'add') {

    $heading = 'Add a new record';
    $action = Atomik::url('@add');

} else {

    $_id = A('request/id');

    $heading = 'Edit a record';
    $action = Atomik::url('@edit', array('id' => $_id));

    $old = $_db->query(
        'SELECT a.id AS artist, l.id AS label, r.title, r.box_set, r.box_id, '.
        'r.type, r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
        'r.ltd_num, r.added, r.lent, r.borrower, r.annotation '.
        'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
        'WHERE a.id = r.artist AND r.id = ?',
        array($_id)
    )->fetch();

    $old_artist = $old['artist'];
    $old_title = $old['title'];
    if ($old['box_set']) {
        $old_boxset = 'boxset';
    } elseif (!is_null($old['box_id'])) {
        $old_boxset = 'item';
        $old_boxid = $old['box_id'];
    }
    $old_type = $old['type'];
    $old_first_year = $old['first_year'];
    $old_this_year = $old['this_year'];
    $old_format = $old['format'];
    $old_packaging = $old['packaging'];
    $old_label = $old['label'];
    $old_limited = $old['limited'];
    $old_ltd_num = $old['ltd_num'];
    $old_added = $old['added'];
    $old_lent = $old['lent'];
    $old_borrower = $old['borrower'];
    $old_annotation = $old['annotation'];

}

?>
