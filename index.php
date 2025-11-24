<?php

    require "includes/general.php";


    if (Campo::val('modo') == 'ajax')
    {

        header('Content-Type: application/json');

        $salida = [];
 
        $salida['titulo'] = Idioma::lit('titulo'.Campo::val('oper'))." ". Idioma::lit(Campo::val('seccion'));
        $salida['contenido'] = Template::seccion(Campo::val('seccion'));

        echo json_encode($salida);
    }
    else
    {

        echo Template::header(Idioma::lit('title_'.Campo::val('seccion')));
        echo Template::nav();
        echo Template::seccion(Campo::val('seccion'));
    }


    

    


    if (Campo::val('modo') != 'ajax')
    {
        echo Template::footer(); 
    }
    
    
?>