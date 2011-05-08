<?php

function errors()
{
    $str = '';
    $errors = A('flash:error');
    if (count($errors) > 0) {
        $str .= '<p>The following errors were detected:</p><ul>';
        foreach ($errors as $msg) {
            $str .= "<li>$msg</li>";
        }
        $str .= '</ul>';
    }
    return $str;
}

?>

