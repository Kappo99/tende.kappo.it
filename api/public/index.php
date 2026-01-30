<?php

use App\Bootstrap\App;

require __DIR__ . '/../vendor/autoload.php';

$app = App::create();

// Salva l'app nell'array globale per le routes
$GLOBALS['app'] = $app;

// Carica le routes
require __DIR__ . '/../config/routes.php';

$app->run();
