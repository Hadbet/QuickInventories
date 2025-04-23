/**********************************************************************************************************************/
/********************************************************TABLA BITACORA***********************************************/
/**********************************************************************************************************************/

document.getElementById('btnTxtBitacora').addEventListener('click', () => {
    document.getElementById('fileInputTxt').click();
});

document.getElementById('fileInputTxt').addEventListener('change', async (event) => {
    const files = event.target.files; // Todos los archivos seleccionados
    console.log("Archivos seleccionados:", files);  // Verifica los archivos seleccionados

    if (files.length > 0) {
        for (const file of files) {
            console.log("Procesando archivo:", file.name);

            // Procesar cada archivo y enviar los datos al backend
            const dataToBackend = await manejarArchivo(file);
            const dataFromBackend = await enviarDatosAlBackend(dataToBackend);

            if (dataFromBackend.length > 0) {
                // Solo actualiza si dataFromBackend tiene datos
                actualizarContenidoArchivo(file, dataFromBackend);
            } else {
                console.error(`No se recibieron datos válidos del backend para el archivo ${file.name}.`);
            }
        }
    } else {
        console.error("No se seleccionaron archivos.");
    }
});

async function manejarArchivo(file) {
    const reader = new FileReader();

    return new Promise((resolve, reject) => {
        reader.onload = async (event) => {
            const contenido = event.target.result;

            // Dividir las líneas del archivo
            const lineas = contenido.split(/\r?\n/);

            // Filtrar las líneas que contienen datos válidos
            const datos = lineas
                .map((linea) => linea.trim())
                .filter((linea) => /^[0-9]+\s+\w+/.test(linea))
                .map((linea) => {
                    const partes = linea.split(/\s+/);
                    return partes.length >= 6
                        ? { storBin: partes[1], materialNo: partes[5] }
                        : null;
                })
                .filter(Boolean);

            // Resolvemos la promesa con los datos procesados
            resolve(datos);
        };

        reader.onerror = (error) => {
            reject("Error al leer el archivo: " + error);
        };

        reader.readAsText(file);
    });
}

async function actualizarContenidoArchivo(file, dataFromBackend) {
    const reader = new FileReader();

    reader.onload = async function (event) {
        const originalContent = event.target.result;
        const originalLines = originalContent.split(/\r?\n/);
        const noMatchData = [];
        const updatedLines = originalLines.map((line) => {
            const parts = line.trim().split(/\s+/);

            if (parts.length >= 6) {
                const storBin = parts[1];
                const materialNo = parts[5];

                const matchingData = dataFromBackend.find(
                    (item) => item.storBin === storBin && item.materialNo === materialNo
                );

                if (matchingData) {
                    return line.replace("______________", matchingData.conteoFinal);
                } else {
                    noMatchData.push({ storBin, materialNo });
                    return line.replace("______________",'0');
                }
            }

            return line;
        });



        const finalContent = updatedLines.join("\n");
        const blob = new Blob([finalContent], { type: "text/plain" });

        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = `actualizado_${file.name}`;
        link.click();

        dataFromBackend = await enviarDatosAlBackendAux(noMatchData);
        descargarDataFromBackendPro(dataFromBackend);
    };

    reader.readAsText(file);
}

async function enviarDatosAlBackend(data) {
    try {
        const response = await fetch('daoAdmin/daoActualizar-txt.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', },
            body: JSON.stringify(data),
        });
        return await response.json();
    } catch (error) {
        console.error('Error enviando datos al backend:', error);
        return [];
    }
}

async function enviarDatosAlBackendAux(data) {
    try {
        const response = await fetch('daoAdmin/daoActualizar-txtAux.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', },
            body: JSON.stringify(data),
        });
        return await response.json();
    } catch (error) {
        console.error('Error enviando datos al backend:', error);
        return [];
    }
}
function descargarDataFromBackendPro(dataFromBackend) {
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "SheetJS",
        Subject: "Numeros de parte faltantes",
        Author: "Hadbetsito",
        CreatedDate: new Date()
    };
    wb.SheetNames.push("Test Sheet");
    var ws_data = [['InventoryItem', 'Record', 'Bin', 'Bin/n', 'Contador', 'Numero Parte', 'Plant','Cantidad','Type']]; // Encabezados de las columnas

    var storBinCounts = {}; // Para llevar un registro de los 'StorBin' que ya hemos visto

    for (var i = 0; i < dataFromBackend.length; i++) {
        var inventoryItem = dataFromBackend[i].inventoryItem;
        var storage_Bin = dataFromBackend[i].storageBin;
        var invRecount = dataFromBackend[i].invRecount;
        var numeroParte = dataFromBackend[i].material;
        var cantidad = dataFromBackend[i].conteoFinal;
        var plan = dataFromBackend[i].plan;
        var storage_Type = dataFromBackend[i].storageType;

        // Si 'numeroParte' está vacío, saltar esta iteración
        if (!numeroParte) {
            continue;
        }

        // Si 'StorBin' no comienza con 'P', añadir un contador al final
        var storage_Bin_Modified = storage_Bin;
        if (!storage_Bin.startsWith('P')) {
            storage_Bin_Modified = storage_Bin + '/' + (storBinCounts[storage_Bin] || 1);
            storBinCounts[storage_Bin] = (storBinCounts[storage_Bin] || 0) + 1;
        }

        ws_data.push([inventoryItem, invRecount, storage_Bin, storage_Bin+"/"+storBinCounts[storage_Bin], storBinCounts[storage_Bin], numeroParte, plan, cantidad, storage_Type]);
    }

    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    wb.Sheets["Test Sheet"] = ws;
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }

    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Numeros de parte faltantes.xlsx');
}


/**********************************************************************************************************************/
/*****************************************************TABLA STORAGE_UNIT***********************************************/
/**********************************************************************************************************************/

var nombreArchivoStorage="";
document.getElementById('btnTxtStorage').addEventListener('click', () => {
    document.getElementById('fileInputTxtS').click();
});
document.getElementById('fileInputTxtS').addEventListener('change', async (event) => {
    const files = Array.from(event.target.files);
    console.log("Archivos seleccionados:", files);
    const allNoMatchData = [];
    for (const file of files) {
        console.log("Procesando archivo:", file.name);

        if (file) {
            try {
                const dataToBackend = await manejarArchivoStorage(file);
                const dataFromBackend = await enviarDatosAlBackendStorage(dataToBackend);

                if (dataFromBackend.length > 0) {
                    const noMatchData = await actualizarArchivoStorage(file, dataFromBackend);
                    if (Array.isArray(noMatchData)) {
                        allNoMatchData.push(...noMatchData);
                    } else {
                        console.error(`noMatchData no es un array:`, noMatchData);
                    }
                } else {
                    console.error(`No se recibieron datos válidos del backend para ${file.name}.`);
                }
            } catch (error) {
                console.error(`Error procesando el archivo ${file.name}:`, error);
            }
        } else {
            console.error(`No se seleccionó ningún archivo.`);
        }
    }

    if (allNoMatchData.length > 0) {
        await handleNoMatchData(allNoMatchData,nombreArchivoStorage);
    }
});

async function manejarArchivoStorage(file) {
    const reader = new FileReader();

    return new Promise((resolve, reject) => {
        reader.onload = async (event) => {
            const contenido = event.target.result;
            const lineas = contenido.split(/\r?\n/);

            const datos = lineas
                .map((linea) => linea.trim())
                .filter((linea) => /^[0-9]+\s+\w+/.test(linea))
                .map((linea) => {
                    const partes = linea.split(/\s+/);
                    return partes.length >= 2
                        ? { storBin: partes[1], storUnit: partes[6] }
                        : null;
                })
                .filter(Boolean);

            resolve(datos);
        };

        reader.onerror = (error) => {
            reject("Error al leer el archivo: " + error);
        };

        reader.readAsText(file);
    });
}

async function enviarDatosAlBackendStorage(data) {
    try {
        const response = await fetch('daoAdmin/daoActualizarStorage-txt.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', },
            body: JSON.stringify(data),
        });

        const jsonResponse = await response.json();
        return jsonResponse;
    } catch (error) {
        console.error('Error enviando datos al backend:', error);
        return [];
    }
}

async function actualizarArchivoStorage(file, dataFromBackend) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        const noMatchData = [];

        reader.onload = async function (event) {
            const originalContent = event.target.result;
            const originalLines = originalContent.split(/\r?\n/);

            const updatedLines = originalLines.map((line) => {
                const parts = line.trim().split(/\s+/);

                if (parts.length >= 8) {
                    const storBin = parts[1].trim();
                    const storUnit = parts[6].trim();

                    const matchingData = dataFromBackend.find(
                        (item) => item.storBin === storBin && item.storUnit === storUnit
                    );

                    if (matchingData) {
                        return line.replace(/____________/, matchingData.cantidad);
                    } else {
                        noMatchData.push({ storUnit });
                        return line.replace(/____________/, '0');
                    }
                }

                return line;
            });

            const finalContent = updatedLines.join("\n");
            const blob = new Blob([finalContent], { type: "text/plain" });

            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = `actualizado_${file.name}`;
            link.click();
            nombreArchivoStorage=`${file.name}`;
            resolve(noMatchData);
        };

        reader.onerror = (error) => {
            console.error("Error al leer el archivo:", error);
            reject(error);
        };

        reader.readAsText(file);
    });
}

async function handleNoMatchData(noMatchData,nombreArchivoStorage) {
    const dataFromBackendAux = await enviarDatosAlBackendStorageAux(noMatchData);
    descargarDataFromBackend(dataFromBackendAux,nombreArchivoStorage);
}

async function enviarDatosAlBackendStorageAux(data) {
    try {
        const response = await fetch('daoAdmin/daoActualizarStorage-txtAux.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', },
            body: JSON.stringify({ storageUnits: data }),
        });

        const jsonResponse = await response.json();
        return jsonResponse;
    } catch (error) {
        console.error('Error enviando datos al backend:', error);
        return [];
    }
}

function descargarDataFromBackend(dataFromBackend,nombreArchivoStorage) {
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "SheetJS",
        Subject: nombreArchivoStorage,
        Author: "Hadbetsito",
        CreatedDate: new Date()
    };
    wb.SheetNames.push("Test Sheet");
    var ws_data = [['InventoryItem', 'Page', 'Bin', 'Bin/n', 'Contador', 'Numero Parte', 'Plant','Cantidad','Sun','Type']];

    var storBinCounts = {};

    for (var i = 0; i < dataFromBackend.length; i++) {
        var storageUnit = dataFromBackend[i].storageUnit;
        var inventoryItem = dataFromBackend[i].inventoryItem;
        var storage_Bin = dataFromBackend[i].storage_Bin;
        var invRecount = dataFromBackend[i].inventoryPage;
        var numeroParte = dataFromBackend[i].numero_Parte;
        var cantidad = dataFromBackend[i].cantidad;
        var plan = dataFromBackend[i].plan;
        var storage_Type = dataFromBackend[i].storage_Type;

        if (!numeroParte) {
            continue;
        }

        var storage_Bin_Modified = storage_Bin;
        if (!storage_Bin.startsWith('P')) {
            storage_Bin_Modified = storage_Bin + '/' + (storBinCounts[storage_Bin] || 1);
            storBinCounts[storage_Bin] = (storBinCounts[storage_Bin] || 0) + 1;
        }

        ws_data.push([inventoryItem, invRecount, storage_Bin, storage_Bin+"/"+storBinCounts[storage_Bin], storBinCounts[storage_Bin], numeroParte, plan, cantidad,storageUnit, storage_Type]);
    }

    var ws = XLSX.utils.aoa_to_sheet(ws_data);
    wb.Sheets["Test Sheet"] = ws;
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }

    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), nombreArchivoStorage+'.xlsx');
}