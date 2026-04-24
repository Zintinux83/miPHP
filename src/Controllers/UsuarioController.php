<?php
namespace App\Controllers;

use App\Services\UsuarioService;

class UsuarioController {
    private UsuarioService $usuarioService;

    public function __construct() {
        // El controlador ahora depende del servicio
        $this->usuarioService = new UsuarioService();
    }

    public function guardar($post): void
    {
        if (isset($post['nombre_usuario'])) {
            $exito = $this->usuarioService->registrarNuevoUsuario($post['nombre_usuario']);

            if ($exito) {
                header("Location: index.php?mensaje=usuario_creado");
            } else {
                header("Location: index.php?error=nombre_invalido");
            }
            exit;
        }
    }
}