<?php 
// web/index.php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
//	print_r($filename);
    return false;
}

require __DIR__.'/../etc/app.php';

$app->run();

?>