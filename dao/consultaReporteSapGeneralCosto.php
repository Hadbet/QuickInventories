<?php

include_once('db/db_Inventario.php');

ContadorApu();

function ContadorApu()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT SUM(i.`Cantidad` * (p.`Por` / p.`Costo`)) AS ValorTotalGeneral 
                                            FROM `InventarioSap` i JOIN `Parte` p ON i.`GrammerNo` = p.`GrammerNo` WHERE 1;");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}


?>