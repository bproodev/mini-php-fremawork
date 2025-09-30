<?php

namespace Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance(): PDO {

        if(self::$instance == null){

            $host   = $_ENV['DB_HOST'] ?? 'localhost';
            $dbname = $_ENV['DB_NAME'] ?? 'market_app_db';
            $user   = $_ENV['DB_USER'] ?? 'root';
            $pass   = $_ENV['DB_PASS'] ?? '';

            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            try {
                self::$instance = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion a la base de donnee: ". $e->getMessage());
            }
        }

        return self::$instance;

    }

}