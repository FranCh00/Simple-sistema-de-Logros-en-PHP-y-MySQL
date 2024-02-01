<?php
include_once '../src/Logros/SistemaLogros.php';
include_once '../src/Usuarios/Usuario.php';
include_once '../src/Notificaciones/Notificador.php';

$sistemaLogros = new SistemaLogros();
$usuario = new Usuario();
$notificador = new Notificador();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar un nuevo usuario
    if (isset($_POST['agregar_usuario'])) {
        $nombreUsuario = $_POST['nombre_usuario'];
        $correoUsuario = $_POST['correo_usuario'];
        $contrasenaUsuario = $_POST['contrasena_usuario'];

        $usuario->agregarUsuario($nombreUsuario, $correoUsuario, $contrasenaUsuario);
    }

    // Agregar un nuevo logro
    if (isset($_POST['agregar_logro'])) {
        $nombreLogro = $_POST['nombre_logro'];
        $descripcionLogro = $_POST['descripcion_logro'];
        $tareaLogro = $_POST['tarea_logro'];
        $creditosLogro = $_POST['creditos_logro'];
    
        // Manejo de la carga de la imagen
        $directorioImagenes = "imagenes/"; // El directorio donde se almacenarán las imágenes
        $rutaImagen = $directorioImagenes . basename($_FILES["imagen_logro"]["name"]);
    
        // Intenta mover el archivo subido al directorio de imágenes
        if (move_uploaded_file($_FILES["imagen_logro"]["tmp_name"], $rutaImagen)) {
            echo "La imagen ". htmlspecialchars(basename($_FILES["imagen_logro"]["name"])). " ha sido subida.";
        } else {
            echo "Hubo un error al subir la imagen.";
        }
    
        $sistemaLogros->agregarLogro($nombreLogro, $descripcionLogro, $tareaLogro, $creditosLogro, $rutaImagen);
    }

    // Desbloquear logro para el usuario
    if (isset($_POST['desbloquear_logro'])) {
        $idUsuarioDesbloquear = $_POST['id_usuario_desbloquear'];
        $idLogroDesbloquear = $_POST['id_logro_desbloquear'];
        $progresoUsuario = $_POST['progreso_usuario'];

        // Desbloquear logro y obtener información del logro desbloqueado
        $sistemaLogros->desbloquearLogro($idUsuarioDesbloquear, $idLogroDesbloquear, $progresoUsuario);
        $logroDesbloqueado = $sistemaLogros->getLogroPorId($idLogroDesbloquear);

        // Enviar notificación de logro desbloqueado
        $notificador->notificacion_logro($logroDesbloqueado['nombre'], $logroDesbloqueado['creditos']);
        // version anterior: $notificador->enviarNotificacion("¡Logro desbloqueado! {$logroDesbloqueado['nombre']}: {$logroDesbloqueado['descripcion']} - {$logroDesbloqueado['creditos']} Créditos");
    }
}

$logros = $sistemaLogros->getLogros();
$usuarios = $sistemaLogros->getUsuariosConLogros();
?>
<!DOCTYPE html>
<html lang="es">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sistema de Logros</title>
      <!-- Enlaces a Bootstrap -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Enlaces a Google Fonts (ejemplo con la fuente 'Open Sans') -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
      <link rel="stylesheet" href="css/notificacion_logro.css">

   </head>
<body>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Logros</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Sobre Nosotros</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Contacto</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <!-- Contenido de la página -->
<div class="container mt-4">
    <h1 class="mb-4">Bienvenido al Sistema de Logros</h1>
    <p class="lead">Descubre los logros disponibles, agrega nuevos usuarios y desbloquea logros para ellos.</p>

    <h2 class="mt-4">Logros Disponibles</h2>
    <div class="list-group">
        <?php foreach ($logros as $logro) : ?>
            <div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4 d-flex align-items-center justify-content-center" style="background: linear-gradient(to right, #6f3f91, #4c2455);">
            <img src="<?= $logro['imagen'] ?>" class="img-fluid rounded-start" alt="Imagen del Logro" style="object-fit: contain;">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= $logro['nombre'] ?></h5>
                <p class="card-text"><?= $logro['descripcion'] ?></p>
                <p class="card-text">Tarea: <?= $logro['tarea'] ?> - Créditos: <?= $logro['creditos'] ?></p>
            </div>
        </div>
    </div>
</div>

        <?php endforeach; ?>
    </div>
    <br>
    <h2>Agregar Logro</h2>
<form action="index.php" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-3">
        <label for="nombre_logro" class="form-label">Nombre del Logro</label>
        <input type="text" name="nombre_logro" id="nombre_logro" class="form-control" placeholder="Nombre del Logro" required>
    </div>
    <div class="mb-3">
        <label for="descripcion_logro" class="form-label">Descripción del Logro</label>
        <textarea name="descripcion_logro" id="descripcion_logro" class="form-control" placeholder="Descripción del Logro" required></textarea>
    </div>
    <div class="mb-3">
        <label for="tarea_logro" class="form-label">Tarea Asociada</label>
        <input type="text" name="tarea_logro" id="tarea_logro" class="form-control" placeholder="ej: Haber terminado de ver 1000 Capitulos de One Piece" required>
    </div>
    <div class="mb-3">
        <label for="creditos_logro" class="form-label">Créditos para Desbloquear</label>
        <input type="number" name="creditos_logro" id="creditos_logro" class="form-control" placeholder="Créditos para Desbloquear" required>
    </div>
    <div class="mb-3">
        <label for="imagen_logro" class="form-label">Imagen del Logro</label>
        <input type="file" name="imagen_logro" id="imagen_logro" class="form-control" accept="image/x-png,image/gif,image/jpeg" required>
    </div>
    <button type="submit" name="agregar_logro" class="btn btn-primary">Agregar Logro</button>
</form>

<br>
    <h2 class="mt-4">Desbloquear Logro</h2>
    <form action="index.php" method="post" class="mt-3">
        <div class="mb-3">
            <label for="id_usuario_desbloquear" class="form-label">Seleccionar Usuario</label>
            <select name="id_usuario_desbloquear" id="id_usuario_desbloquear" class="form-select" required>
                <option value="" disabled selected>Seleccionar Usuario</option>
                <?php foreach ($usuarios as $usuario) : ?>
                    <option value="<?= $usuario['id'] ?>"><?= "{$usuario['nombre']} (ID: {$usuario['id']})" ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_logro_desbloquear" class="form-label">Seleccionar Logro</label>
            <select name="id_logro_desbloquear" id="id_logro_desbloquear" class="form-select" required>
                <option value="" disabled selected>Seleccionar Logro</option>
                <?php foreach ($logros as $logro) : ?>
                    <option value="<?= $logro['id'] ?>"><?= "{$logro['nombre']} (ID: {$logro['id']})" ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="progreso_usuario" class="form-label">Progreso del Usuario</label>
            <input type="number" name="progreso_usuario" id="progreso_usuario" class="form-control" placeholder="Progreso del Usuario" required>
        </div>
        <button type="submit" name="desbloquear_logro" class="btn btn-primary">Desbloquear Logro</button>
    </form>
    <br>
    <h2>Agregar Usuario</h2>
    <form action="index.php" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-3">
        <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
        <input type="text" name="nombre_usuario" placeholder="Nombre del Usuario" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="correo_usuario" class="form-label">E-mail</label>
        <input type="email" name="correo_usuario" placeholder="Correo Electrónico" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="contrasena_usuario" class="form-label">Contraseña</label>
        <input type="password" name="contrasena_usuario" placeholder="Contraseña" class="form-control" required>
    </div>
    <button type="submit"  type="submit" name="agregar_usuario" class="btn btn-primary">Agregar Usuario</button>
</form>






















    <h2 class="mt-4">Usuarios con Logros</h2>
    <ul class="list-group mt-3">
        <?php foreach ($usuarios as $usuario) : ?>
            <li class="list-group-item"><?= "{$usuario['nombre']} ha obtenido los siguientes logros: {$usuario['logros_obtenidos']}" ?></li>
        <?php endforeach; ?>
    </ul>
</div>

      <!-- Footer -->
      <footer class="footer mt-auto py-3 bg-light">
         <div class="container">
            <span class="text-muted">© 2024 Sistema de Logros</span>
         </div>
      </footer>
      <div id="notificacion" style="display: none; position: fixed; bottom: 0; left: 0; background-color: #f44336; color: white; padding: 16px;">
         <p id="mensaje"></p>
      </div>
      <!-- Enlaces a los scripts de Bootstrap y Popper.js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   </body>
</html>
