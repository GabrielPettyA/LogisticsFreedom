<?php

require '../../config/db-config.php';
require_once './servStock.php';
require_once './servModStock.php';

// Endpoint get productos
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["productos"])) {

    // Lo llamamos desde el servicio de stock
    $servicioStock = new Stock($conexion);
    $stock = $servicioStock->verStock();
    $servicioStock->cerrarConexion();

    // Devolver los resultados en formato JSON
    header("Content-Type: application/json");
    echo json_encode($stock);
}


// Endpoint editar productos
if ($_SERVER["REQUEST_METHOD"] == "PUT") {

    require_once "../alarmas-reposicion-api/servAlarmas.php";

    $data = json_decode(file_get_contents("php://input"));

    // Verificar si el JSON se decodificó correctamente
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {

        $servicioStock = new Stock($conexion);
        $modificar = $servicioStock->modificarStock($data);

        $alarmasServ = new AlarmaService($conexion);
        $configEstadoAlarma = $alarmasServ->cambioDeEstadoDeAlarma($data->id);

        $alarmasServ->cerrarConexion();
        $servicioStock->cerrarConexion();

        // Devolver los resultados en formato JSON
        header("Content-Type: application/json");
        echo json_encode($modificar && $configEstadoAlarma);
    }
}

// Registra modificación de productos con motivo de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {

        $modificarStock = new modificarStock($conexion);
        $modificacion = $modificarStock->modificarStock($data);
        $modificarStock->cerrarConexion();

        // Devolver los resultados en formato JSON
        header("Content-Type: application/json");
        echo json_encode($modificacion);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {

        $servicioStock = new Stock($conexion);
        $eliminar = $servicioStock->eliminarProducto($data->id);
        $servicioStock->cerrarConexion();

        // Devolver los resultados en formato JSON
        header("Content-Type: application/json");
        echo json_encode($eliminar);
    }
}
