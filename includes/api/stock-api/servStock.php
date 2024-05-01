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

        $id = $id;
        $sql = "DELETE FROM productos WHERE id=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();

    }

    public function cerrarConexion()
    {

        return $this->conexion->close();
    }
}

?>