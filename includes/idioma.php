<?php


class Idioma
{
    private static $instancia = null;

    public static $lit = array();


    private function __construct($idioma='ES')
    {
        $descriptor = fopen($_SERVER['DOCUMENT_ROOT'] .'/lang/es.txt','r');
        if($descriptor)
        {
    
            while ($linea = fgets($descriptor))
            {
                $linea = trim($linea);

                $partes_linea = explode(':',$linea);

                self::$lit[$partes_linea[0]] = $partes_linea[1];
              
            }
        }

        
    }


    public static function getInstancia(): Idioma {

        if (self::$instancia == null){
            self::$instancia = new Idioma();
        }

        return self::$instancia;
    }

    static function lit($campo)
    {
        self::getInstancia();
        return self::$lit[$campo];
    }

    public function __clone(){}



}