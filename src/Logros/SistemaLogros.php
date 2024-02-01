<?php
include_once '../src/BaseDatos/Conexion.php';
include_once 'Logro.php';

class SistemaLogros {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::obtenerConexion();
    }

    public function agregarUsuario($nombre, $correo, $contrasena) {
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $this->conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $correo, $hashedPassword);

        $stmt->execute();

        $stmt->close();
    }

    public function agregarLogro($nombre, $descripcion, $tarea, $creditos, $imagen) {
        $stmt = $this->conexion->prepare("INSERT INTO logros (nombre, descripcion, tarea, creditos, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $nombre, $descripcion, $tarea, $creditos, $imagen);

        $stmt->execute();

        $stmt->close();
    }

    public function desbloquearLogro($idUsuario, $idLogro, $progresoUsuario) {
        // Verificar si el logro ya está desbloqueado para el usuario
        $stmtCheck = $this->conexion->prepare("SELECT * FROM progreso_usuario WHERE id_usuario = ? AND id_logro = ?");
        $stmtCheck->bind_param("ii", $idUsuario, $idLogro);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
    
        if ($resultCheck->num_rows > 0) {
            // El logro ya está desbloqueado para el usuario, puedes manejar esto según tus necesidades
            echo "<script>mostrarNotificacion('El logro ya está desbloqueado para este usuario.');</script>";
        } else {
            // El logro no está desbloqueado, procede con la inserción
            $stmt = $this->conexion->prepare("INSERT INTO progreso_usuario (id_usuario, id_logro, completado) VALUES (?, ?, 1)");
            $stmt->bind_param("ii", $idUsuario, $idLogro);
            $stmt->execute();
            $stmt->close();
        }
    
        $stmtCheck->close();
    }

    public function getLogros() {
        $result = $this->conexion->query("SELECT * FROM logros");

        $logros = [];
        while ($row = $result->fetch_assoc()) {
            $logros[] = $row;
        }

        $result->free_result();

        return $logros;
    }

    public function getLogroPorId($idLogro) {
        $stmt = $this->conexion->prepare("SELECT * FROM logros WHERE id = ?");
        $stmt->bind_param("i", $idLogro);

        $stmt->execute();

        $result = $stmt->get_result();
        $logro = $result->fetch_assoc();

        $stmt->close();

        return $logro;
    }

    public function getUsuariosConLogros() {
        $result = $this->conexion->query("SELECT usuarios.id, usuarios.nombre, GROUP_CONCAT(logros.nombre SEPARATOR ', ') AS logros_obtenidos
                                          FROM usuarios
                                          LEFT JOIN progreso_usuario ON usuarios.id = progreso_usuario.id_usuario
                                          LEFT JOIN logros ON progreso_usuario.id_logro = logros.id
                                          GROUP BY usuarios.id");
    
        $usuariosConLogros = [];
        while ($row = $result->fetch_assoc()) {
            $usuariosConLogros[] = $row;
        }
    
        $result->free_result();
    
        return $usuariosConLogros;
    }
}
