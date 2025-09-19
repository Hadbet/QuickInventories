<?php
session_start();
header('Content-Type: application/json');

// Solo los Super Usuarios (rol 1) pueden cargar catálogos
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != '1') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado.']);
    exit;
}

include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input)) {
    $response['message'] = 'No se recibieron datos para procesar.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Iniciar una transacción para asegurar que todos los registros se inserten o ninguno lo haga.
    $conex->begin_transaction();

    // Preparar la consulta de inserción una sola vez
    $stmt = $conex->prepare(
        "INSERT INTO `Parte`(`GrammerNo`, `Descripcion`, `UM`, `ProfitCtr`, `Costo`, `Por`) VALUES (?, ?, ?, ?, ?, ?)"
    );

    foreach ($input as $item) {
        // Vinculación de parámetros para cada fila
        $stmt->bind_param(
            "ssssdd",
            $item['GrammerNo'],
            $item['Descripcion'],
            $item['UM'],
            $item['ProfitCtr'],
            $item['Costo'],
            $item['Por']
        );

        // Ejecutar la inserción
        if (!$stmt->execute()) {
            // Si una inserción falla, revertir la transacción y salir.
            throw new Exception("Error al insertar el registro para GrammerNo " . $item['GrammerNo'] . ": " . $stmt->error);
        }
    }

    // Si todas las inserciones fueron exitosas, confirmar la transacción.
    $conex->commit();
    $response['success'] = true;
    $response['message'] = count($input) . ' registros del catálogo de partes han sido cargados exitosamente.';

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    if (isset($conex)) {
        $conex->rollback(); // Revertir cambios en caso de error
    }
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>

