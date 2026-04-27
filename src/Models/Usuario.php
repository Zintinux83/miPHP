<?php
namespace App\Models;

use App\Database\Connection;

class Usuario {

    public static function sembrar(): void
    {
        $db = Connection::get();

        // 1. Crear tabla usuarios si no existe
        // Asegúrate de que los nombres de las columnas coincidan con el resto de tu app
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        foto_perfil VARCHAR(255) DEFAULT NULL,
        rol_id INT DEFAULT NULL,
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        $db->exec($sql);

        // definimos a los usuarios por defecto
        $usuariosPre = [
            ['nombre' => 'Admin 1', 'rol_id' => 2],
            ['nombre' => 'Jefe 1', 'rol_id' => 1]
        ];

        foreach ($usuariosPre as $u) {
            // Buscamos si ya existe un usuario con ese nombre
            $stmt = $db->prepare("SELECT id FROM usuarios WHERE nombre = ?");
            $stmt->execute([$u['nombre']]);

            // Si no encontramos nada (fetch devuelve false), lo creamos
            if (!$stmt->fetch()) {
                // Usamos el método crear que ya tienes definido en el modelo
                self::crear($u['nombre'], $u['rol_id']);
            }
        }
    }

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
