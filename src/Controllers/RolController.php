<?php

namespace App\Controllers;

use App\Services\RolService;
use JetBrains\PhpStorm\NoReturn;

class RolController
{
    private RolService $rolService;

    public function __construct()
    {
        $this->rolService = new RolService();
    }

    #[NoReturn] public function procesarCambioRol($post): void
    {
        $idUsuario = $post['id_usuario'] ?? null;
        $idRol = $post['nuevo_rol_id'] ?? null;

        if ($idUsuario && $idRol) {
            $this->rolService->cambiarRolUsuario($idUsuario, $idRol);
        }

        // Redirigimos de vuelta al ancla del usuario
        header("Location: index.php#user-" . $idUsuario);
        exit;
    }
}