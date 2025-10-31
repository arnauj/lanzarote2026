<?php



    $email  = $_POST['email'];
    $nombre = $_POST['nombre'];
    $edad   = $_POST['edad'];

    $errores = false;

    $error_nombre = $error_email = $error_edad = '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores = true;

        $error_email =" error_email ";
    }


    if (empty($nombre))
    {
        $errores = true;

        $error_nombre =" error_nombre ";
    }


    if (!is_numeric($edad))
    {
        $errores = true;

        $error_edad =" error_edad ";
    }

    $mostrar_errores = '';
    if($errores)
    {
        $mostrar_errores = '
        <div class="alert alert-danger" role="alert">
          Hay errores en el formulario
        </div>
        ';
    }
    else{

        $disabled = ' disabled ';
    }

    require "./formulario.php";


?>
