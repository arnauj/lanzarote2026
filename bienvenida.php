<?php
    session_start();

    if (!isset($_SESSION['email']))
    {
        header("location: ./");
    }





    echo $_COOKIE['idioma'].'<<<<<';
    switch($_COOKIE['idioma'])
    {
        case 'FR':
            $texto_bienvenida = "Bienvenue, {$_SESSION['email']}";
        break;
        case 'EN':
            $texto_bienvenida = "Welcome, {$_SESSION['email']}";
        break;
        default:
            $texto_bienvenida = "Bienvenido, {$_SESSION['email']}";
        break;
    }


    if (isset($_POST['email']))
    {
        $_SESSION['email'] = $_POST['email'];
    }


    

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <?php require "includes/menu.php" ?>

        <h1><?php echo $texto_bienvenida; ?></h1>


    <!-- Content here -->
    </div>
</body>
</html>