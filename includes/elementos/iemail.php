<?php

    class IEmail extends Elemento
    {

        function __construct($datos=[])
        {
            $datos['type'] = 'email';

            parent::__construct($datos);

        }

        function validar()
        {
            if(empty(Campo::val($this->nombre)))
            {
                $this->error = True;
                Formulario::$numero_errores++;
            }
        }

    }