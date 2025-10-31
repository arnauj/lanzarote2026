<?php

    require "includes/peliculas.php";

    define('CATEGORIA',$_GET['categoria']);

    $tipos_categoria = [
        'F' => 'Fantasía'
       ,'C' => 'Ciencia Ficción'
    ];





$listado_tarjetas_peliculas = '';
foreach($peliculas as $indice_pelicula => $pelicula)
{
    if (CATEGORIA == '' || CATEGORIA == $pelicula['genero'] )
    {
        $descripcion = $pelicula['director'].' '. $pelicula['anio'].' '. $pelicula['genero'];

        $listado_tarjetas_peliculas .= "

            <div class=\"col-4\">

                <div class=\"card\">
                    <img src=\"{$pelicula['poster']}\" class=\"card-img-top\" alt=\"...\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{$pelicula['titulo']}</h5>
                        <p class=\"card-text\">{$descripcion}</p>
                        <a href=\"/pelicula.php?id={$indice_pelicula}\" class=\"btn btn-primary\">Ver más</a>
                    </div>
                </div>
            </div>
        ";
    }

}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo de cine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/estilos.css">



</head>
<body>
    

    <div class="container">
        <nav class="barra_nav navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Cine Lanzarote</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" action="/catalogo.php">


                    <?php
                        $opciones_categorias = '';
                        foreach($tipos_categoria as $tipo => $nombre_categoria)
                        {
                            $opciones_categorias .= "<option value=\"{$tipo}\">{$nombre_categoria}</option>";
                        }

                    ?>  

                    <select class="form-control me-2" name="categoria" method="GET">
                        <option selected>Categoría</option>
                        <?php echo $opciones_categorias; ?>
                    </select>

                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
                </div>
            </div>
        </nav>
            

        <div class="contenido">

            <div class="row">

                <?php echo $listado_tarjetas_peliculas; ?>

            </div>
        </div>


    </div>


</body>
</html>