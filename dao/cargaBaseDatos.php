<?php

header('Content-Type: application/json');
include_once('db/db_Machinery.php');

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if ($data === null || !is_array($data)) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "message" => "Error: No se recibieron datos válidos."]);
    exit;
}

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    $stmt = $conex->prepare(
        "INSERT INTO `Inventario` (`Material`, `Plant`, `StorageLocation`, `Description`, `StorageType`, `StorageBin`, `AvadaibleStock`, `UnidadMedida`, `Sun`, `CantidadContada`, `UsuarioContador`, `Comentario`, `Tipo`) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt === false) {
        throw new Exception("Error al preparar la consulta: " . $conex->error);
    }

    $registros_insertados = 0;

    foreach ($data as $item) {
        $stmt->bind_param(
            "ssssssdssdsss",
            $item['Material'],
            $item['Plant'],
            $item['StorageLocation'],
            $item['Description'],
            $item['StorageType'],
            $item['StorageBin'],
            $item['AvadaibleStock'],
            $item['UnidadMedida'],
            $item['Sun'],
            $item['CantidadContada'],
            $item['UsuarioContador'],
            $item['Comentario'],
            $item['Tipo']
        );

        if ($stmt->execute()) {
            $registros_insertados++;
        }
    }

    if ($registros_insertados > 0) {
        echo json_encode(["success" => true, "message" => "Carga exitosa: Se guardaron " . $registros_insertados . " registros."]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo insertar ningún registro. Verifique los datos."]);
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>

