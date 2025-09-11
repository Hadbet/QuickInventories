<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php');

$response = ['success' => false, 'data' => [], 'message' => ''];

if (!isset($_GET['sun'])) {
    $response['message'] = 'No se proporcionó SUN.';
    echo json_encode($response);
    exit;
}

$sun = trim($_GET['sun']);

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Consulta para buscar el SUN
    $stmt = $conex->prepare("SELECT `IdInventario`, `Material`, `Description`, `StorageType`, `StorageBin`, `AvadaibleStock`, `UnidadMedida`, `Sun` FROM `Inventario` WHERE `Sun` = ?");
    $stmt->bind_param("s", $sun);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    if (count($data) > 0) {
        $response['success'] = true;
        $response['data'] = $data;
    } else {
        $response['message'] = 'SUN no encontrado en la base de datos.';
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
