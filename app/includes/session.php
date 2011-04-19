<?php

if (A('session/logged_in', false)) {
    $logged_in = true;
}
else {
    $logged_in = false;
}
