<?php
class Database {
    public static $db;
    public static $con;

    private $user;
    private $pass;
    private $host;
    private $ddbb;
    private $charset;

    public function __construct(){
        // Ruta al config.ini (un nivel arriba desde este archivo)
        $configPath = __DIR__ . "/../config.ini";

        if (is_readable($configPath)) {
            $cfg = parse_ini_file($configPath, true, INI_SCANNER_TYPED);
            $db   = $cfg['database'] ?? [];

            $this->user    = isset($db['user'])    ? trim($db['user'])    : 'bookmedik_user';
            $this->pass    = isset($db['password'])? trim($db['password']): '';
            $this->host    = isset($db['host'])    ? trim($db['host'])    : 'localhost';
            $this->ddbb    = isset($db['dbname'])  ? trim($db['dbname'])  : 'bookmedik';
            $this->charset = isset($db['charset']) ? trim($db['charset']) : 'utf8mb4';
        } else {
            // Fallback seguro si falta config.ini — no dejar contraseñas en el código
            $this->user = 'bookmedik_user';
            $this->pass = '';
            $this->host = 'localhost';
            $this->ddbb = 'bookmedik';
            $this->charset = 'utf8mb4';
        }
    }

    public function connect(){
        $con = new mysqli($this->host, $this->user, $this->pass, $this->ddbb);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Intentamos establecer charset; si falla, lo registramos sin romper la app
        if (!$con->set_charset($this->charset)) {
            error_log('No se pudo establecer el charset ' . $this->charset . ': ' . $con->error);
        }

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

