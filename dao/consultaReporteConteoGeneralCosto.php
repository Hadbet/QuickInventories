<?php

include_once('db/db_Inventario.php');

ContadorApu();

function ContadorApu()
{
    $con = new LocalConector();
    $conex = $con->conectar();

    $datos = mysqli_query($conex, "SELECT 
                                            SUM(b.`PrimerConteo` * (p.`Por` / p.`Costo`)) AS ValorTotalGeneral
                                        FROM 
                                            `Bitacora_Inventario` b
                                        JOIN 
                                            `Parte` p ON b.`NumeroParte` = p.`GrammerNo`
                                        WHERE 
                                            b.`Estatus` = 2; ");

    $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
    echo json_encode(array("data" => $resultado));
}


?>