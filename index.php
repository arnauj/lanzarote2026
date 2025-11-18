<?php

    require "includes/general.php";



    $usuario = new Usuario();


    $datos = [];

    $datos['nick']   = 'jme';
    $datos['nombre'] = 'Jaime';

    $usuario->insertar($datos);



    exit;

    echo Template::header('Biblioteca');
    echo Template::nav();


    echo Template::seccion(Campo::val('seccion'));

    echo Template::footer(); 
    
    
?>