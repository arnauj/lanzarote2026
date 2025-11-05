<?php


    class Query{

        private mysqli $conexion;
        private $resultado = null;
        public int $total = 0;


        public function __construct(string $sql)
        {
            $this->conexion = BBDD::getInstancia()->getConexion();

            $this->resultado = $this->conexion->query($sql);

            if($this->resultado === false)
            {
                throw new Exception("Error en la consulta" . $this->conexion->error);
            }

            //Si es un Select, guardamos el número de registros

            if(gettype($this->resultado) == "boolean")
                $this->total = 1;
            elseif($this->resultado instanceof mysqli_result)
                $this->total = $this->resultado->num_rows;
            else
                $this->total = $this->resultado->affected_rows;

            return $this;
        }

        public function recuperar(){

            if (!$this->resultado instanceof mysqli_result)
            {
                return null;
            }

            $registro = $this->resultado->fetch_assoc();
            if ($registro == null)
            {
                $this->resultado->free();
                $this->resultado = null;
            }

            return $registro;
            
        }


        public function getLastInsertId(){
            return $this->conexion->insert_id;
        }


    }


    /*
    $query = new Query("
        SELECT *
        FROM   usuarios
        WHERE nombre = 'Jaime'
    ");

    $registro = $query->recuperar();
    
    $query->total;
    */