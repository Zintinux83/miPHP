<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Models\Usuario;
use App\Models\Tarea;

// 1. Obtener el ID del usuario de la URL
$idUsuario = $_GET['id'] ?? null;

// Si no hay ID, lo mandamos de vuelta al inicio
if (!$idUsuario) {
    header("Location: index.php");
    exit;
}

// 2. Obtener los datos necesarios
$listaUsuarios = Usuario::leerTodos();
$tareasDelUsuario = Tarea::buscarPorUsuario($idUsuario);

// 3. Buscar el nombre del usuario para el título
$nombreUsuario = "Desconocido";
foreach ($listaUsuarios as $u) {
    if ($u['id'] == $idUsuario) {
        $nombreUsuario = $u['nombre'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas de <?= htmlspecialchars($nombreUsuario) ?></title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; line-height: 1.6; }
        .btn-volver { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; }
        .tarea-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; background: #fff; }
        .estado { font-weight: bold; color: #e67e22; }
    </style>
</head>
<body>

<a href="index.php" class="btn-volver">⬅ Volver al listado general</a>

<h1>Panel de Tareas</h1>
<h3>Usuario: <span style="color: #2980b9;"><?= htmlspecialchars($nombreUsuario) ?></span></h3>

<div class="listado">
    <?php if (empty($tareasDelUsuario)): ?>
        <p>Este usuario aún no tiene tareas asignadas.</p>
    <?php else: ?>
        <?php foreach ($tareasDelUsuario as $tarea): ?>
            <div class="tarea-card">
                <strong><?= htmlspecialchars($tarea['nombre']) ?></strong><br>
                <small>ID Tarea: #<?= $tarea['id'] ?> | Fecha: <?= $tarea['creado_en'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>