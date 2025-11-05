<?php



class Usuario
{



    static function pintar()
    {
        $contenido = '';
        switch(Campo::val('oper'))
        {
            case 'cons':
            break;
            case 'modi':
            break;
            case 'baja':
            break;
            case 'alta':
                $contenido = self::alta();
            break;
            default:
                $contenido = self::listado();
            break;
        }
      







        return "
        <div class=\"container contenido\">
        <section class=\"page-section usuarios\" id=\"usuarios\">
            <h1>". Idioma::lit('titulo'.Campo::val('oper')) ."</h1>
            {$contenido}
        </section>
        </div>
        
        ";


    }


    static function alta()
    {

        /*
            ,nick          VARCHAR(255) NOT NULL
            ,nombre        VARCHAR(255)
            ,apellidos     VARCHAR(255)
            ,email         VARCHAR(255)
            ,password      VARCHAR(255)
        */
        $boton_enviar = "<button type=\"submit\" class=\"btn btn-primary\">". Idioma::lit('enviar')."</button>";
        $literal_error_nick = '';
        $errores = False;
        if(Campo::val('paso'))
        {
            if(empty(Campo::val('nick')))
            {
                $literal_error_nick = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $style_error_nick = 'error';
                $errores = True;
            }

            if(empty(Campo::val('password')))
            {
                $literal_error_password = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $style_error_password = 'error';
                $errores = True;
            }

            if(empty(Campo::val('nombre')))
            {
                $literal_error_nombre = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $style_error_nombre = 'error';
                $errores = True;
            }
            if(empty(Campo::val('apellidos')))
            {
                $literal_error_apellidos = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $style_error_apellidos = 'error';
                $errores = True;
            }

            if(!preg_match(EREG_VALIDACION_EMAIL, Campo::val('email')))
            {
                $literal_error_email = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $style_error_email = 'error';
                $errores = True;
            }


            if(!$errores)
            {
                $query = new Query("
                    INSERT INTO usuarios
                    (
                         nick        
                        ,nombre      
                        ,apellidos   
                        ,email       
                        ,password    
                    )
                    VALUES
                    (
                         '". Campo::val('nick')      ."'
                        ,'". Campo::val('nombre')    ."'
                        ,'". Campo::val('apellidos') ."'
                        ,'". Campo::val('email')     ."'
                        ,'". Campo::val('password')  ."'
                    );
                
                ");
                $mensaje_exito = '<p class="centrado alert alert-success" >' . Idioma::lit('operacion_exito') .  '</p>';

                $disabled =" disabled=\"disabled\" ";
                $boton_enviar = '';
            }


        }

        return "
        {$mensaje_exito}
        <form action=\"/?seccion=usuarios\" method=\"POST\">
            <input type=\"hidden\" name=\"paso\" value=\"1\" />
            <input type=\"hidden\" name=\"oper\" value=\"alta\" />
            <div class=\"mb-3\">
                <label for=\"idnick\" class=\"form-label\">". Idioma::lit('nick')."</label>
                {$literal_error_nick}
                <input {$disabled} value=\"". Campo::val('nick') ."\" name=\"nick\" type=\"text\" class=\"{$style_error_nick} form-control\" id=\"idnick\" placeholder=\"". Idioma::lit('pseudonimo')."\">
            </div>
            <div class=\"mb-3\">
                <label for=\"idpassword\" class=\"form-label\">". Idioma::lit('password')."</label>
                {$literal_error_password}
                <input {$disabled} value=\"". Campo::val('password') ."\" name=\"password\" type=\"password\" class=\"{$style_error_password} form-control\" id=\"idpassword\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idnombre\" class=\"form-label\">". Idioma::lit('nombre')."</label>
                {$literal_error_nombre}
                <input {$disabled} value=\"". Campo::val('nombre') ."\" name=\"nombre\" type=\"text\" class=\"{$style_error_nombre} form-control\" id=\"idnombre\" placeholder=\"". Idioma::lit('escribe_tu_nombre')."\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idapellidos\" class=\"form-label\">". Idioma::lit('apellidos')."</label>
                {$literal_error_apellidos}
                <input {$disabled} value=\"". Campo::val('apellidos') ."\" name=\"apellidos\" type=\"text\" class=\"{$style_error_apellidos} form-control\" id=\"idapellidos\" placeholder=\"". Idioma::lit('escribe_tus_apellidos')."\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idemail\" class=\"form-label\">". Idioma::lit('email')."</label>
                {$literal_error_email}
                <input {$disabled} value=\"". Campo::val('email') ."\" name=\"email\" type=\"email\" class=\"{$style_error_email} form-control\" id=\"idemail\" placeholder=\"name@example.com\">
            </div>
            {$boton_enviar}
        </form>
        ";



    }


    static function listado()
    {
        if(is_numeric(Campo::val('pagina')))
        {
            $pagina = Campo::val('pagina');
            $offset = LISTADO_TOTAL_POR_PAGINA * $pagina;
        }
        else{
            $offset = '0';
        }
        $pagina++;


        $query = new Query("
            SELECT * 
            FROM   usuarios

            ORDER BY nick
            limit ". LISTADO_TOTAL_POR_PAGINA ."
            offset {$offset}
            

        ");



        $listado_usuarios= '';
        while ($registro = $query->recuperar())
        {

            $botonera = "
                <a href=\"/?seccion=usuarios&oper=cons&id={$registro['id']}\" class=\"btn btn-secondary\"><i class=\"bi bi-search\"></i></a>
                <a href=\"/?seccion=usuarios&oper=modi&id={$registro['id']}\" class=\"btn btn-primary\"><i class=\"bi bi-pencil-square\"></i></a>
                <a href=\"/?seccion=usuarios&oper=baja&id={$registro['id']}\" class=\"btn btn-danger\"><i class=\"bi bi-trash\"></i></a>
            ";

            $listado_usuarios .= "
                <tr>
                    <th scope=\"row\">{$botonera}</th>
                    <td>{$registro['nick']}</td>
                    <td>{$registro['nombre']}</td>
                    <td>{$registro['apellidos']}</td>
                    <td>{$registro['email']}</td>
                    <td>". fmto_fecha($registro['fecha_alta']) . "</td>
                    <td>". fmto_fecha($registro['fecha_baja']) . "</td>
                </tr>
            ";

        }


        $barra_navegacion = Template::navegacion($query->total,$pagina);


        return "
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
            {$barra_navegacion}
            <a href=\"/?seccion=usuarios&oper=alta&id=\" class=\"btn btn-primary\"><i class=\"bi bi-file-earmark-plus\"></i> Alta usuario</a>
            ";

    }



}