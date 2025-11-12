<?php

    class Text extends Elemento
    {

        function __construct($datos=[])
        {
            parent::__construct($datos);

        }

        function validar()
        {
            if(empty(Campo::val($this->nombre)))
            {
                $this->error = True;
            }
        }

    }