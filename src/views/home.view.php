<?php
/** @var array $listaUsuarios */
/** @var array $listaTareas */
/** @var array $listaRoles */
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

<div class="header-wrapper">
    <div class="header-glow"></div>
    <div class="header-container">
        <h1 class="main-title">
            <span class="emoji-container">
                <span class="emoji">🚀</span>
            </span>
            <div class="title-text">
                Gestión de <span class="highlight">Tareas</span>
            </div>
            <span class="subtitle"> Modelo de MVC </span>
        </h1>
    </div>
</div>

<div class="seccion">
    <h2>1. Crear Usuario</h2>
    <form action="index.php" method="POST">
        <input type="hidden" name="accion" value="crear_usuario">

        <input type="text" name="nombre" placeholder="Nombre del usuario" required>

        <select name="rol_id" required>
            <option value="">Selecciona un rol</option>
            <?php foreach ($listaRoles as $rol): ?>
                <option value="<?= $rol['id'] ?>"><?= ucfirst($rol['nombre']) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Crear Usuario</button>
    </form>
</div>

<div class="seccion" id="usuarios">
    <h2>Usuarios registrados</h2>
    <ul class="user-list"> <?php foreach ($listaUsuarios as $u): ?>
            <li id="user-<?= $u['id'] ?>" class="user-card">

                <div class="user-header">
                    <div class="user-main-info">
                        <img src="uploads/perfiles/<?= $u['foto_perfil'] ?? 'default.png' ?>"
                             class="profile-img"
                             style="width: 50px !important; height: 50px !important; border-radius: 50%; object-fit: cover;"
                             alt="Perfil">
                        <div class="text-info">
                            <strong><?= htmlspecialchars($u['nombre']) ?></strong>
                            <span class="role-badge"><?= htmlspecialchars($u['nombre_rol'] ?? 'Sin cargo') ?></span>
                        </div>
                    </div>
                    <a href="usuario_tareas.php?id=<?= $u['id'] ?>" class="btn-tasks">Ver tareas</a>
                </div>

                <div class="user-actions">
                    <form method="POST" class="form-inline">
                        <input type="hidden" name="accion" value="actualizar_rol">
                        <input type="hidden" name="id_usuario" value="<?= $u['id'] ?>">
                        <select name="nuevo_rol_id" onchange="this.form.submit()" class="select-minimal">
                            <option value="">Cambiar cargo...</option>
                            <?php foreach ($listaRoles as $rol): ?>
                                <option value="<?= $rol['id'] ?>" <?= ($u['rol_id'] == $rol['id']) ? 'selected' : '' ?>>
                                    <?= ucfirst($rol['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>

                    <form method="POST" enctype="multipart/form-data" class="form-photo">
                        <input type="hidden" name="id_usuario_foto" value="<?= $u['id'] ?>">
                        <label class="custom-file-upload">
                            <input type="file" name="foto" onchange="this.form.submit()" required>
                            📷 Actualizar foto
                        </label>
                    </form>
                </div>
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