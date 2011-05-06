<?php
    $artist_id = $_POST['artist_id'];
    $title = $_POST['title'];
    if($_POST['boxset'] == 'normal'){
        $box_set = false;
    }
    elseif($_POST['boxset'] == 'boxset'){
        $box_set = true;
    }
    elseif($_POST['boxset'] == 'item'){
        $box_set = false;
        $box_id = $_POST['box_id'];
    }
    $type = $_POST['type'];
    $first_year = $_POST['first_year'];
    $this_year = $_POST['this_year'];
    $format = $_POST['format'];
    $packaging = $_POST['packaging'];
    $label_id = $_POST['label_id'];
    if(empty($_POST['limited'])){
        $limited = false;
    }
    else{
        $limited = true;
    }
    $ltd_num = $_POST['ltd_num'];
    $added = $_POST['added'];
    if(empty($_POST['lent'])){
        $lent = false;
    }
    else{
        $lent = true;
    }
    $borrower = $_POST['borrower'];
    $annotation = $_POST['annotation'];
    $_id = $_POST['id'];

// lomakekenttien tarkistus

    Atomik_Db::update('record', array('artist' => $artist_id, 'title' => $title, 'box_set' => $box_set, 'box_id' => $box_id, 'type' => $type, 'first_year' => $first_year, 'this_year' => $this_year, 'format' => $format, 'packaging' => $packaging, 'label' => $label_id, 'limited' => $limited, 'ltd_num' => $ltd_num, 'added' => $added, 'lent' => $lent, 'borrower' => $borrower, 'annotation' => $annotation), array('id' => $_id));

    Atomik::redirect('index');
?>
