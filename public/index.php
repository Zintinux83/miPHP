<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Importamos las cosas
use App\Controllers\UsuarioController;
use App\Controllers\TareaController;
use App\Models\Usuario;
use App\Models\Tarea;

// Inicializamos los controladores
$userCtrl = new UsuarioController();
$tareaCtrl = new TareaController();

// --- LÓGICA DE PROCESAMIENTO (Delegada) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userCtrl->guardar($_POST);
    $tareaCtrl->procesarPost($_POST);
}

// --- PREPARACIÓN DE DATOS PARA LA VISTA de usuario_tareas.php ---
$listaUsuarios = Usuario::leerTodos();
$listaTareas = Tarea::leerTodas();

$usuarioSeleccionado = $_GET['ver_usuario'] ?? null;

if ($usuarioSeleccionado) {
    $listaTareas = Tarea::buscarPorUsuario($usuarioSeleccionado);
    $nombreVista = "Tareas de " . $listaUsuarios[array_search($usuarioSeleccionado, array_column($listaUsuarios, 'id'))]['nombre'];
} else {
    $listaTareas = Tarea::leerTodas();
    $nombreVista = "Listado General de Tareas";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas por Usuario</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 20px auto; }
        .seccion { border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .tarea-item { background: #f9f9f9; padding: 10px; margin: 5px 0; border-left: 4px solid #3498db; }
    </style>
</head>

<body>

<div class="seccion">
    <h2>1. Crear Usuario</h2>
    <form method="POST">
        <label>
            <input type="text" name="nombre_usuario" minlength="3" maxlength="20" placeholder="Nombre del usuario..." required>
        </label>
        <button type="submit">Guardar Usuario</button>
    </form>
</div>

<div class="seccion">
    <h2>Usuarios en la base de datos:</h2>
    <ul>
        <?php foreach ($listaUsuarios as $u): ?>
            <li>ID: <?= $u['id'] ?> - Nombre: <?= htmlspecialchars($u['nombre']) ?></li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="seccion">
    <h2>2. Asignar Tarea a Usuario</h2>
    <form method="POST">
        <label>
            <input type="text" name="tarea_desc" minlength="3" maxlength="30" placeholder="¿Qué hay que hacer?" required>
        </label>

        <label>
            <select name="id_usuario" required>
                <option value="">Selecciona un responsable...</option>
                <?php foreach ($listaUsuarios as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <button type="submit">Crear Tarea</button>
    </form>
</div>

<hr>

<div class="seccion">
    <h2><?= $nombreVista ?></h2>
    <?php if (empty($listaTareas)): ?>
        <p>No hay tareas pendientes.</p>
    <?php else: ?>
        <?php foreach ($listaTareas as $t): ?>
            <div class="tarea-item">
                <strong>Tarea:</strong> <?= htmlspecialchars($t['nombre']) ?> <br>
                <small>Asignada al Usuario ID: <?= $t['usuario_id'] ?> | Creada: <?= $t['creado_en'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="seccion">
    <h2><?= $nombreVista ?> para borrar</h2>
    <?php if ($usuarioSeleccionado): ?>
        <a href="index.php">⬅ Ver todas las tareas</a>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <?php foreach ($listaTareas as $t): ?>
            <div class="tarea-item">
                <strong><?= htmlspecialchars($t['nombre']) ?></strong>
                <br>
                <small>
                    Responsable: <?= htmlspecialchars($t['dueño'] ?? 'Usuario '.$t['usuario_id']) ?>
                </small>

                <form method="POST" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="eliminar_id" value="<?= $t['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Seguro?')">🗑 Borrar</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>


    <h2>Usuarios registrados (Haz clic para filtrar):</h2>
    <ul>
        <?php foreach ($listaUsuarios as $u): ?>
            <li>
                <?= htmlspecialchars($u['nombre']) ?>
                <a href="usuario_tareas.php?id=<?= $u['id'] ?>">[Ver sus tareas]</a>
            </li>
        <?php endforeach; ?>
    </ul>

<div>

</body>
</html>