<?php
/** @var array $listaUsuarios */
/** @var array $listaTareas */
/** @var string $nombreVista */
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Tareas</title>
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
        <input type="text" name="nombre_usuario" minlength="3" maxlength="20" placeholder="Nombre..." required>
        <button type="submit">Guardar Usuario</button>
    </form>
</div>

<div class="seccion">
    <h2>Usuarios registrados:</h2>
    <ul>
        <?php foreach ($listaUsuarios as $u): ?>
            <li>
                <?= htmlspecialchars($u['nombre']) ?>
                <a href="usuario_tareas.php?id=<?= $u['id'] ?>">[Ver tareas]</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="seccion">
    <h2>2. Asignar Tarea</h2>
    <form method="POST">
        <input type="text" name="tarea_desc" minlength="3" maxlength="30" placeholder="¿Qué hay que hacer?" required>
        <select name="id_usuario" required>
            <option value="">Selecciona responsable...</option>
            <?php foreach ($listaUsuarios as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Crear Tarea</button>
    </form>
</div>

<hr>

<div class="seccion">
    <h2><?= htmlspecialchars($nombreVista) ?></h2>
    <?php if (empty($listaTareas)): ?>
        <p>No hay tareas.</p>
    <?php else: ?>
        <?php foreach ($listaTareas as $t): ?>
            <div class="tarea-item">
                <strong><?= htmlspecialchars($t['nombre']) ?></strong>
                <br>
                <small>Responsable: <?= htmlspecialchars($t['dueño'] ?? 'ID '.$t['usuario_id']) ?></small>

                <form method="POST" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="eliminar_id" value="<?= $t['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Seguro?')">🗑 Borrar</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>