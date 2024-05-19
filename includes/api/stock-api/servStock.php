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

    public function venderProducto($data)
    {
        require_once "./servModStock.php";
        require_once "../alarmas-reposicion-api/servAlarmas.php";

        $response = true;

        foreach ($data as $venta) {


            $nombreProducto = $venta->producto;
            $cantidadVendida = $venta->cant;

            $sql = "SELECT * FROM productos WHERE name='$nombreProducto'";
            $resultado = $this->conexion->query($sql);

            $productoOld = new stdClass;

            if ($resultado->num_rows > 0) {

                // Setteamos el producto en el estado viejo
                while ($row = $resultado->fetch_assoc()) {

                    $productoOld->id = $row["id"];
                    $productoOld->name = $row["name"];
                    $productoOld->sn = $row["sn"];
                    $productoOld->cant = $row["cant"];
                    
                }

            }

            $productoNew = $productoOld->id;
            $productoNew = $productoOld->name;
            $productoNew = $productoOld->sn;
            // --- El nuevo estado tiene la cantidad vieja menos la vendida
            $productoNew = $productoOld->cant - $cantidadVendida;
            $modificacion = $this->modificarStock($productoNew);

            if(!$modificacion){
                $response = false;
            }

            // ----- Registrar modificación de stock 
            $productoModificado = new stdClass;

            $productoModificado->id_old = $productoOld->id;
            $productoModificado->name_old = $productoOld ->name;
            $productoModificado->sn_old = $productoOld->sn;
            $productoModificado->cant_old = $productoOld->cant;
            $productoModificado->id_new = $productoOld->id;
            $productoModificado->name_new = $productoOld->name;
            $productoModificado->sn_new = $productoOld->sn;
            $productoModificado->cant_new = $productoOld->cant - $cantidadVendida;
            $productoModificado->fecha = date("Y-d-m", strtotime("today"));
            $productoModificado->motivo = "VENTA";

            $modiServ = new modificarStock($conexion);
            $generarModifi = $modiServ->modificarStock($productoModificado);

            if(!$generarModifi){
                $response = false;
            }

            $modiServ->cerrarConexion();


            $alarmaServ = new AlarmaService($conexion);
            $modiAlarmas = $alarmaServ->cambioDeEstadoDeAlarma($productoOld->id);

            
            if(!$modiAlarmas){
                $response = false;
            }

            $alarmaServ->cerrarConexion()();

        }

        return $response;

    }

    public function cerrarConexion()
    {

        return $this->conexion->close();
    }
}
