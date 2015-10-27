
<?php

require join(DIRECTORY_SEPARATOR, array(dirname( __DIR__ ), 'vendor', 'loader.php'));

try {
    Root\System\Application::_start();
} catch (\Exception $e) {
    var_dump($e);
}