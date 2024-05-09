<?php

require_once './servAlarmas.php';
require_once '../../config/db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $alarmaServ = new AlarmaService($conexion);
    $alarmas = $alarmaServ->verAlarmas();
    $alarmaServ->cerrarConexion();

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($alarmas);
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    $data = json_decode(file_get_contents("php://input"));

    if ($data == null || empty($data->id) || empty($data->stockAviso) || empty($data->estado)) {

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode(false);
        return;
    }

    $alarmaServ = new AlarmaService($conexion);
    $editarAlarma = $alarmaServ->editarAlarma($data);
    $alarmaServ->cerrarConexion();

    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($editarAlarma);

}
