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

    function eliminar($id)
    {
        $query = new Query("
            DELETE FROM '". $this->tabla ."'
            WHERE id = '{$id}'
        ");
    }


    function recuperar($id)
    {

        $query = new Query("
            SELECT * 
            FROM ". $this->tabla ."
            WHERE id = '{$id}'
        ");
        $registro = $query->recuperar();
        $this->inicializar($registro);

        return $registro;
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


    function actualizar($datos,$id)
    {

        $updates = '';
        foreach($datos as $clave => $valor)
        {
            $updates .= "{$clave} = '{$valor}',";
        }

        $sql = "
            UPDATE {$this->tabla}

            SET  {$updates}
                 ip_modi    = '{$this->ip}'
                ,fecha_modi = now()
            WHERE id = '{$id}'
        ";


        $query = new Query($sql);

        return $query->total;


    }


    function get_rows($consulta=[])
    {
        $select = is_null($consulta['select']) ? '*': $consulta['select'];

        $limit  = is_null($consulta['limit'])  ? '' : 'LIMIT '. $consulta['limit'];
        $offset = is_null($consulta['offset']) ? '' : 'OFFSET '. $consulta['offset'];

        $where = '';
        if(!is_null($consulta['where']))
        {
            foreach($consulta['where'] as $clave => $valor)
            {
                $where .= " {$clave} = '{$valor}' AND";
            }
            $where = substr($where,0,-4);
        }

        $wheremayor = '';
        if(!is_null($consulta['wheremayor']))
        {

            foreach($consulta['wheremayor'] as $clave => $valor)
            {
                $wheremayor .= " {$clave} > '{$valor}' AND";
            }
            $wheremayor = substr($wheremayor,0,-4);
        }


        if (!is_null($where) or !is_null($wheremayor))
        {
            $sqlwhere = 'WHERE '. $where . $wheremayor;
        }

        $sql = "
            SELECT {$select}
            FROM {$this->tabla}
            {$sqlwhere}
            {$limit}
            {$offset}
        ";

        $query = new Query($sql);

        $devolver = [];
        while ($registro = $query->recuperar())
        {
            $devolver[] = $registro;
        }

        return $devolver;


    }


}