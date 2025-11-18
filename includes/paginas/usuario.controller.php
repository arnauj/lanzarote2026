<?php


define('BOTON_ENVIAR',"<button type=\"submit\" class=\"btn btn-primary\">". Idioma::lit('enviar'.Campo::val('oper'))."</button>");

class UsuarioController
{

    static $nick,$password,$oper,$id,$paso,$nombre,$apellidos,$email;


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
        self::$paso      = new Hidden(['nombre' => 'paso']);
        self::$oper      = new Hidden(['nombre' => 'oper']);
        self::$id        = new Hidden(['nombre' => 'id']);
        self::$nick      = new Text(['nombre' => 'nick']);
        self::$nombre    = new Text(['nombre' => 'nombre']);
        self::$apellidos = new Text(['nombre' => 'apellidos']);
        self::$password  = new Password(['nombre' => 'password']);
        self::$email     = new IEmail(['nombre' => 'email']);

        Formulario::cargar_elemento(self::$paso);
        Formulario::cargar_elemento(self::$oper);
        Formulario::cargar_elemento(self::$id);
        Formulario::cargar_elemento(self::$nick);
        Formulario::cargar_elemento(self::$password);
        Formulario::cargar_elemento(self::$nombre);
        Formulario::cargar_elemento(self::$apellidos);
        Formulario::cargar_elemento(self::$email);

    }


    static function formulario($boton_enviar='',$errores=[],$mensaje_exito='',$disabled='')
    {
        Formulario::disabled($disabled);

        Campo::val('paso','1');

        return Formulario::pintar('/usuarios/',$boton_enviar,$mensaje_exito);

    }

    static function sincro_form_bbdd($registro)
    {
        Formulario::sincro_form_bbdd($registro);
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

            $numero_errores = Formulario::validacion();

            if(!$numero_errores)
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

            $numero_errores = Formulario::validacion();

            if(!$numero_errores)
            {
                $nuevo_usuario = [];
                $nuevo_usuario['nick']      = Campo::val('nick');
                $nuevo_usuario['nombre']    = Campo::val('nombre');
                $nuevo_usuario['apellidos'] = Campo::val('apellidos');
                $nuevo_usuario['email']     = Campo::val('email');
                $nuevo_usuario['password']  = Campo::val('password');

                $usuario = new Usuario();
                $usuario->insertar($nuevo_usuario);

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