<?php
session_start();
header('Content-Type: application/json');

// Solo los Super Usuarios (rol 1) pueden editar usuarios
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != '1') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado.']);
    exit;
}

include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['userId']) || empty($input['username']) || empty($input['nombre']) || empty($input['rol'])) {
    $response['message'] = 'Todos los campos son obligatorios.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    $userId = $input['userId'];
    $username = $input['username'];
    $nombre = $input['nombre'];
    $rol = $input['rol'];

    // Verificar que el nuevo username no esté ya en uso por OTRO usuario
    $stmt_check = $conex->prepare("SELECT IdUsuario FROM Usuario WHERE Username = ? AND IdUsuario != ?");
    $stmt_check->bind_param("si", $username, $userId);
    $stmt_check->execute();
    $stmt_check->store_result();
    if ($stmt_check->num_rows > 0) {
        $response['message'] = 'Ese nombre de usuario ya está en uso por otra cuenta.';
        echo json_encode($response);
        exit;
    }
    $stmt_check->close();

    // Proceder con la actualización
    $stmt = $conex->prepare("UPDATE `Usuario` SET `Username` = ?, `Nombre` = ?, `Rol` = ? WHERE `IdUsuario` = ?");
    $stmt->bind_param("ssii", $username, $nombre, $rol, $userId);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Usuario actualizado correctamente.';
    } else {
        $response['message'] = 'Error al actualizar el usuario.';
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
