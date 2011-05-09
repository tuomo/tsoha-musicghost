<?php

function boxitems($record, $field)
{
    $str = '';
    if (isset($record['items'])) {
        foreach ($record['items'] as $item) {
            $str .= '<br />&nbsp;&nbsp;';
            if ($field == 'title') {
                $str .= '<a href="';
                $str .= Atomik::url('@details', array('id' => $item['id']));
                $str .= '" class="boxitem">'.$item['title'].'</a>';
            } else {
                $str .= '<span class="boxitem">'.$item[$field].'</span>';
            }
        }
    }
    return $str;
}

?>
