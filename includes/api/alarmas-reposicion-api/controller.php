<?php

require './servAlarmas.php';
require_once '../../config/db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {


    $alarmaServ = new AlarmaService($conexion);
    $alarmas = $alarmaServ->verAlarmas();
    $alarmaServ->cerrarConexion();

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($alarmas);
}
