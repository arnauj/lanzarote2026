<?php

class Curso extends Base
{
    function __construct()
    {
        $this->tabla = 'cursos';
    }


    function cargar()
    {
        $datos = [];
        $datos['select'] = 'id, nombre_grado, curso_numero, letra';

        $datos_consulta = $this->get_rows($datos);


        $cursos = [];


        foreach($datos_consulta as $inc => $registro)
        {

            $cursos[$registro['id']] = $registro['curso_numero'].' '.$registro['nombre_grado']. ' '. $registro['letra'];
        }

        return $cursos;


    }

}