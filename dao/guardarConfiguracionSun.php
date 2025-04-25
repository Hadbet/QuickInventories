<?php
include_once('db/db_Inventario.php');

$sun = $_POST['sun'];
$estatus = $_POST['estatus'];
$marbete = $_POST['marbete'];

try {
    $con = new LocalConector();
    $conex=$con->conectar();

    $stmt = $conex->prepare("UPDATE `Storage_Unit` SET `Estatus`=?,`FolioMarbete`=? WHERE `Id_StorageUnit` = ?");
    $stmt->bind_param("sss", $estatus,$marbete,$sun);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true, "message" => "Inserción exitosa"]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo insertar el registro"]);
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

?>