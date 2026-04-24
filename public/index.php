<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Controllers\UsuarioController;
use App\Controllers\TareaController;
use App\Models\Usuario;
use App\Models\Tarea;

$userCtrl = new UsuarioController();
$tareaCtrl = new TareaController();

// --- 1. LÓGICA DE PROCESAMIENTO (Todo el POST aquí arriba) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Caso A: Subida de foto
    if (isset($_POST['id_usuario_foto']) && isset($_FILES['foto'])) {
        $userCtrl->subirFoto($_POST['id_usuario_foto'], $_FILES['foto']);
    }

    // Caso B: Otros procesos (Guardar usuario o procesar tareas)
    $userCtrl->guardar($_POST);
    $tareaCtrl->procesarPost($_POST);
}

// --- 2. PREPARAR DATOS PARA LA VISTA ---
$listaUsuarios = Usuario::leerTodos();
$listaTareas = Tarea::leerTodas();
$nombreVista = "Listado General de Tareas";

// --- 3. CARGAR LA VISTA ---
include __DIR__ . '/../src/views/home.view.php';