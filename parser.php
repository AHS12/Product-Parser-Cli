<?php


//it is a cli application
if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\App;


$app = new App();

try {
    //code...
    $app->runCommand($argv);
    
} catch (\Throwable $th) {
    //throw $th;
    $app->getPrinter()->display($th->getMessage());
}

