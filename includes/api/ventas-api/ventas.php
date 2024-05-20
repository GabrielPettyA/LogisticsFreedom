<?php

require_once '../../config/db-config.php';

//endpoint para obtener ventas
if ($_SERVER["REQUEST_METHOD"] == "GET") {


    $sql = "SELECT ventas.cantidad_vendida, ventas.fecha, productos.name
    FROM productos
    INNER JOIN ventas ON productos.id = ventas.producto_id;";
    $result = $conexion->query($sql);
    $ventasData = array();

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $datos = array(
                "cantidad" => $row["cantidad_vendida"],
                "fecha" => $row["fecha"],
                "name" => $row["name"],

            );

            $ventasData[] = $datos;
        }
    }

    // Devolver los resultados en formato JSON
    header("Content-Type: application/json");
    echo json_encode($ventasData);
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

