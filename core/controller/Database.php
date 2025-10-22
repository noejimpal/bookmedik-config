<?php
class Database {
    public static $db;
    public static $con;

    public function __construct(){
        $this->user = "bookmedik_user";   // Usuario de la base de datos
        $this->pass = "1234";             // Contraseña de la base de datos
        $this->host = "localhost";        // Host de la base de datos
        $this->ddbb = "bookmedik";        // Nombre de la base de datos
    }

    public function connect(){
        $con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->query("SET NAMES utf8"); // Configuración de codificación
        return $con;
    }

    public static function getCon(){
        if(self::$con == null && self::$db == null){
            self::$db = new Database();
            self::$con = self::$db->connect();
        }
        return self::$con;
    }
}
?>

