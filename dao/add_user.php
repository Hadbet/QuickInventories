<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

// Validación básica de entrada
if (empty($input['username']) || empty($input['nombre']) || empty($input['password']) || empty($input['rol'])) {
    $response['message'] = 'Todos los campos son obligatorios.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Variables del formulario
    $username = $input['username'];
    $nombre = $input['nombre'];
    $rol = $input['rol'];
    // Encriptar la contraseña para almacenamiento seguro
    $password_hashed = password_hash($input['password'], PASSWORD_DEFAULT);
    $estatus = 1; // 1 = Activo por defecto

    // Verificar si el nombre de usuario ya existe para evitar duplicados
    $stmt_check = $conex->prepare("SELECT IdUsuario FROM Usuario WHERE Username = ?");
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $response['message'] = 'El nombre de usuario ya existe. Por favor, elige otro.';
        $stmt_check->close();
        $conex->close();
        echo json_encode($response);
        exit;
    }
    $stmt_check->close();

    // Si no existe, proceder con la inserción
    $stmt = $conex->prepare(
        "INSERT INTO `Usuario` (`Username`, `Nombre`, `Password`, `Rol`, `Estatus`) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssis", $username, $nombre, $password_hashed, $rol, $estatus);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = 'Usuario registrado exitosamente.';
        } else {
            $response['message'] = 'No se pudo registrar el usuario. Inténtalo de nuevo.';
        }
    } else {
        $response['message'] = 'Error al ejecutar la inserción: ' . $stmt->error;
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
