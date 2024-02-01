<?php
include_once '../src/BaseDatos/Conexion.php';

class Usuario {
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
}
