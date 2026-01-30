<?php

use App\Repositories\WindSensorRepository;
use App\Repositories\RainSensorRepository;
use App\Repositories\AlarmRegisterRepository;
use App\Services\WindSensorService;
use App\Services\RainSensorService;
use App\Services\AlarmRegisterService;
use App\Managers\WindSensorManager;
use App\Managers\RainSensorManager;
use App\Managers\AlarmRegisterManager;
use App\Controllers\WindSensorController;
use App\Controllers\RainSensorController;
use App\Controllers\AlarmRegisterController;

return [
    // Repositories
    WindSensorRepository::class => \DI\create(WindSensorRepository::class),
    RainSensorRepository::class => \DI\create(RainSensorRepository::class),
    AlarmRegisterRepository::class => \DI\create(AlarmRegisterRepository::class),

    // Services
    WindSensorService::class => \DI\create(WindSensorService::class)
        ->constructor(\DI\get(WindSensorRepository::class)),
    RainSensorService::class => \DI\create(RainSensorService::class)
        ->constructor(\DI\get(RainSensorRepository::class)),
    AlarmRegisterService::class => \DI\create(AlarmRegisterService::class)
        ->constructor(\DI\get(AlarmRegisterRepository::class)),

    // Managers
    WindSensorManager::class => \DI\create(WindSensorManager::class)
        ->constructor(\DI\get(WindSensorService::class)),
    RainSensorManager::class => \DI\create(RainSensorManager::class)
        ->constructor(\DI\get(RainSensorService::class)),
    AlarmRegisterManager::class => \DI\create(AlarmRegisterManager::class)
        ->constructor(\DI\get(AlarmRegisterService::class)),

    // Controllers
    WindSensorController::class => \DI\create(WindSensorController::class)
        ->constructor(\DI\get(WindSensorManager::class)),
    RainSensorController::class => \DI\create(RainSensorController::class)
        ->constructor(\DI\get(RainSensorManager::class)),
    AlarmRegisterController::class => \DI\create(AlarmRegisterController::class)
        ->constructor(\DI\get(AlarmRegisterManager::class)),
];
