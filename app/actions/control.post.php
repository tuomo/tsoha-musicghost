<?php

require_once('init.php');

$entry = $_POST['entry'];
$name = $_POST['name'];
$homepage = $_POST['homepage'];
$annotation = $_POST['annotation'];

$form_selected = $entry;
$form_name = $name;
$form_homepage = $homepage;
$form_annotation = $annotation;

switch ($tab) {
case 'artists':
    $sortname = empty($_POST['sortname']) ? $name : $_POST['sortname'];
    $form_sortname = $sortname;

    if ($_POST['submit'] == 'Delete') {
        $used = $db->count('record', array('artist' => $entry));
        if ($used > 0) {
            Atomik::flash('You must first delete all records with this artist', 'error');
        } else {
            $db->delete('artist', array('id' => $entry));
        }
    } elseif ($_POST['submit'] == 'Save') {

        if (empty($name)) {
            Atomik::flash('A name is required', 'error');
        } else {

            $db_val['name'] = $name;
            $db_val['sortname'] = $sortname;
            if (!empty($homepage)) {
                $db_val['homepage'] = $homepage;
            }
            if (!empty($annotation)) {
                $db_val['annotation'] = $annotation;
            }

            if ($entry == -1) {
                $db->insert('artist', $db_val);
                $id = $db->pdo->lastInsertId('artist_id_seq');
                $form_selected = $id;
            } else {
                $db->update('artist', $db_val, array('id' => $entry));
            }

        }

    } elseif ($entry >= 0) { // Show
        $row = $db->query(
            'SELECT name, sortname, homepage, annotation '.
            'FROM artist WHERE id = ?',
            array($entry)
        )->fetch();
        $form_name = $row['name'];
        $form_sortname = $row['sortname'];
        $form_homepage = $row['homepage'];
        $form_annotation = $row['annotation'];
    } else {
        $form_name = NULL;
        $form_sortname = NULL;
        $form_homepage = NULL;
        $form_annotation = NULL;
    }
    break;

case 'labels':
    if ($_POST['submit'] == 'Delete') {
        $db->delete('label', array('id' => $entry));
    } elseif ($_POST['submit'] == 'Save') {

        if (empty($name)) {
            Atomik::flash('A name is required', 'error');
        } else {

            $db_val['name'] = $name;
            if (!empty($homepage)) {
                $db_val['homepage'] = $homepage;
            }
            if (!empty($annotation)) {
                $db_val['annotation'] = $annotation;
            }

            if ($entry == -1) {
                $db->insert('label', $db_val);
                $id = $db->pdo->lastInsertId('label_id_seq');
                $form_selected = $id;
            } else {
                $db->update('label', $db_val, array('id' => $entry));
            }

        }

    } elseif ($entry >= 0) { // Show
        $row = $db->query(
            'SELECT name, homepage, annotation '.
            'FROM label WHERE id = ?',
            array($entry)
        )->fetch();
        $form_name = $row['name'];
        $form_homepage = $row['homepage'];
        $form_annotation = $row['annotation'];
    } else {
        $form_name = NULL;
        $form_homepage = NULL;
        $form_annotation = NULL;
    }
    break;
}

?>
