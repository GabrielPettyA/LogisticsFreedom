<?php

class modificarStock{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function modificarStock($productoModificado){

        $id_old = $productoModificado->id_old;
        $name_old = $productoModificado->name_old;
        $sn_old = $productoModificado->sn_old;
        $cant_old = $productoModificado->cant_old;
        $id_new = $productoModificado->id_new;
        $name_new = $productoModificado->name_new;
        $sn_new = $productoModificado->sn_new;
        $cant_new = $productoModificado->cant_new;
        $fecha = $productoModificado->fecha;
        $motivo = $productoModificado->motivo;
        $sql = "INSERT INTO mod_stock (id_old ,name_old ,sn_old ,cant_old ,id_new ,name_new ,sn_new ,cant_new ,fecha, motivo) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("issiississ", $id_old, $name_old, $sn_old, $cant_old, $id_new, $name_new, $sn_new, $cant_new, $fecha, $motivo);
        
        return $stmt->execute();
    }


    public function modi_recepcion_ordenes($sn, $cantidadRecepcionada, $fecha){

        // Buscamos el producto en la tabla de productos
        $sql = "SELECT * FROM productos WHERE  sn ='$sn'";
        $result =  $this->conexion->query($sql);

        // Creamos dos objetos vacios para guardar datos
        $productoOld = new stdClass;
        $productoMod = new stdClass;

        // Retornamos ante consulta sin resultados false
        if ($result->num_rows == 0) {

            return false;

        }

        // Setteamos el producto en el estado viejo
        while ($row = $result->fetch_assoc()) {

            $productoOld->id = $row["id"];
            $productoOld->name = $row["name"];
            $productoOld->sn = $row["sn"];
            $productoOld->cant = $row["cant"];
        }

        // Setteamos el producto modificado para registralo en la tabla mod_stock
        $productoMod->id_old = $productoOld->id;
        $productoMod->name_old = $productoOld->name;
        $productoMod->sn_old = $productoOld->sn;
        $productoMod->cant_old = $productoOld->cant;
        $productoMod->id_new = $productoOld->id;
        $productoMod->name_new = $productoOld->name;
        $productoMod->sn_new = $productoOld->sn;
        $productoMod->cant_new = $productoOld->cant + $cantidadRecepcionada;
        $productoMod->fecha = $fecha;
        $productoMod->motivo = "RECEPCION ORDEN DE COMPRA";

        // Llamamos al método para hacer la mod_stock y guardamos el resultado de una operación en una variable
        $mod_stock = $this->modificarStock($productoMod);

        // Hacemos la modificación en la tabla de productos
        $sql = "UPDATE productos SET name = ?, sn = ?, cant = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssii", $productoOld->name, $productoOld->sn,  $productoMod->cant_new, $productoOld->id);

        // Guardamos el resultado de una operación en una variable
        $modiStock = $stmt->execute();

        // Retornamos el resultado de ambas operaciones
        return $mod_stock && $modiStock;

    }

    public function cerrarConexion()
    {

        return $this->conexion->close();
    }

}

?>