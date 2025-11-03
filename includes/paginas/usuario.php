<?php

class Usuario
{



    static function pintar()
    {
        if(is_numeric($_GET['pagina']))
        {
            $pagina = $_GET['pagina'];
            $offset = 10 * $pagina;
        }
        else{
            $offset = '0';
        }
        $pagina++;


        $query = new Query("
            SELECT * 
            FROM   usuarios

            ORDER BY nick
            limit 10
            offset {$offset}
            

        ");



        $listado_usuarios= '';
        while ($registro = $query->recuperar())
        {

            $botonera = "
                <a href=\"/?seccion=usuarios&oper=cons&id={$registro['id']}\" class=\"btn btn-secondary\"><i class=\"bi bi-search\"></i></a>
                <a href=\"/?seccion=usuarios&oper=modi&id={$registro['id']}\" class=\"btn btn-primary\"><i class=\"bi bi-pencil-square\"></i></a>
                <a href=\"/?seccion=usuarios&oper=dele&id={$registro['id']}\" class=\"btn btn-danger\"><i class=\"bi bi-trash\"></i></a>
            ";

            $listado_usuarios .= "
                <tr>
                    <th scope=\"row\">{$botonera}</th>
                    <td>{$registro['nick']}</td>
                    <td>{$registro['nombre']}</td>
                    <td>{$registro['apellidos']}</td>
                    <td>{$registro['email']}</td>
                    <td>{$registro['fecha_alta']}</td>
                    <td>{$registro['fecha_baja']}</td>
                </tr>
            ";

        }

        $pagina_anterior = ($pagina != 1)? "<li class=\"page-item\"><a class=\"page-link\" href=\"/?seccion=usuarios&oper=list&pagina=". ($pagina-2) ."\">Anterior</a></li>" : '';








        return "
        <div class=\"container contenido\">
        <section class=\"page-section usuarios\" id=\"usuarios\">
            <table class=\"table\">
            <thead>
                <tr>
                <th scope=\"col\">#</th>
                <th scope=\"col\">Nick</th>
                <th scope=\"col\">Nombre</th>
                <th scope=\"col\">Apellidos</th>
                <th scope=\"col\">Email</th>
                <th scope=\"col\">Fecha Alta</th>
                <th scope=\"col\">Fecha Baja</th>
                </tr>
            </thead>
            <tbody>
            {$listado_usuarios}
            </tbody>
            </table>

            <nav>
                <ul class=\"pagination\">
                    {$pagina_anterior}
                    <li class=\"page-item\"><a class=\"page-link\" href=\"/?seccion=usuarios&oper=list&pagina={$pagina}\">Siguiente</a></li>
                </ul>
            </nav>



            <a href=\"/?seccion=usuarios&oper=alta&id=\" class=\"btn btn-primary\"><i class=\"bi bi-file-earmark-plus\"></i> Alta usuario</a>
        </section>
        </div>
        
        ";


    }
}