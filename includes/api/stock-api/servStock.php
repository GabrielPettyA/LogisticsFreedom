<?php


class Stock
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function verStock()
    {

        $sql = "SELECT * FROM productos";
        $result =  $this->conexion->query($sql);
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

        return $productos;

    }

    public function modificarStock($producto)
    {

        $name = $producto->name;
        $sn = $producto->sn;
        $cant = $producto->cant;

        $sql = "UPDATE productos SET name = ?, sn = ?, cant = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssii", $name, $sn, $cant, $producto->id);

        return $stmt->execute();

    }

    public function eliminarProducto($id)
    {
        require_once "../alarmas-reposicion-api/servAlarmas.php";
    
        $alarmaServ = new AlarmaService($this->conexion);
        $eliminarAlarma = $alarmaServ->eliminarAlarma($id);
        
    
        $sql = "DELETE FROM productos WHERE id=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $eliminarProducto = $stmt->execute();


        $stmt->close();

        return $eliminarAlarma && $eliminarProducto;
    }

    public function cerrarConexion()
    {

        return $this->conexion->close();
    }
}

?>