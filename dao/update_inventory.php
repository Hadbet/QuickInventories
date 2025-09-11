<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input)) {
    $response['message'] = 'No se recibieron datos para actualizar.';
    echo json_encode($response);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();
    $conex->begin_transaction();

    // El estado 1 significa que fue contado/actualizado
    $estado = 1;
    $usuario = "Hadbet"; // Usuario fijo por el momento

    $stmt = $conex->prepare("UPDATE `Inventario` SET `CantidadContada`= ?, `UsuarioContador`= ?, `Comentario`= ?, `Estado`= ? WHERE `IdInventario` = ?");

    foreach ($input as $item) {
        $stmt->bind_param("dssii", $item['CantidadContada'], $usuario, $item['Comentario'], $estado, $item['IdInventario']);
        $stmt->execute();
    }

    $conex->commit();
    $response['success'] = true;
    $response['message'] = 'El conteo se ha guardado correctamente.';

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    if (isset($conex)) {
        $conex->rollback();
    }
    http_response_code(500);
    $response['message'] = 'Error al actualizar la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
