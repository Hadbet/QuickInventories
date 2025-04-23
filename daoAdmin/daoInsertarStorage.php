<?php
require_once ('funcionesInvenStorage.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar el cuerpo JSON
    $inputData = json_decode(file_get_contents("php://input"), true);

    if (isset($inputData['storageDatos']) && is_array($inputData['storageDatos'])) {
        $todosExitosos = true;
        $errores = [];

        foreach ($inputData['storageDatos'] as $registroStorage) {
            // Validar y asignar valores
            $id_StorageUnit = isset($registroStorage['id_StorageUnit']) ? trim($registroStorage['id_StorageUnit']) : null;
            $Numero_Parte = isset($registroStorage['Numero_Parte']) ? trim($registroStorage['Numero_Parte']) : null;
            $Cantidad = isset($registroStorage['Cantidad']) ? trim($registroStorage['Cantidad']) : null;
            $Storage_Bin = isset($registroStorage['Storage_Bin']) ? trim($registroStorage['Storage_Bin']) : null;
            $Storage_Type = isset($registroStorage['Storage_Type']) ? trim($registroStorage['Storage_Type']) : null;

            // Validar que los datos esenciales no sean nulos o vacíos
            if ($id_StorageUnit === null || $Numero_Parte === null || $Cantidad === null || $Storage_Bin === null || $Storage_Type === null ) {
                $errores[] = "Faltan datos para el registro id_StorageUnit: $id_StorageUnit, Numero_Parte: $Numero_Parte, Cantidad: $Cantidad, Storage_Bin: $Storage_Bin, Storage_Type: $Storage_Type";
                $todosExitosos = false;
            } else {
                // Llamar a la función de inserción
                $respuestaInsert = insertarRegistrosStorage($id_StorageUnit, $Numero_Parte, $Cantidad, $Storage_Bin, $Storage_Type);
                if ($respuestaInsert['status'] !== 'success') {
                    $errores[] = "Error al insertar el registro ID: $id_StorageUnit. " . $respuestaInsert['message'];
                    $todosExitosos = false;
                    break;  // Salir del ciclo si ocurre un error
                }
            }
        }

        // Respuesta final si todos fueron exitosos
        if ($todosExitosos) {
            $respuesta = actualizarInventario();
            //$respuesta = array("status" => 'success', "message" => "Todos los registros en la Tabla Storage_Unit fueron actualizados correctamente.");
        } else {
            $respuesta = array("status" => 'error', "message" => "Se encontraron errores al insertar los registros.", "detalles" => $errores);
        }
    } else {
        $respuesta = array("status" => 'error', "message" => "Datos no válidos.");
    }
} else {
    $respuesta = array("status" => 'error', "message" => "Se esperaba REQUEST_METHOD POST");
}

echo json_encode($respuesta);

?>