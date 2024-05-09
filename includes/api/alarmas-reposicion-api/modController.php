<?php

require_once './servModAlarmas.php';
require_once '../../config/db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $id = $_GET['id'];

    if($id == null || empty($id)){

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(false);

    }

    $servModAlarmas = new ModAlarmas($conexion);
    $verModAlarmas = $servModAlarmas->verModAlarmas($id);
    $servModAlarmas->cerrarConexion();

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($verModAlarmas);
}


?>