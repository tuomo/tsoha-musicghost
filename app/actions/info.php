<?php

require('session.php');

$_id = A('request/id');

$_stm = A('db:SELECT r.title, a.name AS artist, r.first_year, r.type, '.
    'r.format, r.annotation FROM artist a, record r '.
    'WHERE a.id = r.artist AND r.id = ? ', array($_id));

$record = $_stm->fetch();
