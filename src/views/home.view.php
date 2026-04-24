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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="header-container">
    <h1 class="main-title">
        <span class="emoji">🚀</span>
        Gestión de <span class="highlight">Tareas</span>
        <span class="subtitle">v2.0 MVC</span>
    </h1>
</div>

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
            <li style="margin-bottom: 15px; list-style: none; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                <img src="uploads/perfiles/<?= $u['foto_perfil'] ?? 'default.png' ?>"
                     width="40" height="40"
                     style="border-radius: 50%; object-fit: cover; vertical-align: middle;">

                <strong><?= htmlspecialchars($u['nombre']) ?></strong>

                <a href="usuario_tareas.php?id=<?= $u['id'] ?>">[Ver tareas]</a>

                <form method="POST" enctype="multipart/form-data" style="display:inline; margin-left: 10px;">
                    <input type="hidden" name="id_usuario_foto" value="<?= $u['id'] ?>">
                    <input type="file" name="foto" required style="font-size: 0.8em;">
                    <button type="submit" style="font-size: 0.8em;">Actualizar Foto</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
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