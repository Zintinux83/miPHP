<?php
namespace App\Services;

use App\Models\Usuario;

class UsuarioService {

    /**
     * Lógica para registrar un usuario con validaciones.
     */
    public function registrarNuevoUsuario(string $nombre): bool
    {
        // Regla de negocio: El nombre no puede estar vacío ni ser solo espacios
        $nombreLimpio = trim($nombre);

        if (empty($nombreLimpio)) {
            // Aquí podrías lanzar una excepción o retornar un error
            return false;
        }

        // Regla de negocio: Longitud mínima (3 caracteres) y una máxima de 20.
        if ((strlen($nombreLimpio) < 3) || strlen($nombreLimpio) >= 20) {
            return false;
        }

        // Si pasa las reglas, llamamos al modelo para que lo guarde
        return Usuario::crear($nombreLimpio);
    }

    /**
     * Obtener datos procesados (si hiciera falta algún filtrado extra)

    public function listarTodosLosUsuarios(): array
    {
        return Usuario::leerTodos();
    }*/
}