<?php

$records = A('db:SELECT a.name, r.title, r.first_year, r.format '.
             'FROM artist a, record r WHERE a.id = r.artist');
