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

// 1. Procesar POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userCtrl->guardar($_POST);
    $tareaCtrl->procesarPost($_POST);
}

// 2. Preparar Datos
$listaUsuarios = Usuario::leerTodos();
$nombreVista = "Listado General de Tareas";
$listaTareas = Tarea::leerTodas();

// 3. CARGAR LA VISTA (Aquí está la clave)
include __DIR__ . '/../src/views/home.view.php';