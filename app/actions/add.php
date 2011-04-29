<?php

require('init.php');

requireLoggedIn();

$artists = getDbColumn($_db, 'name', 'artist', 'sortname');
$types = getDbColumn($_db, 'name', 'type');
$formats = getDbColumn($_db, 'name', 'format');
$packagings = getDbColumn($_db, 'name', 'packaging');

?>
