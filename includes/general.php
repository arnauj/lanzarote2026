<?php

define('LISTADO_TOTAL_POR_PAGINA',10);

define('EREG_VALIDACION_EMAIL', '/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/');

//Devuelve fechas en formato dd/mm/yyyy
function fmto_fecha($aaaammdd,$separador = '/')
{

    $aaaammdd = str_replace('-','',$aaaammdd);

    $anho = substr($aaaammdd,0,4);
    $mes  = substr($aaaammdd,4,2);
    $dia  = substr($aaaammdd,6,2);

    return "{$dia}{$separador}{$mes}{$separador}{$anho}";
}



spl_autoload_register(function ($class) {

    switch($class)
    {
        case 'Query':
            require_once "includes/bbdd/query.php";
        break;
        case 'BBDD':
            require_once "includes/bbdd/bbdd.php";
        break;
        case 'Template':
            require_once "includes/template.php";
        break;
        case 'Idioma':
            require_once "includes/idioma.php";
        break;
        case 'PortadaController':
            require_once "includes/paginas/portada.controller.php";
        break;
        case 'UsuarioController':
            require_once "includes/paginas/usuario.controller.php";
        break;
        case 'Campo':
            require_once "includes/campo.php";
        break;
        case 'Elemento':
            require_once "includes/elementos/elemento.php";
        break;
        case 'Text':
            require_once "includes/elementos/text.php";
        break;
        case 'Password':
            require_once "includes/elementos/password.php";
        break;
        case 'Hidden':
            require_once "includes/elementos/hidden.php";
        break;
        case 'IEmail':
            require_once "includes/elementos/iemail.php";
        break;
        case 'Formulario':
            require_once "includes/formulario.php";
        break;
        case 'Base':
                require_once "includes/modelos/base.php";
        break;
        case 'Usuario':
                require_once "includes/modelos/usuario.php";
        break;
    }
});
