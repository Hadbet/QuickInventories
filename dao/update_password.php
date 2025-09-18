<?php
session_start();
header('Content-Type: application/json');

// 1. Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado. Inicia sesión.']);
    exit;
}

include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

// 2. Validar la entrada
if (empty($input['new_password'])) {
    $response['message'] = 'La nueva contraseña no puede estar vacía.';
    echo json_encode($response);
    exit;
}
if (strlen($input['new_password']) < 6) {
    $response['message'] = 'La contraseña debe tener al menos 6 caracteres.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // 3. Obtener datos de la sesión y preparar la nueva contraseña
    $username = $_SESSION['username'];
    $password_hashed = password_hash($input['new_password'], PASSWORD_DEFAULT);

    // 4. Actualizar la contraseña en la base de datos
    $stmt = $conex->prepare("UPDATE `Usuario` SET `Password` = ? WHERE `Username` = ?");
    $stmt->bind_param("ss", $password_hashed, $username);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Contraseña actualizada exitosamente.';
        } else {
            // Esto puede pasar si la nueva contraseña es igual a la anterior
            $response['message'] = 'No se realizaron cambios. La contraseña podría ser la misma.';
        }
    } else {
        $response['message'] = 'Error al ejecutar la actualización: ' . $stmt->error;
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
