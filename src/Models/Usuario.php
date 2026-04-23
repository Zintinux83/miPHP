<?php
namespace App\Models;

use App\Database\Connection;

class Usuario {

    public static function leerTodos(): array
    {
        $db = Connection::get();
        $stmt = $db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll();
    }

    public static function crear(string $nombre) {
        $db = Connection::get();

        // 1. Preparamos la consulta con un "placeholder" (?) o (:nombre)
        $sql = "INSERT INTO usuarios (nombre) VALUES (:nom)";
        $stmt = $db->prepare($sql);

        // 2. Ejecutamos pasando los datos por separado
        // Esto limpia el string y evita ataques SQL Injection
        return $stmt->execute(['nom' => $nombre]);
    }
}
