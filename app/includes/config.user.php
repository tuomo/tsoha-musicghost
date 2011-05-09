<?php

Atomik::set('config', array(

    // Name of the owner
    'name' => 'ExampleOwner',

    // Password to modify the collection
    'password' => 'examplepass',

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

Atomik::set('atomik/url_rewriting', TRUE);

?>
