<?php
include_once '../../src/Usuarios/Usuario.php';

$usuario = new Usuario();
$usuarios = $usuario->getUsuariosConLogros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>

    <?php foreach ($usuarios as $usuario): ?>
        <div>
            <h2><?= $usuario['nombre'] ?></h2>
            <p>Logros obtenidos: <?= $usuario['logros_obtenidos'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
