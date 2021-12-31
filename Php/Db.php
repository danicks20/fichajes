<?
    // Db connection
    namespace Db;

    class Db {

        private $servername;
        private $username;
        private $password;
        private $mysqli;
        private $database;
        
        public function __construct() {
            require(BASEDIR."/Config/db_config.php");
            $this->servername = $db_cf->host;
            $this->username = $db_cf->username;
            $this->password = $db_cf->pass;
            $this->database = $db_cf->database;

            // Create connection
            $this->mysqli = new \mysqli($this->servername, $this->username, $this->password, $this->database);
            // Check connection
            if ($this->mysqli->connect_error) {
                die("Connection failed: " . $this->mysqli->connect_error);
            }

            /* cambiar el conjunto de caracteres a utf8 */
            if (!$this->mysqli->set_charset("utf8")) {
                printf("Error cargando el conjunto de caracteres utf8: %s\n", $this->mysqli->error);
                exit();
            }

            // Set locale 
            $this->mysqli->query("SET lc_time_names = 'es_ES'");
        }

        public function query($sql) {
            if ($res = $this->mysqli->query($sql)) {
                return $res;
            }else{
                die($this->mysqli->error);
            }
        }

    }   

?>