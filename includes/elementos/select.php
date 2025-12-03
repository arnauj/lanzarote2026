<?php

    class Select extends Elemento
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
                Formulario::$numero_errores++;
            }
        }

    function pintar()
    {

        $this->previo_pintar();


        $options = empty($this->nombre)? '' : '<option>'. Idioma::lit('placeholder'.$this->nombre) .'</option>';
        foreach($this->options as $value => $literal_value)
        {
            /*
            $selected = '';
            if ($value == Campo::val($this->nombre))
                $selected = 'selected';
            */

            $selected = $value == Campo::val($this->nombre)? 'selected' : '';

            $options .= "<option value=\"{$value}\" {$selected}>{$literal_value}</option>";
        }

        


        $options = "<select class=\"{$this->style} form-select\" id=\"id{$this->nombre}\" {$this->disabled} name=\"{$this->nombre}\">".$options.'</select>';



        return "
            {$this->previo_envoltorio}
                {$this->literal_error}
                {$options}
            {$this->post_envoltorio}
        ";
    }

    }