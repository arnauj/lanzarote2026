<?php



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
    }

});
