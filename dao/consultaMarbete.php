<?php
// Cabeceras iniciales para asegurar respuesta JSON
header('Content-Type: application/json');
http_response_code(200); // Establecemos código 200 por defecto

include_once('db/db_Inventario.php');

// Validar y sanitizar el parámetro de entrada
$marbete = isset($_GET['marbete']) ? trim($_GET['marbete']) : '';

if(empty($marbete)) {
    echo json_encode([
        'success' => false,
        'message' => 'El parámetro marbete es requerido'
    ]);
    exit;
}

// Función principal
try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // 1. CONSULTA PRINCIPAL - Obtener datos del marbete
    $stmt = $conex->prepare("SELECT 
                            `Id_StorageUnit`, 
                            `Numero_Parte`, 
                            `Cantidad`, 
                            `Storage_Bin`, 
                            `Storage_Type`, 
                            `Estatus`, 
                            `FolioMarbete`, 
                            `Conteo` 
                          FROM `Storage_Unit` 
                          WHERE `Id_StorageUnit` = ?");

    if(!$stmt) {
        throw new Exception('Error al preparar consulta: ' . $conex->error);
    }

    $stmt->bind_param("s", $marbete);

    if(!$stmt->execute()) {
        throw new Exception('Error al ejecutar consulta: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if($result->num_rows === 0) {
        echo json_encode([
            'success' => false,
            'data' => [],
            'message' => 'No se encontró el marbete especificado'
        ]);
        exit;
    }

    $datos = $result->fetch_all(MYSQLI_ASSOC);
    $primerRegistro = $datos[0];

    // 2. OPERACIÓN SECUNDARIA - Registrar en bitácora si no existe
    $fechaActual = date('Y-m-d H:i:s');
    $stmtBitacora = $conex->prepare("INSERT INTO `Bitacora_Inventario` 
                                   (`NumeroParte`, `Fecha`, `StorageBin`, `StorageType`, `Area`)
                                   SELECT ?, ?, ?, ?, '1'
                                   FROM DUAL
                                   WHERE NOT EXISTS (
                                       SELECT 1 FROM `Bitacora_Inventario` 
                                       WHERE `NumeroParte` = ? 
                                       AND `StorageBin` = ? 
                                       AND `StorageType` = ?
                                   )");

    if($stmtBitacora) {
        $stmtBitacora->bind_param("ssssss",
            $primerRegistro['Numero_Parte'],
            $fechaActual,
            $primerRegistro['Storage_Bin'],
            $primerRegistro['Storage_Type'],
            $primerRegistro['Numero_Parte'],
            $primerRegistro['Storage_Bin'],
            $primerRegistro['Storage_Type']
        );
        $stmtBitacora->execute();
    }

    // 3. RESPUESTA EXITOSA
    echo json_encode([
        'success' => true,
        'data' => $datos
    ]);

} catch (Exception $e) {
    // Registrar error en logs
    error_log('Error en consultaMarbete.php: ' . $e->getMessage());

    // Respuesta de error
    echo json_encode([
        'success' => false,
        'message' => 'Ocurrió un error al procesar la solicitud'
    ]);

} finally {
    // Liberar recursos
    isset($stmt) && $stmt->close();
    isset($stmtBitacora) && $stmtBitacora->close();
    isset($con) && $con->desconectar();
}
?>