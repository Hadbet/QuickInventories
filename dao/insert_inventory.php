<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input)) {
    $response['message'] = 'No se recibieron datos para insertar.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Valores fijos y recibidos del formulario
    $plant = "3330";
    $avadaibleStock = $input['CantidadContada']; // El mismo que la cantidad contada
    $estado = 2; // Estado 2 para nuevos registros
    $usuario = "Hadbet";
    $tipo = "Manual"; // Tipo de carga

    $stmt = $conex->prepare(
        "INSERT INTO `Inventario` (`Material`, `Plant`, `StorageLocation`, `Description`, `StorageType`, `StorageBin`, `AvadaibleStock`, `UnidadMedida`, `Sun`, `CantidadContada`, `UsuarioContador`, `Comentario`, `Tipo`, `Estado`) 
        VALUES (?, ?, '', ?, ?, ?, ?, ?, ?, ?, ?, '', ?, ?)"
    );

    // Ajuste para `StorageLocation` (dejado en blanco) y `Comentario` (dejado en blanco)
    $stmt->bind_param(
        "sssssdssdsis",
        $input['Material'],
        $plant,
        $input['Description'],
        $input['StorageType'],
        $input['StorageBin'],
        $avadaibleStock,
        $input['UnidadMedida'],
        $input['Sun'],
        $input['CantidadContada'],
        $usuario,
        $tipo,
        $estado
    );

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response['success'] = true;
        $response['message'] = 'Nuevo material registrado exitosamente.';
    } else {
        $response['message'] = 'No se pudo insertar el registro.';
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
