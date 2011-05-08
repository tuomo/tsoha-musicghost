<?php

function escape_values($values)
{
    $result = array();
    foreach ($values as $key => $val) {
        $esc_val = array();
        foreach ($val as $item) {
            $id = Atomik::escape($item['id']);
            $name = Atomik::escape($item['name']);
            $esc_val[] = array('id' => $id, 'name' => $name);
        }
        $result[$key] = $esc_val;
    }
    return $result;
}

?>
