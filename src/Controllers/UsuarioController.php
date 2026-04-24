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

    public function subirFoto($idUsuario, $file): void
    {
        // 1. Validaciones básicas
        $directorioSubida = __DIR__ . '/../../public/uploads/perfiles/';
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $formatosPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extension, $formatosPermitidos)) {
            header("Location: index.php?error=formato_no_valido");
            exit;
        }

        // 2. Crear un nombre único para que no se machaquen fotos con el mismo nombre
        $nombreArchivo = "user_" . $idUsuario . "_" . time() . "." . $extension;
        $rutaDestino = $directorioSubida . $nombreArchivo;

        // 3. Mover el archivo de la carpeta temporal a la nuestra
        if (move_uploaded_file($file['tmp_name'], $rutaDestino)) {
            // 4. Guardar el nombre en la base de datos
            \App\Models\Usuario::actualizarFoto($idUsuario, $nombreArchivo);
            header("Location: index.php?mensaje=foto_actualizada");
        } else {
            header("Location: index.php?error=error_subida");
        }
        exit;
    }
}