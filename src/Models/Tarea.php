<?php
namespace App\Models;

use App\Database\Connection;

class Tarea {

    public static function leerTodas() {
        $db = Connection::get();
        return $db->query("SELECT * FROM tareas ORDER BY creado_en DESC")->fetchAll();
    }

    public static function crear($descripcion, $usuarioId) {
        $db = Connection::get();
        // Añadimos usuario_id a la consulta
        $stmt = $db->prepare("INSERT INTO tareas (nombre, usuario_id) VALUES (?, ?)");
        return $stmt->execute([$descripcion, $usuarioId]);
    }

    public static function completar($id) {
        $db = Connection::get();
        $stmt = $db->prepare("UPDATE tareas SET completado = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function eliminar($id) {
        $db = Connection::get();
        $stmt = $db->prepare("DELETE FROM tareas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}