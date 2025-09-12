<?php
header('Content-Type: application/json');
include_once('db/db_Inventario.php'); // Asegúrate que la ruta sea correcta

$response = ['success' => false, 'message' => 'No se pudo procesar la solicitud.'];

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    // Consulta principal que une Inventario con Parte
    $sql = "SELECT 
                i.IdInventario, i.Material, i.Plant, i.StorageLocation, i.Description, 
                i.StorageType, i.StorageBin, i.AvadaibleStock, i.UnidadMedida, i.Sun, 
                i.CantidadContada, i.UsuarioContador, i.Comentario, i.Tipo, i.Estado,
                p.Costo, p.Por
            FROM 
                Inventario i
            LEFT JOIN 
                Parte p ON i.Material = p.GrammerNo";

    $result = $conex->query($sql);

    if ($result) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            // Calcular el costo total contado en PHP para manejar casos nulos
            $costoTotalContado = null;
            if (isset($row['Costo']) && isset($row['Por']) && is_numeric($row['Costo']) && is_numeric($row['Por']) && $row['Por'] != 0) {
                $costoUnitario = $row['Costo'] / $row['Por'];
                $costoTotalContado = $costoUnitario * $row['CantidadContada'];
            }
            // Agregar el costo calculado a la fila
            $row['CostoTotalContado'] = $costoTotalContado;

            // Quitar los datos de costo crudos para no enviarlos al frontend
            unset($row['Costo']);
            unset($row['Por']);

            $data[] = $row;
        }
        $response = ['success' => true, 'data' => $data];
    } else {
        $response['message'] = 'Error al ejecutar la consulta: ' . $conex->error;
    }

    $conex->close();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
}

echo json_encode($response);
?>
