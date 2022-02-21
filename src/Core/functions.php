<?php
function getTmpl(string $_file, $data = [])
{
    $out = '';

    if (file_exists($_file)) {
        extract($data);
        ob_start();
        require $_file;
        $out = ob_get_contents(); // получаем данные из буфера

        if (ob_get_length()) ob_end_clean(); // очистили буфер
    }

    return $out;
}
