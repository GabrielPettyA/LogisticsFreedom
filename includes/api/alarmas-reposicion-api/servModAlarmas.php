<?php

class ModAlarmas
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function verModAlarmas($alarmaId)
    {

        $sql = "SELECT * FROM alarmasmod WHERE alarmaFK='$alarmaId'";
        $result = $this->conexion->query($sql);
        $alarmaMod = array();


        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                $modAlarmas = array(
                    "id" => $row["id"],
                    "alarmaFK" => $row["alarmaFK"],
                    "modificadaPor" => $row["modificadaPor"],
                    "motivo" => $row["motivo"],
                    "cant_old" => $row["cant_old"],
                    "cant_new" => $row["cant_new"],
                    "estadoAnterior" => $row["estadoAnterior"],
                    "fechaMod" => $row["fechaMod"],
                );

                $alarmaMod[] = $modAlarmas;
            }
        }

        return $alarmaMod;
    }

    public function crearModAlarmas($alarmaMod)
    {

        $sql = "INSERT INTO alarmasmod (alarmaFK,modificadaPor,motivo,cant_old,cant_new,estadoAnterior) VALUE 
        ('$alarmaMod->alarmaFK','$alarmaMod->modificadaPor','$alarmaMod->motivo','$alarmaMod->cant_old',
        '$alarmaMod->cant_new','$alarmaMod->estadoAnterior')";

        $result = $this->conexion->query($sql);
        return $result;
    }

    public function cerrarConexion()
    {

        return $this->conexion->close();
    }

}
