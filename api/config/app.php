<?php

return [
    'env' => $_ENV['APP_ENV'],
    'log_level' => $_ENV['LOG_LEVEL'],
    'minuti' => $_ENV['MINUTI'], // Minuti minimi tra un allarme e l'altro
    'debug' => ($_ENV['APP_ENV']) === 'development',
];
