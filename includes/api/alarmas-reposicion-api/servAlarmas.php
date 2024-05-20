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

    public function eliminarAlarma($productoFK)
    {

        $sql = "DELETE FROM alarmas WHERE productoFK = '$productoFK'";
        $result = $this->conexion->query($sql);
        return $result;
    }

    public function cambioDeEstadoDeAlarma($productoFK)
    {

        $response = true;

        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $productoFK);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();

        $sql1 = "SELECT * FROM alarmas WHERE productoFK = ?";
        $stmt1 = $this->conexion->prepare($sql1);
        $stmt1->bind_param("i", $productoFK);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $alarma = $result1->fetch_assoc();

        if ($alarma['estado'] == "I") {
            // ---- Si la alarma está inactiva, se retorna true
            return true;
        }

        if ($alarma['stockAviso'] > $producto['cant']) {
            // ---- Si la cantidad actual es menor que el stock de aviso
            $sql3 = "UPDATE alarmas SET estado = ? WHERE id = ?";
            $smtp = $this->conexion->prepare($sql3);
            $new_estado = "A";
            $smtp->bind_param("si", $new_estado, $alarma['id']);

            if(!$smtp->execute()){
                $response = false;
            }

        }

        if ($alarma['stockAviso'] < $producto['cant']) {
            // ---- Si la cantidad actual es mayor que el stock de aviso
            $sql3 = "UPDATE alarmas SET estado = ? WHERE id = ?";
            $smtp = $this->conexion->prepare($sql3);
            $new_estado = "D";
            $smtp->bind_param("si", $new_estado, $alarma['id']);
            
            if(!$smtp->execute()){
                $response = false;
            }

        }

        // ---- No se devuelve nada hasta el final
        return $response;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}
