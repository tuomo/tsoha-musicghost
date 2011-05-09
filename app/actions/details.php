<?php

require_once('init.php');

$id = A('request/id');

$record = $db->query(
    'SELECT a.name AS artist, l.name AS label, r.title, r.box_set, r.box_id, r.type, '.
    'r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
    'r.ltd_num, r.added, r.lent, r.borrower, r.annotation, '.
    'a.homepage AS artist_homepage, a.annotation AS artist_annotation, '.
    'l.homepage AS label_homepage, l.annotation AS label_annotation, r.cover '.
    'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
    'WHERE a.id = r.artist AND r.id = ?',
    array($id)
)->fetch();

$record['id'] = $id;
$record['cover'] = isset($record['cover'])
    ? Atomik::appAsset('artwork/'.$record['cover'])
    : Atomik::appAsset('assets/images/sampleimage.png');

?>
