<?php
// Habilitar reporte completo de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurar zona horaria
date_default_timezone_set('America/Denver');

include_once('db/db_Inventario.php');

// Registrar todos los errores en un archivo log
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

// Cabeceras para respuesta JSON
header('Content-Type: application/json');

$marbete = isset($_GET['marbete']) ? trim($_GET['marbete']) : '';

if(empty($marbete)) {
    http_response_code(400);
    die(json_encode([
        'success' => false,
        'message' => 'El parámetro marbete es requerido',
        'error_details' => 'No se recibió el parámetro marbete en la URL'
    ]));
}

ContadorApu($marbete);

function ContadorApu($marbete) {
    $con = new LocalConector();
    $conex = $con->conectar();

    if($conex->connect_error) {
        error_log("Error de conexión: " . $conex->connect_error);
        http_response_code(500);
        die(json_encode([
            'success' => false,
            'message' => 'Error de conexión a la base de datos',
            'error_details' => $conex->connect_error
        ]));
    }

    try {
        // 1. CONSULTA DATOS ORIGINALES
        $query1 = "SELECT `Id_StorageUnit`, `Numero_Parte`, `Cantidad`, `Storage_Bin`, `Storage_Type`, `Estatus`, `FolioMarbete`, `Conteo` 
                  FROM `Storage_Unit` 
                  WHERE `Id_StorageUnit` = ?";

        error_log("Ejecutando consulta: " . $query1);

        $stmt1 = $conex->prepare($query1);
        if(!$stmt1) {
            throw new Exception("Error al preparar consulta 1: " . $conex->error);
        }

        $stmt1->bind_param("s", $marbete);
        if(!$stmt1->execute()) {
            throw new Exception("Error al ejecutar consulta 1: " . $stmt1->error);
        }

        $result1 = $stmt1->get_result();
        if($result1->num_rows === 0) {
            http_response_code(404);
            die(json_encode([
                'success' => false,
                'message' => 'No se encontró el marbete especificado',
                'query' => $query1,
                'parameters' => [$marbete]
            ]));
        }

        $datos_originales = $result1->fetch_all(MYSQLI_ASSOC);
        $row = $datos_originales[0];

        error_log("Datos obtenidos: " . print_r($row, true));

        // 2. VERIFICAR EN BITÁCORA
        $query2 = "SELECT COUNT(*) as existe 
                  FROM `Bitacora_Inventario` 
                  WHERE `NumeroParte` = ? 
                  AND `StorageBin` = ? 
                  AND `StorageType` = ?";

        $stmt2 = $conex->prepare($query2);
        if(!$stmt2) {
            throw new Exception("Error al preparar consulta 2: " . $conex->error);
        }

        $stmt2->bind_param("sss", $row['Numero_Parte'], $row['Storage_Bin'], $row['Storage_Type']);
        if(!$stmt2->execute()) {
            throw new Exception("Error al ejecutar consulta 2: " . $stmt2->error);
        }

        $existe = $stmt2->get_result()->fetch_assoc()['existe'];
        error_log("Resultado verificación bitácora: " . ($existe ? "Existe" : "No existe"));

        // 3. INSERTAR SI NO EXISTE
        if($existe == 0) {
            $fecha = date("Y-m-d H:i:s");
            $query3 = "INSERT INTO `Bitacora_Inventario` 
                      (`NumeroParte`, `Fecha`, `StorageBin`, `StorageType`, `Area`) 
                      VALUES (?, ?, ?, ?, '1')";

            error_log("Preparando inserción: " . $query3);

            $stmt3 = $conex->prepare($query3);
            if(!$stmt3) {
                throw new Exception("Error al preparar inserción: " . $conex->error);
            }

            $stmt3->bind_param("ssss", $row['Numero_Parte'], $fecha, $row['Storage_Bin'], $row['Storage_Type']);
            if(!$stmt3->execute()) {
                throw new Exception("Error al insertar en bitácora: " . $stmt3->error);
            }

            error_log("Inserción exitosa en bitácora");
        }

        // 4. RESPUESTA EXITOSA
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $datos_originales,
            'debug' => [
                'marbete_buscado' => $marbete,
                'registros_encontrados' => count($datos_originales)
            ]
        ]);

    } catch (Exception $e) {
        error_log("EXCEPCIÓN: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error en el servidor',
            'error_details' => $e->getMessage(),
            'trace' => $e->getTrace()
        ]);
    } finally {
        // Cerrar statements
        isset($stmt1) && $stmt1->close();
        isset($stmt2) && $stmt2->close();
        isset($stmt3) && $stmt3->close();

        // Cierra la conexión directamente si es mysqli
        if(isset($conex) && $conex instanceof mysqli) {
            $conex->close();
        }
    }
}
?>