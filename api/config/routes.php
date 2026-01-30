<?php

use Slim\App;
use App\Controllers\WindSensorController;
use App\Controllers\RainSensorController;
use App\Controllers\AlarmRegisterController;

/** @var App $app */
$app = $GLOBALS['app'] ?? null;

if (!$app) {
    throw new RuntimeException('App non inizializzata');
}

// Wind Sensor Routes
$app->get('/api/wind-sensor', [WindSensorController::class, 'index']);
$app->post('/api/wind-sensor', [WindSensorController::class, 'insert']);
$app->get('/api/wind-sensor/consecutive-values', [WindSensorController::class, 'consecutiveValues']);
$app->get('/api/wind-sensor/minutes', [WindSensorController::class, 'minutes']);

// Rain Sensor Routes
$app->get('/api/rain-sensor', [RainSensorController::class, 'index']);
$app->post('/api/rain-sensor', [RainSensorController::class, 'insert']);

// Alarm Register Routes
$app->get('/api/alarm-register', [AlarmRegisterController::class, 'index']);
$app->post('/api/alarm-register', [AlarmRegisterController::class, 'insert']);

// Health check
$app->get('/api/health', function ($request, $response) {
    $response->getBody()->write(json_encode([
        'status' => 'ok',
        'timestamp' => date('Y-m-d H:i:s')
    ]));
    return $response->withHeader('Content-Type', 'application/json');
});
