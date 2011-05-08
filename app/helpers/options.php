<?php

function options($options, $selected_id)
{
    $str = '';
    foreach ($options as $o) {
        $str .= "<option value=\"{$o['id']}\"";
        if ($selected_id == $o['id']) $str .= ' selected="selected"';
        $str .= ">{$o['name']}</option>\n";
    }
    return $str;
}

?>
