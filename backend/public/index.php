<?php

use App\Utils\App;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new App(__DIR__ . "/../");
$app->createRouter(__DIR__ . '/../src/routes.php');
$app->run();
