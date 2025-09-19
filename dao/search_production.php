<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php'); // Asegúrate que la ruta a tu conexión sea correcta.

$response = ['success' => false, 'data' => null, 'message' => ''];

// Validar que los parámetros GET no estén vacíos
if (empty($_GET['material']) || empty($_GET['storagebin'])) {
    $response['message'] = 'El número de parte y el Storage Bin son requeridos.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    $material = $_GET['material'];
    $storageBin = $_GET['storagebin'];

    // Consulta para obtener el registro, incluyendo el campo 'Estado'
    $stmt = $conex->prepare("SELECT `IdInventario`, `Description`, `UnidadMedida`, `StorageType`, `Estado` FROM `Inventario` WHERE `Material` = ? AND `StorageBin` = ?");
    $stmt->bind_param("ss", $material, $storageBin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // **CAMBIO CLAVE: Verificación del estado del registro**
        if ($data['Estado'] == '1') {
            // Si el estado es 1, el registro ya fue capturado.
            $response['success'] = false;
            $response['message'] = 'Este material ya ha sido capturado en esta ubicación y no se puede modificar.';
        } else {
            // Si el estado no es 1, se envían los datos para la captura.
            $response['success'] = true;
            $response['data'] = $data;
        }

    } else {
        $response['message'] = 'Material no encontrado en la ubicación especificada.';
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
