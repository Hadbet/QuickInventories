<?php
session_start();
header('Content-Type: application/json');

// Solo los Super Usuarios (rol 1) pueden borrar el catálogo
if (!isset($_SESSION['loggedin']) || $_SESSION['rol'] != '1') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado.']);
    exit;
}

include_once('../db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Usamos TRUNCATE para la tabla de Partes, es más eficiente y resetea el auto_increment.
    $sql = "TRUNCATE TABLE `Parte`";

    if ($conex->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Todos los registros del catálogo de partes han sido eliminados.';
    } else {
        $response['message'] = 'Error al ejecutar la limpieza de la tabla: ' . $conex->error;
    }

    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error de conexión a la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>

