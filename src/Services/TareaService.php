<?php

namespace App\Services;

use App\Models\Tarea;

class TareaService
{
    /**
     * Lógica para registrar una tarea a un usuario siguiendo una serie de validaciones.
     */
    public function registrarTarea($descTarea, $id_usuario): bool
    {
        // Regla de negocio: El nombre no puede estar vacío ni ser solo espacios
        $descLimpia = trim($descTarea);

        if (empty($descLimpia)) {
            // Aquí podrías lanzar una excepción o retornar un error
            return false;
        }

        // Regla de negocio: Longitud mínima (3 caracteres) y una máxima de 30
        if (strlen($descLimpia) < 3 || strlen($descTarea) >= 30) {
            return false;
        }

        return Tarea::crear($descLimpia,  $id_usuario);
    }

}