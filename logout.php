<?php

    session_start();

    unset($_SESSION['email']);


    setcookie('idioma','', time()-60);


    header("location: ./");

?>