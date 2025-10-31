#!/usr/bin/php
<?php


    $comando = isset($argv[1])? $argv[1] : '';



    switch($comando)
    {
        case 'saludar':
            echo saludar(isset($argv[2])? $argv[2] : 'invitado');
        break;
        case 'sumar':

            $sumando1 = isset($argv[2])? $argv[2]: 0;
            $sumando2 = isset($argv[3])? $argv[3]: 0;

            echo sumar($sumando1, $sumando2);
        break;
        case 'sumar-todos':

            echo sumar_todos($argc,$argv);


        break;

        case 'es-primo':

            $numero = isset($argv[2])? $argv[2] : 0;

            /*
            if (es_primo($numero))
            {
                echo "{$numero} es un número primo" . PHP_EOL;
            }
            else
                echo "{$numero} NO es un número primo" . PHP_EOL;
            */

            echo "{$numero}". (es_primo($numero)? '' : ' NO') ." es un número primo" . PHP_EOL;

        break;

        case 'palabra-mas-larga':

            echo palabra_mas_larga($argv[2]);

        break;

        case 'estadisticas':
            echo estadisticas($argc,$argv);
        break;




        default:
            echo "
                Herramientas para hacer distintas aplicaciones:
                php toolbox.php saludar [nombre]
                php toolbox.php estadisticas n1 n2 n3 ...
                php palabra-mas-larga \"texto con varias palabras\"
                php toolbox.php sumar a b
                php toolbox.php sumar-todos 1 2 3 4 5
                php toolbox.php es-primo 29
            ";
        break;
    }


    function estadisticas($argc,$argv)
    {
        $mas_grande = 0;

        $mas_peque = '';

        $media = 0;

        for ($i= 2;$i < $argc ; $i++)
        {
            $numero_siguiente = $argv[$i];


            if ($numero_siguiente > $mas_grande)
                $mas_grande = $numero_siguiente;

            if ($numero_siguiente < $mas_peque)
                $mas_peque = $numero_siguiente;

            $media +=  $numero_siguiente;

        }

        $media = $media / $argc - 2;

        return " min={$mas_peque}, max={$mas_grande}, media={$media}";
    }

    function palabra_mas_larga($frase)
    {

        $palabras = explode(' ',$frase);

        $palabra_mas_larga = '';

        for ($i=0 ; $i < count($palabras);$i++)
        {
            $palabra_candidata = str_replace(',','',$palabras[$i]);
            $palabra_candidata = str_replace('.','',$palabra_candidata);

            if (strlen($palabra_candidata) > strlen($palabra_mas_larga))
            {
                $palabra_mas_larga = $palabra_candidata;
            }
        }

        return  $palabra_mas_larga;
    }


    function es_primo($numero)
    {
        $es_primo = True;

        $i = 2;
        while($i < $numero)
        {
            if ($numero % $i  == 0)
            {
                $es_primo = false;
                break;
            }

            $i++;
        }


        return $es_primo;
    }



    function sumar_todos($argc,$argv)
    {
        $sumatorio = 0;

        for ($i= 2;$i < $argc ; $i++)
        {
            $sumatorio += $argv[$i];
        }

        return $sumatorio;
    }

    function sumar(int $sumando1 = 0, int $sumando2 = 0): int
    {
        return $sumando1 + $sumando2;
    }


    function saludar(string $nombre): string
    {
        return "Hola, {$nombre}";
    }
 