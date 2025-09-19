<?php
session_start();
header('Content-Type: application/json');

// Solo los Super Usuarios (rol 1) pueden cambiar el estado
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != '1') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado.']);
    exit;
}

include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['userId']) || !isset($input['newStatus'])) {
    $response['message'] = 'Datos incompletos para actualizar el estado.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    $userId = $input['userId'];
    $newStatus = $input['newStatus'];

    $stmt = $conex->prepare("UPDATE `Usuario` SET `Estatus` = ? WHERE `IdUsuario` = ?");
    $stmt->bind_param("ii", $newStatus, $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'El estado del usuario ha sido actualizado.';
    } else {
        $response['message'] = 'Error al actualizar el estado del usuario.';
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
