<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php'); // Asegúrate que la ruta sea correcta

$response = ['success' => false, 'message' => 'Parámetros inválidos.'];

if (isset($_GET['material']) && isset($_GET['storagebin'])) {
    $material = $_GET['material'];
    $storagebin = $_GET['storagebin'];

    try {
        $con = new LocalConector();
        $conex = $con->conectar();

        // Usar sentencias preparadas para seguridad
        $stmt = $conex->prepare("SELECT `IdInventario`, `Description`, `UnidadMedida`, `StorageType` FROM `Inventario` WHERE `Material` = ? AND `StorageBin` = ? LIMIT 1");
        $stmt->bind_param("ss", $material, $storagebin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response = ['success' => true, 'data' => $data];
        } else {
            $response['message'] = 'No se encontró ningún material con esos criterios.';
        }

        $stmt->close();
        $conex->close();
    } catch (Exception $e) {
        http_response_code(500);
        $response['message'] = 'Error en el servidor: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>
