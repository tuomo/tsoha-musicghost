<?php

function options($options, $selected)
{
    $str = '';
    foreach ($options as $o) {
        $str .= "<option value=\"{$o['id']}\"";
        if ((is_array($selected) && in_array($o['id'], $selected))
            || (!is_array($selected) && $selected == $o['id'])
        ) {
            $str .= ' selected="selected"';
        }
        $str .= ">{$o['name']}</option>\n";
    }
    return $str;
}

?>
