<?php
namespace App\Controllers;

use App\Models\Tarea;
use App\Services\TareaService;
use JetBrains\PhpStorm\NoReturn;

class TareaController {
    private TareaService $tareaService;

    public function __construct() {
        // El controlador ahora depende del servicio
        $this->tareaService = new TareaService();
    }

    // Este método gestiona todas las peticiones POST de tareas
    #[NoReturn] public function procesarPost($post): void
    {
        if (isset($post['tarea_desc']) && isset($post['id_usuario'])) {
            $this->tareaService->registrarTarea($post['tarea_desc'], $post['id_usuario']);
            $this->redireccionar();
        }

        if (isset($post['eliminar_id'])) {
            Tarea::eliminar($post['eliminar_id']);
            $this->redireccionar();
        }
        exit;
    }

    #[NoReturn] private function redireccionar(): void
    {
        header("Location: index.php");
        exit;
    }
}