<?php

namespace Src;

class Template
{
    public static function getTmpl(string $_file, $data = [])
    {
        $out = '';

        if (file_exists($_file)) {
            extract($data);
            ob_start();
            require $_file;
            $out = ob_get_contents();
            if (ob_get_length()) ob_end_clean();
        }

        return $out;
    }
}