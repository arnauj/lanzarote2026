<?php

    class Password extends Elemento
    {

        function __construct($datos=[])
        {
            $datos['type'] = 'password';

            parent::__construct($datos);

        }

        function validar()
        {
            if(    empty(Campo::val($this->nombre))
                || strlen(Campo::val($this->nombre)) <= 5
            )
            {
                $this->error = True;
                Formulario::$numero_errores++;
            }
        }

    }