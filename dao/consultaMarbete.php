<?php
include_once('db/db_Inventario.php');

$marbete = isset($_GET['marbete']) ? trim($_GET['marbete']) : '';

if(empty($marbete)) {
    http_response_code(400);
    die(json_encode(array("success" => false, "message" => "El parámetro marbete es requerido")));
}

ContadorApu($marbete);

function ContadorApu($marbete) {
    $con = new LocalConector();
    $conex = $con->conectar();

    try {
        // 1. CONSULTA DATOS ORIGINALES
        $stmt1 = $conex->prepare("SELECT `Id_StorageUnit`, `Numero_Parte`, `Cantidad`, `Storage_Bin`, `Storage_Type`, `Estatus`, `FolioMarbete`, `Conteo` 
                                FROM `Storage_Unit` 
                                WHERE `Id_StorageUnit` = ?");
        if(!$stmt1) throw new Exception("Error al preparar consulta: ".$conex->error);

        $stmt1->bind_param("s", $marbete);
        if(!$stmt1->execute()) throw new Exception("Error al ejecutar consulta: ".$stmt1->error);

        $result1 = $stmt1->get_result();
        if($result1->num_rows === 0) throw new Exception("No se encontró el marbete especificado");

        $datos_originales = $result1->fetch_all(MYSQLI_ASSOC);
        $row = $datos_originales[0];

        // 2. VERIFICAR E INSERTAR EN BITÁCORA
        $stmt2 = $conex->prepare("SELECT COUNT(*) as existe FROM `Bitacora_Inventario` 
                                WHERE `NumeroParte` = ? AND `StorageBin` = ? AND `StorageType` = ?");
        $stmt2->bind_param("sss", $row['Numero_Parte'], $row['Storage_Bin'], $row['Storage_Type']);
        $stmt2->execute();
        $existe = $stmt2->get_result()->fetch_assoc()['existe'];

        if($existe == 0) {
            $fecha = date("Y-m-d H:i:s");
            $stmt3 = $conex->prepare("INSERT INTO `Bitacora_Inventario` 
                                     (`NumeroParte`, `Fecha`, `StorageBin`, `StorageType`, `Area`) 
                                     VALUES (?, ?, ?, ?, '1')");
            $stmt3->bind_param("ssss", $row['Numero_Parte'], $fecha, $row['Storage_Bin'], $row['Storage_Type']);
            if(!$stmt3->execute()) {
                error_log("Error al insertar en bitácora: ".$stmt3->error);
                // NO lanzamos excepción para no interrumpir el flujo
            }
        }

        // 3. DEVOLVER RESPUESTA
        header('Content-Type: application/json');
        echo json_encode(array(
            "success" => true,
            "data" => $datos_originales
        ));

    } catch (Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(array(
            "success" => false,
            "message" => $e->getMessage(),
            "error_code" => $conex->errno ?? null
        ));
    } finally {
        // Liberar recursos
        isset($stmt1) && $stmt1->close();
        isset($stmt2) && $stmt2->close();
        isset($stmt3) && $stmt3->close();
        $con->desconectar();
    }
}
?>