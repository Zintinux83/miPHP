<?php
// comentarios especiales llamados DocBlocks
// variables vendrán desde fuera y son de este tipo...
// tipo string variable
/** @var string $nombreUsuario */
/** @var array $tareasDelUsuario */

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas de <?= htmlspecialchars($nombreUsuario) ?></title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; line-height: 1.6; }
        .btn-volver { display: inline-block; margin-bottom: 20px; color: #3498db; text-decoration: none; }
        .tarea-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>

<a href="index.php" class="btn-volver">⬅ Volver al inicio</a>

<h1>Panel de Tareas</h1>
<h3>Usuario: <span style="color: #2980b9;"><?= htmlspecialchars($nombreUsuario) ?></span></h3>

<div class="listado">
    <?php if (empty($tareasDelUsuario)): ?>
        <p>Sin tareas asignadas.</p>
    <?php else: ?>
        <?php foreach ($tareasDelUsuario as $tarea): ?>
            <div class="tarea-card">
                <strong><?= htmlspecialchars($tarea['nombre']) ?></strong><br>
                <small>ID: #<?= $tarea['id'] ?> | Fecha: <?= $tarea['creado_en'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>