<?php

    class Template
    {

        public function __construct($templateDir='tpl')
        {
            $this->templateDir = rtrim($templateDir,'/');
        }

        public function render($file,$vars = [])
        {
            $path = "{$this->templateDir}/{$file}.tpl";

            if (!file_exists($path))
                throw new Exception("La plantilla {$file} no existe en {$this->templateDir}");

            $contenido = file_get_contents($path);
            


            foreach($vars as $key => $value)
            {
                $contenido = preg_replace('/{{\s*'. preg_quote($key,'/') .'\s*}}/', htmlspecialchars($value),$contenido );
            }

            return $contenido;
        }

        
        

        static function header($titulo,$descripcion='',$author='1DAW')
        {
            $template = new Template();

            return $template->render('header',[
                'titulo'      => $titulo
               ,'description' => $descripcion
               ,'author'      => $author
            ]);

        }


        static function nav()
        {

            $template = new Template();

            return $template->render('navegacion',[
                'portfolio' => Idioma::lit('portfolio')
               ,'acercade'  => Idioma::lit('acercade')
               ,'contacto'  => Idioma::lit('contacto')
               ,'usuarios'  => Idioma::lit('usuarios')
            ]);

        }


        static function footer(){
            
            $template = new Template();

            return $template->render('footer');

        }


        static function seccion($seccion)
        {

            switch($seccion)
            {
                case 'usuarios':
                    $contenido = UsuarioController::pintar();
                break;

                default:
                    $contenido = PortadaController::pintar();
                break;
            }

            return $contenido;


        }

        static function navegacion($total_registros, $pagina)
        {
            $pagina_siguiente = ($total_registros == LISTADO_TOTAL_POR_PAGINA)?  "<li class=\"page-item\"><a class=\"page-link\" href=\"/usuarios/{$pagina}\">Siguiente</a></li>" : '';
            $pagina_anterior  = ($pagina != 1)? "<li class=\"page-item\"><a class=\"page-link\" href=\"/usuarios/". ($pagina-2) ."\">Anterior</a></li>" : '';

            return "
                <nav>
                    <ul class=\"pagination\">
                        {$pagina_anterior}
                        {$pagina_siguiente}
                    </ul>
                </nav>
            ";



        }

    }