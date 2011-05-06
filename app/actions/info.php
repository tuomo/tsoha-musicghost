<?php

require_once('init.php');

$_id = A('request/id');

$record = $_db->query(
    'SELECT a.name AS artist, l.name AS label, r.title, r.box_set, r.box_id, r.type, '.
    'r.first_year, r.this_year, r.format, r.packaging, r.limited, '.
    'r.ltd_num, r.added, r.lent, r.borrower, r.annotation '.
    'FROM artist a, record r LEFT OUTER JOIN label l ON (l.id = r.label) '.
    'WHERE a.id = r.artist AND r.id = ?',
    array($_id)
)->fetch();

$record['id'] = $_id;

?>
