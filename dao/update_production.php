<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php'); // Asegúrate que la ruta sea correcta

$response = ['success' => false, 'message' => 'Datos inválidos.'];
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['IdInventario']) && isset($data['CantidadContada'])) {
    $idInventario = $data['IdInventario'];
    $cantidadContada = $data['CantidadContada'];
    $comentario = $data['Comentario'] ?? ''; // Usar operador de fusión de null
    $usuarioContador = $_SESSION['nombre']; // Usuario fijo temporalmente
    $estado = '1';

    // Validación básica
    if (empty($idInventario) || !is_numeric($cantidadContada)) {
        $response['message'] = 'El ID de inventario o la cantidad no son válidos.';
        echo json_encode($response);
        exit;
    }

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('America/Denver')); // Considera usar 'America/Mexico_City' si aplica
    $DateAndTime = $Object->format("Y-m-d H:i:s");

    try {
        $con = new LocalConector();
        $conex = $con->conectar();

        $stmt = $conex->prepare("UPDATE `Inventario` SET `CantidadContada` = ?, `UsuarioContador` = ?, `Comentario` = ?, `Estado` = ?, `FechaCaptura` = ? WHERE `IdInventario` = ?");
        $stmt->bind_param("dsssis", $cantidadContada, $usuarioContador, $comentario, $estado, $idInventario,$DateAndTime);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'La captura de producción se guardó exitosamente.'];
            } else {
                $response['message'] = 'No se realizaron cambios. El material ya tenía estos datos.';
            }
        } else {
            $response['message'] = 'Error al ejecutar la actualización.';
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
