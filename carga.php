<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grammer Quick Inventor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SheetJS (xlsx.js) for reading Excel files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .upload-card {
            @apply bg-white rounded-2xl shadow-lg p-8 text-center transition-all duration-300;
        }
        .upload-card:hover {
            @apply scale-105 shadow-2xl;
        }
        input[type="file"] {
            display: none;
        }
        /* Active nav link style */
        .nav-link.active {
            @apply bg-white/20 rounded-md;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans">

<?php include 'estaticos/navegador.php'; ?>

<main>
    <!-- Banner Section -->
    <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-wider text-center px-4">
                Carga de Archivos
            </h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-10 p-6 md:p-10">
        <h2 class="text-3xl font-bold text-slate-700 mb-8 text-center">Sube tu archivo de inventario</h2>

        <div id="notification" class="hidden p-4 mb-6 rounded-lg max-w-4xl mx-auto"></div>

        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">

            <!-- Card LX02 -->
            <div class="upload-card">
                <label for="lx02-file" class="cursor-pointer group">
                    <svg class="w-24 h-24 mx-auto text-green-600 mb-4 transition-transform duration-300 group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Cargar Archivo LX02</h3>
                    <p class="text-gray-500 mb-6">Sube el archivo de stock con descripción de material.</p>
                    <span class="inline-block bg-orange-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-600 transition-colors">Seleccionar Archivo</span>
                    <p id="lx02-filename" class="mt-4 text-sm text-slate-600 truncate"></p>
                </label>
                <input type="file" id="lx02-file" accept=".xlsx, .xls">
                <button id="process-lx02" class="mt-4 w-full bg-slate-800 text-white font-bold py-3 px-8 rounded-lg hover:bg-slate-900 transition-colors disabled:bg-slate-400 disabled:cursor-not-allowed" disabled>
                    Procesar y Cargar
                </button>
            </div>

            <!-- Card MM60 -->
            <div class="upload-card opacity-60">
                <svg class="w-24 h-24 mx-auto text-green-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Cargar Archivo MM60</h3>
                <p class="text-gray-500">Próximamente disponible.</p>
            </div>
        </div>

        <!-- Maintenance Section -->
        <div class="mt-16 pt-8 border-t-2 border-slate-200">
            <h2 class="text-2xl font-bold text-slate-700 mb-8 text-center">Acciones de Mantenimiento</h2>
            <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <!-- Delete Inventario Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Borrar Inventario (LX02)</h3>
                    <p class="text-gray-500 mb-6">Elimina todos los registros de la tabla `Inventario`.</p>
                    <button id="delete-inventory-btn" class="w-full bg-red-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-red-700 transition-colors">
                        Borrar Registros
                    </button>
                </div>
                <!-- Delete Partes Card -->
                <div class="bg-white rounded-2xl shadow-lg p-8 text-center opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto text-red-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Borrar Catálogo (MM60)</h3>
                    <p class="text-gray-500 mb-6">Elimina los registros de la tabla `Parte` (Próximamente).</p>
                    <button id="delete-parts-btn" class="w-full bg-red-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-red-700 transition-colors" disabled>
                        Borrar Catálogo
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // --- State and DOM Elements ---
    const fileInput = document.getElementById('lx02-file');
    const filenameDisplay = document.getElementById('lx02-filename');
    const processButton = document.getElementById('process-lx02');
    const notification = document.getElementById('notification');
    const deleteInventoryBtn = document.getElementById('delete-inventory-btn');
    const deletePartsBtn = document.getElementById('delete-parts-btn');
    let inventoryItems = [];

    // --- Mobile Menu Logic ---
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-open-icon');
    const closeIcon = document.getElementById('menu-close-icon');

    if(menuButton){
        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            openIcon.classList.toggle('hidden');
            openIcon.classList.toggle('inline-flex');
            closeIcon.classList.toggle('hidden');
        });
    }

    // --- Excel File Handling Logic ---
    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) {
            resetFileState();
            return;
        }

        filenameDisplay.textContent = file.name;
        showNotification('Archivo listo. Procesando contenido...', 'blue');

        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const sheetData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                handleParsingComplete(sheetData);
            } catch (err) {
                handleParsingError('Error al procesar el archivo Excel.');
            }
        };
        reader.onerror = () => handleParsingError('Error al leer el archivo.');
        reader.readAsArrayBuffer(file);
    });

    function handleParsingComplete(data) {
        const dataStartIndex = 7;
        if (data.length <= dataStartIndex) {
            showNotification('El archivo no tiene el formato esperado o está vacío.', 'red');
            resetFileState();
            return;
        }

        inventoryItems = data.slice(dataStartIndex).map(row => {
            if (row.length < 2 || !row[1]) return null;
            const stockString = String(row[9] || '0').replace(/,/g, '');
            return {
                Material: String(row[1]).trim(), Plant: String(row[3]).trim(), StorageLocation: String(row[4]).trim(), Description: String(row[5]).trim(), StorageType: String(row[6] || '').trim(), StorageBin: String(row[8] || '').trim(), AvadaibleStock: parseFloat(stockString), UnidadMedida: String(row[10]).trim(), Sun: String(row[14] || '').trim(), CantidadContada: 0, UsuarioContador: '', Comentario: '', Tipo: ''
            };
        }).filter(item => item !== null);

        if (inventoryItems.length > 0) {
            showNotification(`Se encontraron ${inventoryItems.length} registros válidos. Listo para procesar.`, 'green');
            processButton.disabled = false;
        } else {
            showNotification('No se encontraron datos válidos en el archivo. Revisa el formato y las columnas.', 'orange');
            resetFileState();
        }
    }

    function handleParsingError(message) {
        showNotification(message, 'red');
        resetFileState();
    }

    function resetFileState() {
        fileInput.value = '';
        filenameDisplay.textContent = '';
        processButton.disabled = true;
        inventoryItems = [];
    }

    // --- Button Actions ---
    processButton.addEventListener('click', () => {
        if (inventoryItems.length === 0) {
            showNotification('No hay datos para procesar.', 'red');
            return;
        }
        processButton.disabled = true;
        processButton.textContent = 'Enviando...';
        sendDataToBackend(inventoryItems);
    });

    deleteInventoryBtn.addEventListener('click', () => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminarán TODOS los registros de la tabla de inventario. ¡Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, ¡bórralo todo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // El archivo PHP debe estar en la carpeta 'dao'
                fetch('https://grammermx.com/Logistica/QuickInventories/dao/delete_inventory.php', { method: 'POST' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Eliminado!', data.message, 'success');
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error de Conexión', error.message, 'error'));
            }
        });
    });

    // --- Backend Communication ---
    async function sendDataToBackend(data) {
        try {
            const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/cargaBaseDatos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (!response.ok) throw new Error(`Error del servidor: ${response.statusText}`);
            const result = await response.json();

            if (result.success) {
                showNotification(result.message, 'green');
                resetFileState();
            } else {
                showNotification('Error al guardar: ' + result.message, 'red');
            }
        } catch (error) {
            showNotification('Error de conexión: ' + error.message, 'red');
        } finally {
            processButton.disabled = false;
            processButton.textContent = 'Procesar y Cargar';
        }
    }

    // --- UI Notifications ---
    function showNotification(message, color) {
        notification.textContent = message;
        notification.className = `p-4 mb-6 rounded-lg text-white font-semibold transition-opacity duration-300 max-w-4xl mx-auto`;
        const colorClasses = {
            green: 'bg-green-500', red: 'bg-red-500',
            blue: 'bg-blue-500', orange: 'bg-orange-500'
        };
        notification.classList.add(colorClasses[color] || 'bg-gray-500');
        notification.classList.remove('hidden');
    }
</script>
</body>
</html>
