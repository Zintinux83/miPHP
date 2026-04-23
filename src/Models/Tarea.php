<?php
namespace App\Models;

use App\Database\Connection;

class Tarea {

    public static function leerTodas(): array
    {
        $db = Connection::get();
        // Usamos INNER JOIN para traer el nombre del usuario junto con la tarea
        $sql = "SELECT tareas.*, usuarios.nombre AS dueño 
            FROM tareas 
            INNER JOIN usuarios ON tareas.usuario_id = usuarios.id 
            ORDER BY tareas.creado_en DESC";
        return $db->query($sql)->fetchAll();
    }

    public static function crear($descripcion, $usuarioId): bool
    {
        $db = Connection::get();
        // Añadimos usuario_id a la consulta
        $stmt = $db->prepare("INSERT INTO tareas (nombre, usuario_id) VALUES (?, ?)");
        return $stmt->execute([$descripcion, $usuarioId]);
    }

    public static function completar($id): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("UPDATE tareas SET completado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function eliminar($id): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("DELETE FROM tareas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function buscarPorUsuario($usuarioId): array
    {
        $db = Connection::get();
        $stmt = $db->prepare("SELECT * FROM tareas WHERE usuario_id = ?");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll();
    }
}
