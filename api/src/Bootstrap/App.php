<?php

namespace App\Bootstrap;

use DI\Container;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\App as SlimApp;

class App
{
    public static function create(): SlimApp
    {
        // Determina l'ambiente (priorità: variabile d'ambiente server > .env > default)
        $envDir = __DIR__ . '/../../';
        $environment = self::determineEnvironment($envDir);
        
        // Carica variabili d'ambiente
        self::loadEnvironmentFiles($envDir, $environment);

        // Crea il container DI
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/../../config/dependencies.php');
        $container = $containerBuilder->build();

        // Crea l'applicazione Slim
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Configura middleware
        $app->addBodyParsingMiddleware();
        $app->addRoutingMiddleware();
        
        // Configurazione app
        $appConfig = require __DIR__ . '/../../config/app.php';
        
        // Middleware per gestire errori
        $displayErrorDetails = $appConfig['debug'];
        $logErrors = true;
        $logErrorDetails = $appConfig['debug'];
        
        $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, $logErrors, $logErrorDetails);
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->forceContentType('application/json');

        // CORS middleware (se necessario)
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        });

        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });

        return $app;
    }

    /**
     * Determina l'ambiente corrente
     * Priorità: 1) Variabile d'ambiente server, 2) File .env, 3) Default 'development'
     */
    private static function determineEnvironment(string $envDir): string
    {
        // Prima controlla se esiste una variabile d'ambiente del server (più sicuro per produzione)
        if (isset($_SERVER['APP_ENV']) && !empty($_SERVER['APP_ENV'])) {
            return $_SERVER['APP_ENV'];
        }

        // Se esiste getenv (variabile d'ambiente sistema)
        $serverEnv = getenv('APP_ENV');
        if ($serverEnv !== false && !empty($serverEnv)) {
            return $serverEnv;
        }

        // Prova a leggere da .env se esiste
        $envFile = $envDir . '.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                // Ignora commenti
                if (strpos(trim($line), '#') === 0) {
                    continue;
                }
                // Cerca APP_ENV
                if (preg_match('/^APP_ENV\s*=\s*(.+)$/i', $line, $matches)) {
                    return trim($matches[1], " \t\n\r\0\x0B\"'");
                }
            }
        }

        // Default
        return 'development';
    }

    /**
     * Carica i file di ambiente in ordine di priorità
     * 1. .env (valori base, opzionale)
     * 2. .env.{environment} (sovrascrive i valori base)
     */
    private static function loadEnvironmentFiles(string $envDir, string $environment): void
    {
        // Carica prima .env se esiste (valori base)
        $baseEnvFile = $envDir . '.env';
        if (file_exists($baseEnvFile)) {
            $dotenv = \Dotenv\Dotenv::createImmutable($envDir, '.env');
            $dotenv->load();
        }

        // Poi carica .env.{environment} se esiste (sovrascrive i valori base)
        $envSpecificFile = $envDir . ".env.{$environment}";
        if (file_exists($envSpecificFile)) {
            $dotenv = \Dotenv\Dotenv::createImmutable($envDir, ".env.{$environment}");
            $dotenv->load();
        }
    }
}
