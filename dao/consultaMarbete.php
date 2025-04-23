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

    // Configurar encabezados primero
    header('Content-Type: application/json');

    try {
        // 1. CONSULTA DATOS ORIGINALES
        $stmt1 = $conex->prepare("SELECT `Id_StorageUnit`, `Numero_Parte`, `Cantidad`, `Storage_Bin`, `Storage_Type`, `Estatus`, `FolioMarbete`, `Conteo` 
                                FROM `Storage_Unit` 
                                WHERE `Id_StorageUnit` = ?");
        if(!$stmt1) throw new Exception("Error al preparar consulta");

        $stmt1->bind_param("s", $marbete);
        if(!$stmt1->execute()) throw new Exception("Error al ejecutar consulta");

        $result1 = $stmt1->get_result();
        if($result1->num_rows === 0) {
            http_response_code(404);
            die(json_encode(array("success" => false, "message" => "No se encontró el marbete")));
        }

        $datos_originales = $result1->fetch_all(MYSQLI_ASSOC);
        $row = $datos_originales[0];

        // 2. OPERACIONES CON BITÁCORA (silenciosas)
        $stmt2 = $conex->prepare("SELECT COUNT(*) as existe FROM `Bitacora_Inventario` 
                                WHERE `NumeroParte` = ? AND `StorageBin` = ? AND `StorageType` = ?");
        if($stmt2) {
            $stmt2->bind_param("sss", $row['Numero_Parte'], $row['Storage_Bin'], $row['Storage_Type']);
            $stmt2->execute();
            $existe = $stmt2->get_result()->fetch_assoc()['existe'];

            if($existe == 0) {
                $fecha = date("Y-m-d H:i:s");
                $stmt3 = $conex->prepare("INSERT INTO `Bitacora_Inventario` 
                                        (`NumeroParte`, `Fecha`, `StorageBin`, `StorageType`, `Area`) 
                                        VALUES (?, ?, ?, ?, '1')");
                if($stmt3) {
                    $stmt3->bind_param("ssss", $row['Numero_Parte'], $fecha, $row['Storage_Bin'], $row['Storage_Type']);
                    $stmt3->execute(); // No interrumpimos si falla
                }
            }
        }

        // 3. RESPUESTA EXITOSA (HTTP 200)
        echo json_encode(array(
            "success" => true,
            "data" => $datos_originales
        ));

    } catch (Exception $e) {
        // Solo para errores críticos
        http_response_code(500);
        echo json_encode(array(
            "success" => false,
            "message" => "Error en el servidor"
        ));
        error_log("Error en consultaMarbete.php: " . $e->getMessage());
    } finally {
        // Liberar recursos
        isset($stmt1) && $stmt1->close();
        isset($stmt2) && $stmt2->close();
        isset($stmt3) && $stmt3->close();
        $con->desconectar();
    }
}
?>