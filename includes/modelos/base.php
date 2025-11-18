<?php

class Base
{

    function inicializar($datos = [])
    {
        $query = new Query("
        
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS   
            WHERE table_name = '". $this->tabla ."' 
            AND   table_schema = '". BBDD::$baseDatos . "';
        ");

        while ($registro = $query->recuperar())
        {
            
            $campo_nuevo = $registro['COLUMN_NAME'];

            $this->$campo_nuevo = $datos[$campo_nuevo];
        }
    }


    function recuperar($id)
    {

        $query = new Query("
            SELECT * 
            FROM '". $this->tabla ."'
            WHERE id = '{$id}'
        ");
        $registro = $query->recuperar();
        $this->inicializar($registro);
    }

    function insertar($registro)
    {
        $pre_insert = $post_insert = '';
        foreach($registro as $clave => $valor)
        {
            $pre_insert  .= $clave .', ';
            $post_insert .= "'{$valor}', ";
        }
        
        $sql = "
        INSERT INTO {$this->tabla}
        (   $pre_insert
            fecha_sis_alta
            ,ip_alta
        )
        VALUES
        (   
             $post_insert
             now()
             ,'{$_SERVER['REMOTE_ADDR']}'     
        );
        ";



        $query = new Query($sql);

        return $query->getLastInsertId();
    }
}