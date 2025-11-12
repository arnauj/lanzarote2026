<?php


define('BOTON_ENVIAR',"<button type=\"submit\" class=\"btn btn-primary\">". Idioma::lit('enviar'.Campo::val('oper'))."</button>");

class Usuario
{

    static $nick;


    static function pintar()
    {
        $contenido = '';
        $volver = "<a style=\"float:right\" href=\"/usuarios/\" class=\"btn btn-light\"><i class=\"bi bi-arrow-return-left\"></i> ".Idioma::lit('volver')."</a>";

        self::inicializacion_campos();

        switch(Campo::val('oper'))
        {
            case 'cons':
                $contenido = self::cons();
            break;
            case 'modi':
                $contenido = self::modi();
            break;
            case 'baja':
                $contenido = self::baja();
            break;
            case 'alta':
                $contenido = self::alta();
            break;
            default:
                $contenido = self::listado();
                $volver = '';
            break;
        }

      
        

      
        return "
        <div class=\"container contenido\">
        <section class=\"page-section usuarios\" id=\"usuarios\">
            <h1>". Idioma::lit('titulo'.Campo::val('oper'))." ". Idioma::lit(Campo::val('seccion')) ."</h1>
            {$contenido}
            {$volver}
        </section>
        </div>
        
        ";


    }

    static function inicializacion_campos()
    {
        self::$nick = new Text(['nombre' => 'nick']);

    }

    static function validacion()
    {

        //$errores = stdclass();
        $errores = [];
        $errores['cantidad'] = 0;
        if(Campo::val('paso'))
        {

            self::$nick->validar();

            if(empty(Campo::val('password')))
            {
                $errores['literal_error_password'] = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $errores['style_error_password']   = 'error';
                $errores['cantidad']++;
            }

            if(empty(Campo::val('nombre')))
            {
                $errores['literal_error_nombre'] = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $errores['style_error_nombre']   = 'error';
                $errores['cantidad']++;
            }
            if(empty(Campo::val('apellidos')))
            {
                $errores['literal_error_apellidos'] = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $errores['style_error_apellidos']   = 'error';
                $errores['cantidad']++;
            }

            if(!preg_match(EREG_VALIDACION_EMAIL, Campo::val('email')))
            {
                $errores['literal_error_email'] = ' <span class="error">'. Idioma::lit('valor_obligatorio') .'</span>';
                $errores['style_error_email'] = 'error';
                $errores['cantidad']++;
            }

        }

        return $errores;

    }

    static function formulario($boton_enviar='',$errores=[],$mensaje_exito='',$disabled='')
    {
        self::$nick->disabled = $disabled;
        
        return "
        {$mensaje_exito}
        <form action=\"/usuarios/\" method=\"POST\">
            <input type=\"hidden\" name=\"paso\" value=\"1\" />
            <input type=\"hidden\" name=\"oper\" value=\"". Campo::val('oper') ."\" />
            <input type=\"hidden\" name=\"id\"   value=\"". Campo::val('id') ."\" />
            ". self::$nick->pintar() ."


            <div class=\"mb-3\">
                <label for=\"idpassword\" class=\"form-label\">". Idioma::lit('password')."</label>
                {$errores['literal_error_password']}
                <input {$disabled} value=\"". Campo::val('password') ."\" name=\"password\" type=\"password\" class=\"{$errores['style_error_password']} form-control\" id=\"idpassword\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idnombre\" class=\"form-label\">". Idioma::lit('nombre')."</label>
                {$errores['literal_error_nombre']}
                <input {$disabled} value=\"". Campo::val('nombre') ."\" name=\"nombre\" type=\"text\" class=\"{$errores['style_error_nombre']} form-control\" id=\"idnombre\" placeholder=\"". Idioma::lit('escribe_tu_nombre')."\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idapellidos\" class=\"form-label\">". Idioma::lit('apellidos')."</label>
                {$errores['literal_error_apellidos']}
                <input {$disabled} value=\"". Campo::val('apellidos') ."\" name=\"apellidos\" type=\"text\" class=\"{$errores['style_error_apellidos']} form-control\" id=\"idapellidos\" placeholder=\"". Idioma::lit('escribe_tus_apellidos')."\">
            </div>

            <div class=\"mb-3\">
                <label for=\"idemail\" class=\"form-label\">". Idioma::lit('email')."</label>
                {$errores['literal_error_email']}
                <input {$disabled} value=\"". Campo::val('email') ."\" name=\"email\" type=\"email\" class=\"{$errores['style_error_email']} form-control\" id=\"idemail\" placeholder=\"name@example.com\">
            </div>
            {$boton_enviar}
        </form>
        ";
    }

    static function sincro_form_bbdd($registro)
    {
        Campo::val('nick'     ,$registro['nick']);
        Campo::val('nombre'   ,$registro['nombre']);
        Campo::val('apellidos',$registro['apellidos']);
        Campo::val('email'    ,$registro['email']);

    }


    static function cons()
    {
        $query = new Query("
            SELECT *
            FROM   usuarios
            WHERE  id = '". Campo::val('id') ."'
        ");

        $registro = $query->recuperar();

        self::sincro_form_bbdd($registro);

        return self::formulario('',[],''," disabled=\"disabled\" ");
    }

    static function baja()
    {
        $boton_enviar = BOTON_ENVIAR;
        $errores = [];
        $mensaje_exito='';
        $disabled =" disabled=\"disabled\" ";
        if(!Campo::val('paso'))
        {
            $query = new Query("
                SELECT *
                FROM   usuarios
                WHERE  id = '". Campo::val('id') ."'
            ");

            $registro = $query->recuperar();

            self::sincro_form_bbdd($registro);

        }
        else
        {
            $query = new Query("
                UPDATE usuarios
                SET  fecha_baja = CURRENT_DATE
                WHERE id = '". Campo::val('id') ."';
            
            ");
            $mensaje_exito = '<p class="centrado alert alert-success" >' . Idioma::lit('operacion_exito') .  '</p>';

            $boton_enviar = '';
        }

        return self::formulario($boton_enviar,$errores,$mensaje_exito,$disabled);
    }

    static function modi()
    {
        $boton_enviar = BOTON_ENVIAR;
        $errores = [];
        $mensaje_exito='';
        $disabled='';
        if(!Campo::val('paso'))
        {
            $query = new Query("
                SELECT *
                FROM   usuarios
                WHERE  id = '". Campo::val('id') ."'
            ");

            $registro = $query->recuperar();

            self::sincro_form_bbdd($registro);

        }
        else
        {

            $errores = self::validacion();

            if(!$errores['cantidad'])
            {


                $query = new Query("
                    UPDATE usuarios
                    SET  nick      = '". Campo::val('nick')      ."'
                        ,nombre    = '". Campo::val('nombre')    ."'
                        ,apellidos = '". Campo::val('apellidos') ."'
                        ,email     = '". Campo::val('email')     ."'
                        ,password  = '". Campo::val('password')  ."'
                    WHERE id = '". Campo::val('id') ."';
                
                ");
                $mensaje_exito = '<p class="centrado alert alert-success" >' . Idioma::lit('operacion_exito') .  '</p>';

                $disabled =" disabled=\"disabled\" ";
                $boton_enviar = '';
            }


        }

        return self::formulario($boton_enviar,$errores,$mensaje_exito,$disabled);
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
        $boton_enviar = BOTON_ENVIAR;
        $errores = [];
        $mensaje_exito='';
        $disabled='';
        if(Campo::val('paso'))
        {

            $errores = self::validacion();

            if(!$errores['cantidad'])
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

        return self::formulario($boton_enviar,$errores,$mensaje_exito,$disabled);

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
            WHERE  fecha_baja > CURRENT_DATE

            ORDER BY nick
            limit ". LISTADO_TOTAL_POR_PAGINA ."
            offset {$offset}
            

        ");



        $listado_usuarios= '';
        while ($registro = $query->recuperar())
        {

            $botonera = "
                <a href=\"/usuarios/cons/{$registro['id']}\" class=\"btn btn-secondary\"><i class=\"bi bi-search\"></i></a>
                <a href=\"/usuarios/modi/{$registro['id']}\" class=\"btn btn-primary\"><i class=\"bi bi-pencil-square\"></i></a>
                <a href=\"/usuarios/baja/{$registro['id']}\" class=\"btn btn-danger\"><i class=\"bi bi-trash\"></i></a>
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
            <a href=\"/usuarios/alta\" class=\"btn btn-primary\"><i class=\"bi bi-file-earmark-plus\"></i> Alta usuario</a>
            ";

    }



}