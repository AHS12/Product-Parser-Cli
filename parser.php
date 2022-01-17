<?php


//it is a cli application
if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\App;


$app = new App();


$app->runCommand($argv);
