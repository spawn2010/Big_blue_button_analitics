<?php

$allFiles = glob(BASE_DIR . 'app/Modules/*/init.php');

foreach ($allFiles as $file) {
    require $file;
}
