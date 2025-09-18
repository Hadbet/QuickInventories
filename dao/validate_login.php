<?php
// Iniciar la sesión al principio de todo
session_start();
header('Content-Type: application/json');
include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => 'Usuario o contraseña incorrectos.'];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['username']) || empty($input['password'])) {
    $response['message'] = 'Por favor, introduce el usuario y la contraseña.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    $username = $input['username'];
    $password = $input['password'];

    // Consulta preparada para obtener los datos del usuario
    $stmt = $conex->prepare("SELECT Password, Estatus, Nombre, Rol FROM Usuario WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña hasheada
        if (password_verify($password, $user['Password'])) {

            // **CAMBIO CLAVE: Verificar si el usuario está activo (Estatus = 1)**
            if ($user['Estatus'] == '1') {
                // Las credenciales son correctas y el usuario está activo
                // Iniciar sesión y guardar todos los datos del usuario
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['nombre'] = $user['Nombre'];
                $_SESSION['rol'] = $user['Rol'];
                $_SESSION['estatus'] = $user['Estatus']; // Se añade el estatus a la sesión

                $response['success'] = true;
                $response['message'] = 'Login exitoso.';
            } else {
                // El usuario existe pero su estatus es 0 (inactivo/bloqueado)
                $response['message'] = 'Tu usuario está inactivo o bloqueado. Contacta al administrador.';
            }
        }
        // Si la contraseña no es correcta, se devuelve el mensaje por defecto: "Usuario o contraseña incorrectos."
    }
    // Si el usuario no existe, se devuelve el mensaje por defecto: "Usuario o contraseña incorrectos."

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
}

echo json_encode($response);
?>

