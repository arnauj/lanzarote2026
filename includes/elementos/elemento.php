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
    }

    function pintar()
    {
        if ($this->disabled)
            $this->disabled = ' disabled="disabled" ';

        if($this->error)
        {
            $this->literal_error = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
            $this->style_error   = 'error';
        }

        if($this->esqueleto)
        {
            $previo_envoltorio = "
            <div class=\"mb-3\">
                <label for=\"id{$this->nombre}\" class=\"form-label\">". Idioma::lit($this->nombre)."</label>
            ";
            $post_envoltorio = "</div>";
        }


        return "
            {$previo_envoltorio}
                {$this->literal_error}
                <input {$this->disabled} value=\"". Campo::val($this->nombre) ."\" name=\"{$this->nombre}\" type=\"{$this->type}\" class=\"{$this->style_error} form-control\" id=\"id{$this->nombre}\" placeholder=\"". Idioma::lit('placeholder'.$this->nombre)."\">
            {$post_envoltorio}
        ";
    }



    function validar()
    {

    }
}