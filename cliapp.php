<?php


//it is a cli application
if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

use App\App;


$app = new App();


//registry commands for app
// $app->registerCommand('hello', function (array $argv) use ($app) {
//     $name = isset ($argv[2]) ? $argv[2] : "World";
//     $app->getPrinter()->display("Hello $name!!!");
// });

// $app->registerCommand('--help', function (array $argv) use ($app) {
//     $app->getPrinter()->display("Hello Welcome to the basic cmd app");
// });


$app->runCommand($argv);
