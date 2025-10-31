<?php

    session_start(); // Inicia la sesión

    $_SESSION['usuario'] = "Juanra";

    echo "Usuario en sesión: " . $_SESSION['usuario'];