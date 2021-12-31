<?
    namespace RegistroHora;
    require(BASEDIR."/Php/Db.php");

    use Db\Db;

    class RegistroHora extends Db
    {
        // Listar registros del dia actual
        public function getAllRegistrosToday() {
            $today = date("Y/m/d");
            $sql = "SELECT * FROM registros WHERE fecha = '$today'";
            $res = $this->query($sql);
            return $res;
        }

        // Registrar entrada
        public function registrarEntrada($empresa){
            if (!$this->cierrePending()){
                $sql = "INSERT INTO registros (empresa, fecha, hora_entrada) VALUES ('$empresa', now(), now())";
                $res = $this->query($sql);
            }
        }

        // Registrar salida
        public function registrarSalida(){
            $time = date("H:i:s");
            $sql = "UPDATE registros SET hora_salida=now(), tiempo_total=time(SUBTIME(NOW(), hora_entrada)) WHERE hora_salida IS NULL";
            $res = $this->query($sql);
        }

        // Obtener el tiempo total trabajado del dia actual
        public function getTotalTime(){
            $time = "00:00:00";
            $today = date("Y/m/d");

            // obtener las franjas completas
            $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo_total))) as total FROM registros  WHERE fecha = '$today' and tiempo_total IS NOT NULL";
            $res = $this->query($sql);
            $row = $res->fetch_array(MYSQLI_ASSOC);
    
            if ($row['total']){
                $time = $row['total'];
            }

            // Obtener franja pendiente de cierre
            $sql = "SELECT hora_entrada FROM registros  WHERE fecha = '$today' AND hora_salida IS NULL";
            $res = $this->query($sql);
            $row = $res->fetch_array(MYSQLI_ASSOC);
            if ($res->num_rows){
                $hora_entrada = $row['hora_entrada'];
                $diferencia = $this->diff2horas(date("H:i:s"), $hora_entrada);
                $time = $this->suma2horas($time, $diferencia);
            }

            return $time;

        }

        // Comprobar si queda algun cierre pendiente
        public function cierrePending(){
            
            $sql = "SELECT * FROM registros  WHERE hora_salida IS null";
            $res = $this->query($sql);

            if ($res->num_rows > 0){
                return true;
            }else{
                return false;
            }
        }

        // Devolver filtrado de registros
        public function filtroRegistros($form){
            
            $empresas = [];

            if (isset($form['groupByDays'])){
                $sql = "SELECT id, empresa, fecha, DAYNAME(fecha) as dia, '' as hora_entrada, '' as hora_salida, 
                        SEC_TO_TIME(SUM(TIME_TO_SEC(tiempo_total))) AS tiempo_total 
                        FROM registros WHERE 1=1 ";
            }else{
                $sql = "SELECT id, empresa, fecha, DAYNAME(fecha) as dia, hora_entrada, 
                        hora_salida, tiempo_total 
                        FROM registros  WHERE 1=1 ";
            }

            if (isset($form['fecha_desde'])) $sql .= "AND fecha >= '{$form['fecha_desde']}' ";
            if (isset($form['fecha_hasta'])) $sql .= "AND fecha <= '{$form['fecha_hasta']}' ";

            if (isset($form['kike'])) $empresas[] = 'Kike';
            if (isset($form['edu'])) $empresas[] = 'Edu';
            if (isset($form['emilio'])) $empresas[] = 'Emilio';

            if (count($empresas) > 0){
                $str_empresas = implode ("','", $empresas);
                $filter_empresas = "('$str_empresas')";
                $sql .= "AND empresa in " . $filter_empresas; 
            }

            if (isset($form['groupByDays'])){
                $sql .= " GROUP BY fecha, empresa";
            }

            $sql .= " ORDER BY fecha";

            $res = $this->query($sql);
            $data = $res->fetch_all(MYSQLI_ASSOC);
            return $data;
        }

        // Devolver el tiempo total filtrado
        public function sumTotalFilter($empresa, $f_desde, $f_hasta){
            $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`tiempo_total`))) AS timeSum  FROM registros  WHERE fecha >= '$f_desde' AND fecha <= '$f_hasta' and empresa = '$empresa'";
            $res = $this->query($sql);
            $data = $res->fetch_array(MYSQLI_ASSOC);
            return $data['timeSum'];
        }

        // Funcion suma 2 horas
        public function suma2horas($hora1, $hora2){
            list($h, $m, $s) = explode(':', $hora2); //Separo los elementos de la segunda hora
            $a = new \DateTime($hora1); //Creo un objeto DateTime
            $b = new \DateInterval(sprintf('PT%sH%sM%sS', $h, $m, $s)); //Creo un objeto DateInterval
            $a->add($b); //Sumo las horas
            return $a->format('H:i:s'); //Retorno la suma
        }

        // Funcion direferencia entre 2 horas
        public function diff2horas($hora1, $hora2){
            $h1 = new \DateTime($hora1);
            $h2 = new \DateTime($hora2);
            $diff = $h1->diff($h2);
            return str_pad($diff->h, 2, "0", STR_PAD_LEFT) . ':' . 
                    str_pad($diff->i, 2, "0", STR_PAD_LEFT) . ':' . 
                    str_pad($diff->s, 2, "0", STR_PAD_LEFT);
        }
    }

?>