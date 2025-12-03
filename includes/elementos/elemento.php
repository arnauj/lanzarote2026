<?php


class Elemento
{   
    function __construct($datos=[])
    {
        $this->nombre        = empty($datos['nombre'])         ? ''    : $datos['nombre'];
        $this->type          = empty($datos['type'])           ? 'text': $datos['type'];
        $this->literal_error = empty($datos['literal_error'])  ? ''    : $datos['literal_error'];
        $this->style_error   = empty($datos['style_error'])    ? ''    : $datos['style_error'];
        $this->disabled      = empty($datos['disabled'])       ? ''    : $datos['disabled'];
       
        $this->esqueleto     = is_null($datos['esqueleto'])    ? True  : $datos['esqueleto'];

        $this->options       = empty($datos['options'])        ? False : $datos['options'];
    }


    protected function previo_pintar()
    {
        if ($this->disabled)
            $this->disabled = ' readonly="readonly" ';

        if($this->error)
        {
            $this->literal_error = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
            $this->style   = 'error';
        }

        if ($this->disabled)
        {
            $this->disabled = ' readonly="readonly" ';
            $this->style   = ' disabled';
        }

        if($this->esqueleto)
        {
            $this->previo_envoltorio = "
            <div class=\"mb-3\">
                <label for=\"id{$this->nombre}\" class=\"form-label\">". Idioma::lit($this->nombre)."</label>
            ";
            $this->post_envoltorio = "</div>";
        }
    }

    function pintar()
    {

        $this->previo_pintar();



        return "
            {$this->previo_envoltorio}
                {$this->literal_error}
                <input {$this->disabled} value=\"". Campo::val($this->nombre) ."\" name=\"{$this->nombre}\" type=\"{$this->type}\" class=\"{$this->style} form-control\" id=\"id{$this->nombre}\" placeholder=\"". Idioma::lit('placeholder'.$this->nombre)."\">
            {$this->post_envoltorio}
        ";
    }



    function validar()
    {

    }
}