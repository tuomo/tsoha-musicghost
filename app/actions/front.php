<?php

require_once('init.php');
require_once('form.php');

if ($logged_in) {
    $values['list'] = $db->query('SELECT name AS id, name FROM list')->fetchAll();
} else {
    $values['list'] = $db->query('SELECT name AS id, name FROM list WHERE public = ?', array('TRUE'))->fetchAll();
}
$values['old_list'] = $db->query('SELECT name AS id, name FROM list WHERE "default" = ?', array('TRUE'))->fetchAll();
$values = escape_values($values);
$lists = $values['list'];
$old_list = $values['old_list'][0]['id'];
$old_filter = NULL;

$list = $old_list;
$filter = array();

if (isset($_POST['submit'])) {
    $list = $_POST['list'];
    $filter = explode(' ', $_POST['filter']);
    $old_list = $list;
    $old_filter = $_POST['filter'];
}

$sql = 'SELECT a.name AS artist, r.id, r.title, r.first_year AS year, r.format, r.box_set '.
       'FROM artist a, record r, record_list rl '.
       'WHERE a.id = r.artist AND r.id = rl.record AND rl.list = ? AND box_id IS NULL';
$params = array($list);

foreach ($filter as $word) {
    if (empty($word)) {
        continue;
    }
    $sql .= ' AND (a.name LIKE ? OR r.title LIKE ? OR r.format LIKE ? OR TEXT(r.first_year) LIKE ?)';
    for ($i = 0; $i < 4; $i++) {
        $params[] = "%$word%";
    }
}

$sql .= ' ORDER BY a.name, r.first_year, r.title';

$records = $db->query($sql, $params)->fetchAll();

foreach ($records as &$r) {
    $r['artist'] = Atomik::escape($r['artist']);
    $r['title'] = Atomik::escape($r['title']);
    $r['format'] = Atomik::escape($r['format']);
    $r['url'] = Atomik::url('@details', array('id' => $r['id']));

    if ($r['box_set']) {
        $r['items'] = $db->query(
            'SELECT a.name AS artist, r.id, r.title, r.first_year AS year, r.format '.
            'FROM artist a, record r WHERE a.id = r.artist AND r.box_id = ? '.
            'ORDER BY a.name, r.first_year, r.title',
            array($r['id'])
        )->fetchAll();
    }
}
unset($record);

?>
