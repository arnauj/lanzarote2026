<?php

class CalendarioController
{

    static function pintar()
    {
        $curso = new Curso();


        if(Campo::val('pagina'))
        {
    
            ob_clean();
            
            echo self::pintar_calendario(Campo::val('pagina'));
        
        
            exit;
     

        }
        

        $select = new Select(['options' => $curso->cargar(),'nombre' =>'calendario_curso']);

        return "
            <div class=\"container contenido\">
            <section class=\"page-section calendario\" id=\"calendario\">
            ".
                $select->pintar() .
                '<div id="place_calendario">'.
                self::pintar_calendario(1).
                '</div>'

                
            
            ."</div>"
        ;
    }


    static function pintar_calendario($id_curso)
    {
        $query = new Query("
            SELECT 
                h.dia                              AS dia,
                h.hora_inicio                      AS hora_inicio,
                h.hora_fin                         AS hora_fin,
                m.nombre                           AS nombre_modulo,
                m.siglas                           AS siglas_modulo,
                m.color                            AS color_modulo,
                CONCAT(p.nombre, ' ', p.apellidos) AS nombre_profesor,
                c.curso_numero,
                c.nombre_grado,
                c.letra
            FROM 
                horarios h
                JOIN modulos m ON h.id_modulo = m.id
                JOIN personas p ON h.id_profesor = p.id
                JOIN cursos c ON m.curso_asignado = c.id
            WHERE c.id = '{$id_curso}'
            ORDER BY 
                h.dia, h.hora_inicio;
                
        
        ");

        $calendario = [];
        while ($registro = $query->recuperar())
        {
            $calendario[substr($registro['hora_inicio'],0,5).'-'.substr($registro['hora_fin'],0,5)][$registro['dia']] = $registro;
        }



        return "
            <table>
                <tr>
                    <td>X</td>
                    <td>Lunes</td>
                    <td>Martes</td>
                    <td>Miércoles</td>
                    <td>Jueves</td>
                    <td>Viernes</td>
                </tr>
                <tr>
                    <td>08:00-08:55</td>
                    <td style=\"background:{$calendario['08:00-08:55']['L']['color_modulo']}\">{$calendario['08:00-08:55']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:00-08:55']['M']['color_modulo']}\">{$calendario['08:00-08:55']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:00-08:55']['X']['color_modulo']}\">{$calendario['08:00-08:55']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:00-08:55']['J']['color_modulo']}\">{$calendario['08:00-08:55']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:00-08:55']['V']['color_modulo']}\">{$calendario['08:00-08:55']['V']['siglas_modulo']}</td>
                </tr>
                <tr>
                    <td>08:55-09:50</td>
                    <td style=\"background:{$calendario['08:55-09:50']['L']['color_modulo']}\">{$calendario['08:55-09:50']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:55-09:50']['M']['color_modulo']}\">{$calendario['08:55-09:50']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:55-09:50']['X']['color_modulo']}\">{$calendario['08:55-09:50']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:55-09:50']['J']['color_modulo']}\">{$calendario['08:55-09:50']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['08:55-09:50']['V']['color_modulo']}\">{$calendario['08:55-09:50']['V']['siglas_modulo']}</td>
                </tr>
                <tr>
                    <td>09:50-10:45</td>
                    <td style=\"background:{$calendario['09:50-10:45']['L']['color_modulo']}\">{$calendario['09:50-10:45']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['09:50-10:45']['M']['color_modulo']}\">{$calendario['09:50-10:45']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['09:50-10:45']['X']['color_modulo']}\">{$calendario['09:50-10:45']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['09:50-10:45']['J']['color_modulo']}\">{$calendario['09:50-10:45']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['09:50-10:45']['V']['color_modulo']}\">{$calendario['09:50-10:45']['V']['siglas_modulo']}</td>
                </tr>
                <tr>
                    <td>10:45-11:15</td>
                    <td>RECREO</td>
                    <td>RECREO</td>
                    <td>RECREO</td>
                    <td>RECREO</td>
                    <td>RECREO</td>
                </tr>
                <tr>
                    <td>11:15-12:10</td>
                    <td style=\"background:{$calendario['11:15-12:10']['L']['color_modulo']}\">{$calendario['11:15-12:10']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['11:15-12:10']['M']['color_modulo']}\">{$calendario['11:15-12:10']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['11:15-12:10']['X']['color_modulo']}\">{$calendario['11:15-12:10']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['11:15-12:10']['J']['color_modulo']}\">{$calendario['11:15-12:10']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['11:15-12:10']['V']['color_modulo']}\">{$calendario['11:15-12:10']['V']['siglas_modulo']}</td>
                </tr>
                <tr>
                    <td>12:10-13:05</td>
                    <td style=\"background:{$calendario['12:10-13:05']['L']['color_modulo']}\">{$calendario['12:10-13:05']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['12:10-13:05']['M']['color_modulo']}\">{$calendario['12:10-13:05']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['12:10-13:05']['X']['color_modulo']}\">{$calendario['12:10-13:05']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['12:10-13:05']['J']['color_modulo']}\">{$calendario['12:10-13:05']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['12:10-13:05']['V']['color_modulo']}\">{$calendario['12:10-13:05']['V']['siglas_modulo']}</td>
                </tr>

                <tr>
                    <td>13:05-14:00</td>
                    <td style=\"background:{$calendario['13:05-14:00']['L']['color_modulo']}\">{$calendario['13:05-14:00']['L']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['13:05-14:00']['M']['color_modulo']}\">{$calendario['13:05-14:00']['M']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['13:05-14:00']['X']['color_modulo']}\">{$calendario['13:05-14:00']['X']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['13:05-14:00']['J']['color_modulo']}\">{$calendario['13:05-14:00']['J']['siglas_modulo']}</td>
                    <td style=\"background:{$calendario['13:05-14:00']['V']['color_modulo']}\">{$calendario['13:05-14:00']['V']['siglas_modulo']}</td>
                </tr>

            </table>
        
        ";
    }
}