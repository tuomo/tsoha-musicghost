<?php

require_once('init.php');

require_logged_in();

Atomik::set('app/filters/default_message', 'Field "%s" has an invalid value');
Atomik::set('app/filters/required_message', 'Required field "%s" is empty');

$_rule = array(
    'artist' => array(
        'filter' => FILTER_VALIDATE_INT,
        'required' => TRUE
    ),
    'title' => array(
        'filter' => FILTER_UNSAFE_RAW,
        'required' => TRUE
    ),
    'boxset' => array(
        'filter' => '/normal|boxset|item/',
        'required' => TRUE
    ),
    'boxid' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'type' => array(
        'filter' => FILTER_UNSAFE_RAW,
        'required' => TRUE
    ),
    'first_year' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'this_year' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'format' => array(
        'filter' => FILTER_UNSAFE_RAW
    ),
    'packaging' => array(
        'filter' => FILTER_UNSAFE_RAW
    ),
    'label' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'limited' => array(
        'filter' => '/limited/'
    ),
    'ltd_num' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'added' => array(
        'filter' => '/\d{4}-\d{2}-\d{2}/'
    ),
    'lent' => array(
        'filter' => '/lent/'
    ),
    'borrower' => array(
        'filter' => FILTER_UNSAFE_RAW
    ),
    'annotation' => array(
        'filter' => FILTER_UNSAFE_RAW
    ),
);

// FIXME
$_values['artist'] = Atomik_Db::query('SELECT id, name FROM artist ORDER BY sortname')->fetchAll();
$_boxsets = Atomik_Db::query(
    'SELECT a.name, r.id, r.title '.
    'FROM artist a, record r WHERE r.box_set IS TRUE AND a.id = r.artist '.
    'ORDER BY a.sortname, r.title'
)->fetchAll();
$_values['boxset'] = array();
foreach ($_boxsets as $_b) {
    $_name = $_b['name'].' - '.$_b['title'];
    $_values['boxset'][] = array('id' => $_b['id'], 'name' => $_name);
}
$_values['type'] = Atomik_Db::query('SELECT name AS id, name FROM type')->fetchAll();
$_values['format'] = Atomik_Db::query('SELECT name AS id, name FROM format')->fetchAll();
$_values['packaging'] = Atomik_Db::query('SELECT name AS id, name FROM packaging')->fetchAll();
$_values['label'] = Atomik_Db::query('SELECT id, name FROM label ORDER BY name')->fetchAll();

$_error = FALSE;

if (($_data = Atomik::filter($_POST, $_rule)) === false) {
    Atomik::flash(A('app/filters/messages'), 'error');
    $_error = TRUE;
}
if (!validate_id($_data['artist'], $_values['artist'])) {
    Atomik::flash('Invalid artist', 'error');
    $_error = TRUE;
}
if (!validate_id($_data['boxid'], $_values['boxset'])) {
    Atomik::flash('Invalid box set', 'error');
    $_error = TRUE;
}
if (!validate_id($_data['type'], $_values['type'])) {
    Atomik::flash('Invalid type', 'error');
    $_error = TRUE;
}
if (!validate_id($_data['format'], $_values['format'])) {
    Atomik::flash('Invalid format', 'error');
    $_error = TRUE;
}
if (!validate_id($_data['packaging'], $_values['packaging'])) {
    Atomik::flash('Invalid packaging', 'error');
    $_error = TRUE;
}
if (!validate_id($_data['label'], $_values['label'])) {
    Atomik::flash('Invalid label', 'error');
    $_error = TRUE;
}

if ($_error) {

    $old_artist = $_POST['artist'];
    $old_title = $_POST['title'];
    $old_boxset = $_POST['boxset'];
    $old_boxid = $_POST['boxid'];
    $old_type = $_POST['type'];
    $old_first_year = $_POST['first_year'];
    $old_this_year = $_POST['this_year'];
    $old_format = $_POST['format'];
    $old_packaging = $_POST['packaging'];
    $old_label = $_POST['label'];
    $old_limited = isset($_POST['limited']) ? TRUE : FALSE;
    $old_ltd_num = $_POST['ltd_num'];
    $old_added = $_POST['added'];
    $old_lent = isset($_POST['lent']) ? TRUE : FALSE;
    $old_borrower = $_POST['borrower'];
    $old_annotation = $_POST['annotation'];

} else {

    $_db_val['artist'] = $_data['artist'];
    $_db_val['title'] = $_data['title'];
    if ($_data['boxset'] === 'boxset') {
        $_db_val['box_set'] = 'TRUE';
    } elseif ($_data['boxset'] === 'item') {
        $_db_val['box_set'] = 'FALSE';
        $_db_val['box_id'] = $_data['boxid'];
    } else {
        $_db_val['box_set'] = 'FALSE';
    }
    $_db_val['type'] = $_data['type'];
    if (isset($_data['first_year'])) {
        $_db_val['first_year'] = $_data['first_year'];
    }
    if (isset($_data['this_year'])) {
        $_db_val['this_year'] = $_data['this_year'];
    }
    if (isset($_data['format'])) {
        $_db_val['format'] = $_data['format'];
    }
    if (isset($_data['packaging'])) {
        $_db_val['packaging'] = $_data['packaging'];
    }
    if (isset($_data['label'])) {
        $_db_val['label'] = $_data['label'];
    }
    if (isset($_data['limited'])) {
        $_db_val['limited'] = 'TRUE';
        if (isset($_data['ltd_num'])) {
            $_db_val['ltd_num'] = $_data['ltd_num'];
        }
    }
    if (isset($_data['added'])) {
        $_db_val['added'] = $_data['added'];
    }
    if (isset($_data['lent'])) {
        $_db_val['lent'] = 'TRUE';
        if (isset($_data['borrower'])) {
            $_db_val['borrower'] = $_data['borrower'];
        }
    } else {
        $_db_val['lent'] = 'FALSE';
    }
    if (isset($_data['annotation'])) {
        $_db_val['annotation'] = $_data['annotation'];
    }

    $_operation = A('request/operation');

    if ($_operation === 'add') {
        // TODO: get id
        Atomik_Db::insert('record', $_db_val);
        Atomik::redirect('@index');
    } else {
        // FIXME
        $_id = A('request/id');
        Atomik_Db::update('record', $_db_val, array('id' => $_id));
        Atomik::redirect('@info', array('id' => $_id));
    }
}

function validate_id($id, $values)
{
    if (is_null($id)) {
        return TRUE;
    }
    foreach ($values as $v) {
        if ($id === $v['id']) {
            return TRUE;
        }
    }
    return FALSE;
}

?>
