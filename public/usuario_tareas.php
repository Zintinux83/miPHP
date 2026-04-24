<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Models\Usuario;
use App\Models\Tarea;

$idUsuario = $_GET['id'] ?? null;

if (!$idUsuario) {
    header("Location: index.php");
    exit;
}

// 1. Preparar Datos
$listaUsuarios = Usuario::leerTodos();
$tareasDelUsuario = Tarea::buscarPorUsuario($idUsuario);

$nombreUsuario = "Desconocido";
foreach ($listaUsuarios as $u) {
    if ($u['id'] == $idUsuario) {
        $nombreUsuario = $u['nombre'];
        break;
    }
}

// 2. CARGAR LA VISTA
include __DIR__ . '/../src/views/user_tasks.view.php';
