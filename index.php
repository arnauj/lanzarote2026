<?php

    require "includes/general.php";

    echo Template::header('Biblioteca');
    echo Template::nav();


    echo Template::seccion(Campo::val('seccion'));

    echo Template::footer(); 
    
    
?>