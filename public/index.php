<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Models\Usuario;

// VERIFICAR SI SE HA ENVIADO EL FORMULARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre'])) {
    Usuario::crear($_POST['nombre']);
    // Redirigir para limpiar el formulario y evitar envíos duplicados
    header("Location: index.php");
    exit;
}

$listaUsuarios = Usuario::todos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>


<body>
<h1>Crear nuevo usuario</h1>

<form action="index.php" method="POST">
    <input type="text" name="nombre" placeholder="Escribe el nombre..." required>
    <button type="submit">Agregar Usuario</button>
</form>

<hr>

<h2>Usuarios en la base de datos:</h2>
<ul>
    <?php foreach ($listaUsuarios as $u): ?>
        <li>ID: <?= $u['id'] ?> - Nombre: <?= htmlspecialchars($u['nombre']) ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>