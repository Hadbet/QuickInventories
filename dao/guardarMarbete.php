<?php
include_once('db/db_Inventario.php');
try {
    $nombre = $_POST['nombre'];
    $comentarios = $_POST['comentarios'];
    $folioMarbete = $_POST['folioMarbete'];
    $storageUnits = json_decode($_POST['storageUnits'], true);

    $con = new LocalConector();
    $conex=$con->conectar();
    $failedUnits = array();

    $Object = new DateTime();
    $Object->setTimezone(new DateTimeZone('America/Denver'));
    $DateAndTime = $Object->format("Y/m/d h:i:s");

    $stmt = $conex->prepare("UPDATE `Bitacora_Inventario` SET  `Usuario`=?, `Estatus`='2', `PrimerConteo`=?,`Comentario`=? WHERE `Id_Bitacora`=? AND `Estatus` = 0");

    $totalCantidad = 0;

    foreach ($storageUnits as $storageUnit => $details) {
        $numeroParte = $details['numeroParte'];
        $cantidad = $details['cantidad'];
        $totalCantidad += $cantidad;
    }

    $stmt->bind_param("ssss",  $nombre, $totalCantidad, $comentarios, $folioMarbete);

    if (!$stmt->execute()) {
        echo json_encode(["success" => false]);
        throw new Exception('Error al ejecutar la consulta');
    } else {
        $stmt2 = $conex->prepare("UPDATE `Storage_Unit` SET `Estatus`='1',`Conteo`='1',`FolioMarbete`=?,`Cantidad`=? WHERE `Id_StorageUnit` = ?");
        foreach ($storageUnits as $storageUnit => $details) {
            $cantidad = $details['cantidad'];
            $stmt2->bind_param("sss",$folioMarbete,$cantidad,$storageUnit);
            $stmt2->execute();
        }
        $stmt2->close();
        echo json_encode(["success" => true]);
    }

    $stmt->close();
    $conex->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage().$nombre.$storageUnits.$numeroParte. $folioMarbete. $DateAndTime]);
}

?>