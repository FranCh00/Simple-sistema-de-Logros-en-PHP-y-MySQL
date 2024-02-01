<?php
include_once '../../../src/Logros/SistemaLogros.php';

$sistemaLogros = new SistemaLogros();
$logros = $sistemaLogros->getLogros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Logros</title>
</head>
<body>
    <h1>Logros</h1>

    <?php foreach ($logros as $logro): ?>
        <div>
            <h2><?= $logro['nombre'] ?></h2>
            <p><?= $logro['descripcion'] ?></p>
            <p>Tarea: <?= $logro['tarea'] ?></p>
            <p>Créditos: <?= $logro['creditos'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
