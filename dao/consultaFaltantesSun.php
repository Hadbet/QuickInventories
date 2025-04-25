<?php
include_once('db/db_Inventario.php');

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

try {
    $con = new LocalConector();
    $conex = $con->conectar();

    if (!$conex) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $query = "
        SELECT 
    i.`STLocation`, 
    i.`STBin`, 
    i.`STType`, 
    i.`GrammerNo`, 
    i.`Cantidad`, 
    i.`AreaCve`,
    CONCAT(
        '<button class=\"btn btn-info text-white\" onclick=\"llenarDatos(\'\', \'', 
        i.`GrammerNo`, 
        '\', \'\', \'\', \'', 
        i.`STBin`, 
        '\', \'', 
        i.`STType`, 
        '\')\">Modificar</button>'
    ) AS `Boton`
FROM `InventarioSap` i
WHERE NOT EXISTS (
    SELECT 1 
    FROM `Storage_Unit` s
    WHERE s.`Numero_Parte` = i.`GrammerNo`
      AND s.`Storage_Bin` = i.`STBin`
      AND s.`Storage_Type` = i.`STType`
      AND s.`Estatus` = 1
)
    ";

    $result = mysqli_query($conex, $query);

    if (!$result) {
        throw new Exception("Error en la consulta SQL: " . mysqli_error($conex));
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode(["data" => $data]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>