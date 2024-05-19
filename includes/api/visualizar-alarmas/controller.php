<?php

require_once './servVisualizarAlarmas.php';
require_once '../../config/db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $alarmaServ = new visualizarAlarmas($conexion);
    $alarmas = $alarmaServ->verAlarmasVisualziar();
    $alarmaServ->cerrarConexion();

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($alarmas);
}