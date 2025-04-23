<?php
include_once('db/db_Inventario.php');

$marbete = isset($_GET['marbete']) ? trim($_GET['marbete']) : '';

if(empty($marbete)) {
    http_response_code(400);
    die(json_encode(array("success" => false, "message" => "El parámetro marbete es requerido")));
}

ContadorApu($marbete);

function ContadorApu($marbete)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    try {
        // 1. CONSULTA DATOS ORIGINALES (Storage_Unit)
        $stmt1 = $conex->prepare("SELECT `Id_StorageUnit`, `Numero_Parte`, `Cantidad`, `Storage_Bin`, `Storage_Type`, `Estatus`, `FolioMarbete`, `Conteo` 
                                 FROM `Storage_Unit` 
                                 WHERE `Id_StorageUnit` = ?");
        $stmt1->bind_param("s", $marbete);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if($result1->num_rows === 0) {
            throw new Exception("No se encontró el marbete especificado");
        }

        $datos_originales = $result1->fetch_all(MYSQLI_ASSOC);

        // 2. VERIFICAR EN BITÁCORA (solo verificación, sin devolver datos)
        $row = $datos_originales[0];
        $stmt2 = $conex->prepare("SELECT COUNT(*) as existe 
                                FROM `Bitacora_Inventario` 
                                WHERE `NumeroParte` = ? 
                                AND `StorageBin` = ? 
                                AND `StorageType` = ?");
        $stmt2->bind_param("sss", $row['Numero_Parte'], $row['Storage_Bin'], $row['Storage_Type']);
        $stmt2->execute();
        $existe = $stmt2->get_result()->fetch_assoc()['existe'];

        // 3. INSERTAR SI NO EXISTE (operación silenciosa)
        if($existe == 0) {
            $stmt3 = $conex->prepare("INSERT INTO `Bitacora_Inventario` 
                                    (`NumeroParte`, `Fecha`, `StorageBin`, `StorageType`, `Area`, `FolioMarbete`) 
                                    VALUES (?, NOW(), ?, ?, '1', ?)");
            $stmt3->bind_param("ssss", $row['Numero_Parte'], $row['Storage_Bin'], $row['Storage_Type'], $marbete);
            $stmt3->execute();
        }

        // 4. DEVOLVER SOLO LOS DATOS ORIGINALES (como en tu primer ejemplo)
        echo json_encode(array("data" => $datos_originales));

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("success" => false, "message" => $e->getMessage()));
    } finally {
        // Cerrar statements
        isset($stmt1) && $stmt1->close();
        isset($stmt2) && $stmt2->close();
        isset($stmt3) && $stmt3->close();
        $con->desconectar();
    }
}
?>