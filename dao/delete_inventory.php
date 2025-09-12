<?php
header('Content-Type: application/json');
// Asegúrate que la ruta al archivo de conexión sea correcta desde la carpeta 'dao'
include_once('db/db_Inventario.php');

$response = ['success' => false, 'message' => ''];

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // La consulta TRUNCATE es más eficiente para borrar todos los datos de una tabla.
    // También reinicia los contadores AUTO_INCREMENT.
    // Si prefieres DELETE, puedes usar: $sql = "DELETE FROM `Inventario`";
    $sql = "TRUNCATE TABLE `Inventario`";

    if ($conex->query($sql) === TRUE) {
        $response['success'] = true;
        $response['message'] = 'Todos los registros de inventario han sido eliminados exitosamente.';
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
