<?php

class AlarmaService
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function verAlarmas()
    {

        $sql = "SELECT alarmas.id, productos.name, productos.sn, productos.cant, alarmas.stockAviso, alarmas.estado
        FROM productos
        INNER JOIN alarmas ON productos.id = alarmas.productoFK;";
        $result = $this->conexion->query($sql);
        $alarmasData = array();

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $datos = array(
                    "id" => $row["id"],
                    "name" => $row["name"],
                    "sn" => $row["sn"],
                    "cant" => $row["cant"],
                    "stockAviso" => $row["stockAviso"],
                    "estado" => $row["estado"]
                );

                $alarmasData[] = $datos;
            }
        }

        // ---- Devuelve todos los datos
        return $alarmasData;
    }

    public function crearAlarma($productoFK)
    {

        $sql2 = "INSERT INTO alarmas (productoFK, stockAviso, estado )VALUE ('$productoFK', '0','I')";
        $result = $this->conexion->query($sql2);
        return $result;
    }

    public function editarAlarma($alarma)
    {
        require_once './servModAlarmas.php';
        
        $sql = "SELECT * FROM alarmas  WHERE id = '$alarma->id'";
        $result = $this->conexion->query($sql);
        $alarmaMod = new stdClass;

        while ($row = $result->fetch_assoc()) {

            $alarmaMod->alarmaFK = $row["id"];
            $alarmaMod->cant_old = $row["stockAviso"];
            $alarmaMod->estadoAnterior = $row["estado"];
        }

        $alarmaMod->cant_new = $alarma->stockAviso;
        $alarmaMod->modificadaPor = $alarma->modificadaPor;
        $alarmaMod->motivo = $alarma->motivo;

        $servModStock = new ModAlarmas($this->conexion);
        $modificacionAlarma = $servModStock->crearModAlarmas($alarmaMod);

        $sql = "UPDATE alarmas SET stockAviso = ?, estado = ? WHERE id = ?";
        $smtp = $this->conexion->prepare($sql);
        $smtp->bind_param("isi", $alarma->stockAviso, $alarma->estado, $alarma->id);

        return $smtp->execute() && $modificacionAlarma;


        $servModStock->cerrarConexion();
        $smtp->close();
    }

    public function eliminarAlarma($productoFK){

        $sql = "DELETE FROM alarmas WHERE productoFK = '$productoFK'";
        $result = $this->conexion->query($sql);
        return $result;

    }


    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}
