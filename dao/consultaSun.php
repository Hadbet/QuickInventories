<?php

include_once('db/db_Inventario.php');

$numeroParte = $_GET['numeroParte'];
$storageBin = $_GET['storageBin'];
$storageType = $_GET['storageType'];

ContadorApu($numeroParte,$storageBin,$storageType);
function ContadorApu($numeroParte,$storageBin,$storageType)
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT * FROM `Storage_Unit` WHERE `Numero_Parte` = '$numeroParte' and `Storage_Bin` = '$storageBin' and `Storage_Type` = '$storageType';");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}


?>