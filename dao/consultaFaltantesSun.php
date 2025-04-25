<?php
include_once('db/db_Inventario.php');

ContadorApu();

function ContadorApu() {
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT 
        i.`STLocation`, 
        i.`STBin`, 
        i.`STType`, 
        i.`GrammerNo`, 
        i.`Cantidad`, 
        i.`AreaCve`,
        CONCAT('<button class=\"btn btn-info text-white\" onclick=\"llenarDatos(\\\'', 
               i.`GrammerNo`, '\\\', \\\'', 
               i.`STBin`, '\\\', \\\'', 
               i.`STType`, '\\\')\">Modificar</button>') AS `Boton`
        FROM `InventarioSap` i
        WHERE NOT EXISTS (
            SELECT 1 
            FROM `Storage_Unit` s
            WHERE s.`Numero_Parte` = i.`GrammerNo`
              AND s.`Storage_Bin` = i.`STBin`
              AND s.`Storage_Type` = i.`STType`
              AND s.`Estatus` = 1
        )");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}
?>