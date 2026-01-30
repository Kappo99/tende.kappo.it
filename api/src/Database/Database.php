<?php

namespace App\Database;

use mysqli;

class Database
{
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli
    {
        if (self::$connection === null) {
            $config = require __DIR__ . '/../../config/database.php';
            
            self::$connection = @new mysqli(
                $config['host'],
                $config['user'],
                $config['pass'],
                $config['name']
            );

            if (self::$connection->connect_error) {
                throw new \RuntimeException(
                    "Errore connessione Database MySQL: " . self::$connection->connect_error,
                    self::$connection->connect_errno
                );
            }

            self::$connection->set_charset($config['charset']);
        }

        return self::$connection;
    }

    public static function closeConnection(): void
    {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}
