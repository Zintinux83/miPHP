<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Usuario;
use App\Models\Rol;
use App\Models\Tarea;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Rol::sembrar();
Usuario::sembrar();
Tarea::crearTabla();

// 1. TODA LA LÓGICA DE POST (Procesar antes de mostrar nada)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //crear Usuario
    if (($_POST['accion'] ?? '') === 'crear_usuario') {
        Usuario::crear($_POST['nombre'], $_POST['rol_id']);
        header('Location: index.php');
        exit;
    }

    // Actualizar Rol
    if (($_POST['accion'] ?? '') === 'actualizar_rol') {
        $rolController = new \App\Controllers\RolController();
        $rolController->procesarCambioRol($_POST);
    }
}

// 2. LÓGICA DE GET (Preparar los datos para la vista)
$listaUsuarios = Usuario::leerTodos();
$listaRoles    = Rol::leerTodos();
$listaTareas   = Tarea::leerTodas();
$nombreVista   = "Panel de Control";

// 3. POR ÚLTIMO, LLAMAR A LA VISTA
require_once __DIR__ . '/../src/views/home.view.php';