<?php
class Conexion {
    private static $conexion = null;
    private static $servername = '127.0.0.1';
    private static $username = 'root';
    private static $password = '';
    private static $dbname = 'logrossystem';

    private function __construct() {}

    public static function obtenerConexion() {
        if (self::$conexion === null) {
            self::$conexion = new mysqli(self::$servername, self::$username, self::$password, self::$dbname);

            if (self::$conexion->connect_error) {
                die("Error de conexión a la base de datos: " . self::$conexion->connect_error);
            }
        }

        return self::$conexion;
    }
}
