<?php

    class Hidden extends Elemento
    {

        function __construct($datos=[])
        {
            $datos['type']      = 'hidden';
            $datos['esqueleto'] = False;
            
            parent::__construct($datos);

        }

        function validar()
        {
            $this->error = False;
        }

    }