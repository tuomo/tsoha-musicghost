<?php

require('init.php');

requireLoggedIn();

$artists = getDbColumn($_db, 'name', 'artist', 'sortname');

$types = array(
    'album', 'single', 'EP', 'compilation',
    'soundtrack', 'interview', 'live', 'other'
);

$formats = getDbColumn($_db, 'name', 'format');
$packagings = getDbColumn($_db, 'name', 'packaging');

?>
