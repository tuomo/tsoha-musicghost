<?php

require_once('init.php');

$stm = $db->query(
    'SELECT a.name, r.id, r.title, r.first_year, r.format '.
    'FROM artist a, record r WHERE a.id = r.artist'
);

$records = $stm->fetchAll();

foreach ($records as &$record) {
    $id = $record['id'];
    $url = Atomik::url('@info', array('id' => $id));
    $record['url'] = $url;
}
unset($record);

?>
