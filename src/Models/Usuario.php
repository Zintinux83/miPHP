<?php
namespace App\Models;

use App\Database\Connection;

class Usuario {

    public static function crear($nombre, $rolId): bool
    {
        $db = Connection::get();
        // Añadimos rol_id a la consulta
        $stmt = $db->prepare("INSERT INTO usuarios (nombre, rol_id) VALUES (?, ?)");
        return $stmt->execute([$nombre, $rolId]);
    }

    public static function leerTodos(): array
    {
        $db = Connection::get();
        // Usamos LEFT JOIN para traer el nombre del rol.
        // Si un usuario no tiene rol, aparecerá como NULL pero no romperá la página.
        $sql = "SELECT usuarios.*, roles.nombre AS nombre_rol 
            FROM usuarios 
            LEFT JOIN roles ON usuarios.rol_id = roles.id 
            ORDER BY usuarios.id DESC";

        return $db->query($sql)->fetchAll();
    }

    public static function actualizarFoto(int $id, string $rutaImagen): bool
    {
        $db = Connection::get();
        $stmt = $db->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
        return $stmt->execute([$rutaImagen, $id]);
    }

    public static function actualizarRol($idUsuario, $nuevoRolId): bool
    {
        $db = Connection::get();
        // Preparamos la sentencia para cambiar el rol de un usuario específico
        $stmt = $db->prepare("UPDATE usuarios SET rol_id = ? WHERE id = ?");
        return $stmt->execute([$nuevoRolId, $idUsuario]);
    }
}
