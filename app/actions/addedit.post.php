<?php

require_once('init.php');

require_logged_in();

Atomik::set('app/filters/default_message', 'Field "%s" has an invalid value');
Atomik::set('app/filters/required_message', 'Required field "%s" is empty');

$rule = array(
    'lists' => array(
        'filter' => FILTER_UNSAFE_RAW,
        'required' => TRUE
    ),
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

$error = FALSE;

// FIXME
$lst = $_POST['lists'];

if (($data = Atomik::filter($_POST, $rule)) === false) {
    Atomik::flash(A('app/filters/messages'), 'error');
    $error = TRUE;
}
if (!validate_id($data['lists'], $values['lists'])) {
    Atomik::flash('Invalid list', 'error');
    $error = TRUE;
}
if (!validate_id($data['artist'], $values['artist'])) {
    Atomik::flash('Invalid artist', 'error');
    $error = TRUE;
}
if (!validate_id($data['boxid'], $values['boxset'])) {
    Atomik::flash('Invalid box set', 'error');
    $error = TRUE;
}
if (!validate_id($data['type'], $values['type'])) {
    Atomik::flash('Invalid type', 'error');
    $error = TRUE;
}
if (!validate_id($data['format'], $values['format'])) {
    Atomik::flash('Invalid format', 'error');
    $error = TRUE;
}
if (!validate_id($data['packaging'], $values['packaging'])) {
    Atomik::flash('Invalid packaging', 'error');
    $error = TRUE;
}
if (!validate_id($data['label'], $values['label'])) {
    Atomik::flash('Invalid label', 'error');
    $error = TRUE;
}

$data['lists'] = $lst;

if ($error) {

    $old_lists = isset($_POST['lists']) ? $_POST['lists'] : NULL;
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

    $db_val['artist'] = $data['artist'];
    $db_val['title'] = $data['title'];
    if ($data['boxset'] === 'boxset') {
        $db_val['box_set'] = 'TRUE';
    } elseif ($data['boxset'] === 'item') {
        $db_val['box_set'] = 'FALSE';
        $db_val['box_id'] = $data['boxid'];
    } else {
        $db_val['box_set'] = 'FALSE';
    }
    $db_val['type'] = $data['type'];
    if (isset($data['first_year'])) {
        $db_val['first_year'] = $data['first_year'];
    }
    if (isset($data['this_year'])) {
        $db_val['this_year'] = $data['this_year'];
    }
    if (isset($data['format'])) {
        $db_val['format'] = $data['format'];
    }
    if (isset($data['packaging'])) {
        $db_val['packaging'] = $data['packaging'];
    }
    if (isset($data['label'])) {
        $db_val['label'] = $data['label'];
    }
    if (isset($data['limited'])) {
        $db_val['limited'] = 'TRUE';
        if (isset($data['ltd_num'])) {
            $db_val['ltd_num'] = $data['ltd_num'];
        }
    }
    if (isset($data['added'])) {
        $db_val['added'] = $data['added'];
    }
    if (isset($data['lent'])) {
        $db_val['lent'] = 'TRUE';
        if (isset($data['borrower'])) {
            $db_val['borrower'] = $data['borrower'];
        }
    } else {
        $db_val['lent'] = 'FALSE';
    }
    if (isset($data['annotation'])) {
        $db_val['annotation'] = $data['annotation'];
    }

    $operation = A('request/operation');

    if ($operation === 'add') {
        Atomik_Db::insert('record', $db_val);
        $id = $db->pdo->lastInsertId('record_id_seq');
    } else {
        Atomik_Db::update('record', $db_val, array('id' => $id));
    }

    $db->delete('record_list', array('record' => $id));
    foreach ($data['lists'] as $l) {
        $db->insert('record_list', array('record' => $id, 'list' => $l));
    }

    Atomik::redirect(Atomik::url('@info', array('id' => $id)), FALSE);
}

function validate_id($ids, $values, $null=TRUE)
{
    if ($null && is_null($ids)) {
        return TRUE;
    }

    if (!is_array($ids)) {
        $ids = array($ids);
    }

    $all_found = TRUE;
    foreach ($ids as $id) {
        $found = FALSE;
        foreach ($values as $v) {
            if ($id == $v['id']) {
                $found = TRUE;
                break;
            }
        }
        if (!$found) {
            $all_found = FALSE;
            break;
        }
    }

    return $all_found;
}

?>
