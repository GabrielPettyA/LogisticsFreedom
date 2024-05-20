<?php

require_once '../../config/db-config.php';

//endpoint para obtener ventas
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM ventas";
    $result = $conexion->query($sql);
    $ventas = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $venta = array(
                "id" => $row["id"],
                "producto_id" => $row["producto_id"],
                "cantidad_vendida" => $row["cantidad_vendida"],
                "fecha" => $row["fecha"]
            );
            $ventas[] = $venta;
        }
    }

    // Cerrar la conexión
    $conexion->close();

    // Devolver los resultados en formato JSON
    header("Content-Type: application/json");
    echo json_encode($ventas);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data = json_decode(file_get_contents("php://input"));
    if ($data == null || empty($data)) {
        echo json_encode(false);
        return;

    }
    require_once "../stock-api/servStock.php";

    $stockserv = new Stock($conexion);
    $vender = $stockserv->venderProducto($data);
    $stockserv->cerrarConexion(); 
    echo json_encode($vender);
    return true;

}

