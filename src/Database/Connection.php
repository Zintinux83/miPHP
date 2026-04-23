<?php
namespace App\Database;

use PDO;
use PDOException;

class Connection {
    private static $instance = null;

    public static function get() {
        if (self::$instance === null) {
            try {
                $host = $_ENV['DB_HOST'];
                $db   = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];

                // PDO: La forma moderna y segura de conectar
                self::$instance = new PDO(
                    "mysql:host=$host;dbname=$db;charset=utf8mb4",
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            }  catch (PDOException $e) {
                // Esto te dirá exactamente qué falló
                echo "¡Error de conexión! Revisa si XAMPP tiene MySQL encendido.<br>";
                echo "Detalle técnico: " . $e->getMessage();
                exit;
            }
        }
        return self::$instance;
    }
}