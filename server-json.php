<?php
    header('Content-Type: application/json');
    $data = [
        "mensaje" => "Hola desde el servidor con JSON",
        "fecha" => date('Y-m-d H:i:s')
    ];
    echo json_encode($data);