<?php

    require "includes/general.php";

    echo Template::header('Biblioteca');
    echo Template::nav();

    echo Template::seccion($_GET['seccion']);

    echo Template::footer(); 
    
    
?>