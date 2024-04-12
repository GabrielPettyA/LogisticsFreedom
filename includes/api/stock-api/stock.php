<?php

require '../../config/db-config.php';

// Endpoint get productos
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["productos"])){
$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);
$productos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producto = array(
            "id" => $row["id"],
            "name" => $row["name"],
            "sn" => $row["sn"],
            "cant" => $row["cant"]
        );
        $productos[] = $producto;
    }
}

// Cerrar la conexión
$conexion->close();

// Devolver los resultados en formato JSON
header("Content-Type: application/json");
echo json_encode($productos);
}


// Endpoint editar productos
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    
    $data = json_decode(file_get_contents("php://input"));

    // Verificar si el JSON se decodificó correctamente
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {
        $name = $data->name; 
        $sn = $data->sn;     
        $cant = $data->cant;

        $sql = "UPDATE productos SET name = ?, sn = ?, cant = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssii", $name, $sn, $cant, $data->id);

        if ($stmt->execute()) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }

        $stmt->close();
    }
}
 
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {
        $id_old = $data->id_old;
        $name_old = $data->name_old;
        $sn_old = $data->sn_old;
        $cant_old = $data->cant_old;
        $id_new = $data->id_new;
        $name_new = $data->name_new;
        $sn_new = $data->sn_new;
        $cant_new = $data->cant_new;
        $fecha = $data->fecha;
        $motivo = $data->motivo;
        $sql = "INSERT INTO mod_stock (id_old ,name_old ,sn_old ,cant_old ,id_new ,name_new ,sn_new ,cant_new ,fecha, motivo) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issiississ", $id_old,$name_old,$sn_old,$cant_old,$id_new,$name_new,$sn_new,$cant_new,$fecha,$motivo);
        if ($stmt->execute()) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }

        $stmt->close();
    }
}

if($_SERVER["REQUEST_METHOD"]=="DELETE"){
    $data = json_decode(file_get_contents("php://input"));
    if ($data === null) {
        echo "Error al decodificar el JSON.";
    } else {
        $id = $data->id;
        $sql = "DELETE FROM productos WHERE id=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }

        $stmt->close();
    }
}


?>