<?php

    class Campo
    {
        private static $instancia = null;

        private static $val = array();

        private function __construct()
        {

            foreach($_GET as $campo => $valor)
            {
                if (self::comprobar_inyeccion($valor))
                {
                    self::$val[$campo] = $valor;
                }
            }

            foreach($_POST as $campo => $valor)
            {
                if (self::comprobar_inyeccion($valor))
                {
                    self::$val[$campo] = $valor;
                }
            }

        }

        public static function getInstancia(): Campo {

            if (self::$instancia == null){
                self::$instancia = new Campo();
            }

            return self::$instancia;
        }

        static function val($campo,$set_value = '')
        {
            if(empty($set_value))
            {
                self::getInstancia();
                return self::$val[$campo];
            }
            else
            {
                self::$val[$campo] = $set_value;
            }
        }


        public function __clone(){}


        static function comprobar_inyeccion($valor)
        {

            if (preg_match('/\b(SELECT|UPDATE|DELETE)\b\s+FROM\b/i',$valor))
                die;


            return True;

        }

    }