<?php

Atomik::set('config', array(

    // Name of the owner
    'name' => 'Example',

    // Password to modify the collection
    'password' => 'example',

    // Database settings
    'db' => array(
        'host' => 'localhost',
        'user' => 'tuomo',
        'pass' => '',
        'dbname' => 'musicghost'
    ),

    // Resize album cover images (needs the Imagick extension)
    'resize' => TRUE,

));

?>
