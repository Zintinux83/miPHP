<?php

namespace App\Services;

use App\Models\Usuario;

class RolService
{
    /**
     * Lógica para cambiar el rol de un usuario.
     */
    public function cambiarRolUsuario($idUsuario, $idRol): bool
    {
        // Validación simple: asegurarse de que tenemos datos válidos
        if (empty($idUsuario) || empty($idRol)) {
            return false;
        }

        // añadir más reglas aquí: Si el usuario es el último administrador, no permitir cambiarle el rol

        return Usuario::actualizarRol($idUsuario, $idRol);
    }
}