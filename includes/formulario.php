<?php

class Formulario
{
    static $elementos = [];

    static $numero_errores = 0;
    
    static function cargar_elemento($elemento)
    {
        self::$elementos[] = $elemento;
    }

    static function validacion()
    {
        if(Campo::val('paso'))
        {

            $contenido = '';
            foreach(self::$elementos as $elemento)
            {
                $elemento->validar();
            }
        }


        return Formulario::$numero_errores;
    }

    static function sincro_form_bbdd($registro)
    {
        foreach($registro as $clave => $valor)
        {
            Campo::val($clave ,$valor);
        }
    }

    static function disabled($disabled)
    {
        foreach(self::$elementos as $elemento)
        {
            $elemento->disabled = $disabled;
        }
    }


    static function pintar($action,$boton_enviar,$mensaje_exito='',$method='POST')
    {
        $contenido = '';
        foreach(self::$elementos as $elemento)
        {
            $contenido .= $elemento->pintar();
        }



        return "
            {$mensaje_exito}
            <form action=\"{$action}\" method=\"$method\" >
            {$contenido}
            {$boton_enviar}
            </form>
        ";


    }

}