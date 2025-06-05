<?php
class Conexion {
    private static $host = 'localhost';
    private static $db = 'registro_app';
    private static $user = 'root';
    private static $pass = '';  // Asegúrate de que la contraseña sea correcta para tu instalación de Laragon
    public static function conectar() {
        $mysqli = new mysqli(self::$host, self::$user, self::$pass, self::$db);
        if ($mysqli->connect_errno) {
            die('Error de conexión: ' . $mysqli->connect_error);
        }
        $mysqli->set_charset('utf8mb4');
        return $mysqli;
    }
}
