<?php

namespace App\Models;

use App\Database\Connection;

class Rol
{
    public static function leerTodos(): array
    {
        $db = Connection::get();
        // Los roles son globales, no pertenecen a un usuario en específico
        $sql = "SELECT * FROM roles ORDER BY nombre ASC";
        return $db->query($sql)->fetchAll();
    }

    public static function crear($nombreRol): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("INSERT INTO roles (nombre) VALUES (?)");
        return $stmt->execute([$nombreRol]);
    }

    public static function eliminar($id): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("DELETE FROM roles WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public static function buscarPorUsuario($usuarioId): array
    {
        $db = Connection::get();
        $stmt = $db->prepare("SELECT * FROM roles WHERE usuario_id = ? ORDER BY creado_en DESC");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }

    public static function actualizarNombre($idRol, $nuevoNombre): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("UPDATE roles SET nombre = ? WHERE id = ?");
        return $stmt->execute([$nuevoNombre, $idRol]);
    }

    public static function sembrar(): void {
        $db = \App\Database\Connection::get();

        // 1. Crear la tabla por si acaso no existe
        $sql = "CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50) NOT NULL UNIQUE,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        $db->exec($sql);

        // 2. Ahora que sabemos que la tabla existe, seguimos con lo de siempre
        $rolesPredeterminados = ['jefe', 'admin', 'trabajador'];
        $nombresExistentes = array_column(self::leerTodos(), 'nombre');

        foreach ($rolesPredeterminados as $nombre) {
            if (!in_array($nombre, $nombresExistentes)) {
                self::crear($nombre);
            }
        }
    }
}