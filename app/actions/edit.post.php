<?php
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $year = $_POST['year'];
    $type = $_POST['type'];
    $format = $_POST['format'];
    $packaging = $_POST['packaging'];
    $annotation = $_POST['annotation'];
    if ($_POST['lent'] = 'checked') {
        $lent = 'true';
    }
    else {
        $lent = 'false';
    }
    $borrower = $_POST['borrower'];    
    $_id = $_POST['id'];
    
    if ($

// lomakekenttien tarkistus

    $artist_id = 0;
    if ($result = Atomik_db::find('artist', array('name' => $artist))) {
        $row = $result->fetch();
        $artist_id = $row['id'];
    }
    else {
        $result = Atomik_db::query('INSERT INTO artist (name, sortname) VALUES (?, ?) '.
            'RETURNING id', array($artist, $artist));
        $row = $result->fetch();
        $artist_id = $row['id'];
    }

    $debug[1] = Atomik_Db::update('record', array('title' => $title, 'artist' => $artist_id,
        'first_year' => $year, 'type' => $type, 'annotation' => $annotation,
        'box_status' => 'normal', 'lent' => $lent), array('id' => $_id));

    Atomik::redirect('index');
?>
