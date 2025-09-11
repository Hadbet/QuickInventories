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
            @apply bg-orange-600 text-white;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans">

<!-- Top Navigation Bar -->
<nav class="bg-slate-900 text-white shadow-lg fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <h1 class="text-2xl font-bold text-orange-400">Grammer Quick Inventor</h1>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-2">
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Inicio</a>
                <a href="#" class="nav-link active px-3 py-2 rounded-md text-sm font-medium">Carga</a>
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Producción</a>
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Almacén</a>
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Location</a>
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Usuarios</a>
                <a href="#" class="nav-link px-3 py-2 rounded-md text-sm font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Salir</a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-slate-700 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="menu-open-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Inicio</a>
            <a href="#" class="block nav-link active px-3 py-2 rounded-md text-base font-medium">Carga</a>
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Producción</a>
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Almacén</a>
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Location</a>
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Usuarios</a>
            <a href="#" class="block nav-link px-3 py-2 rounded-md text-base font-medium text-slate-300 hover:bg-orange-600 hover:text-white">Salir</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="pt-24 p-6 md:p-10">
    <h2 class="text-3xl font-bold text-slate-700 mb-8">Carga de Datos Masiva</h2>

    <div id="notification" class="hidden p-4 mb-6 rounded-lg"></div>

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
</main>

<script>
    // --- State and DOM Elements ---
    const fileInput = document.getElementById('lx02-file');
    const filenameDisplay = document.getElementById('lx02-filename');
    const processButton = document.getElementById('process-lx02');
    const notification = document.getElementById('notification');
    let inventoryItems = [];

    // --- Mobile Menu Logic ---
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-open-icon');
    const closeIcon = document.getElementById('menu-close-icon');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        openIcon.classList.toggle('hidden');
        openIcon.classList.toggle('inline-flex');
        closeIcon.classList.toggle('hidden');
    });

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
        // Corregido: Los datos empiezan en la fila 8 (índice 7 del array)
        const dataStartIndex = 7;

        if (data.length <= dataStartIndex) {
            showNotification('El archivo no tiene el formato esperado o está vacío.', 'red');
            resetFileState();
            return;
        }

        // Corregido: Mapeo de columnas según el formato real del Excel.
        // B=1, D=3, E=4, F=5, G=6, I=8, J=9, K=10, O=14
        inventoryItems = data.slice(dataStartIndex).map(row => {
            // Se valida que la fila tenga suficientes columnas y que el Material (columna B) no esté vacío.
            if (row.length < 2 || !row[1]) return null;

            // Limpia el número de stock, quitando comas.
            const stockString = String(row[9] || '0').replace(/,/g, '');

            return {
                Material: String(row[1]).trim(),
                Plant: String(row[3]).trim(),
                StorageLocation: String(row[4]).trim(),
                Description: String(row[5]).trim(),
                StorageType: String(row[6] || '').trim(),
                StorageBin: String(row[8] || '').trim(),
                AvadaibleStock: parseFloat(stockString),
                UnidadMedida: String(row[10]).trim(),
                Sun: String(row[14] || '').trim(), // Columna O es Storage Unit
                CantidadContada: 0,
                UsuarioContador: 'Carga Masiva LX02',
                Comentario: '',
                Tipo: 'LX02'
            };
        }).filter(item => item !== null); // Filtra las filas que no eran válidas (null).

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

    // --- Backend Communication ---
    async function sendDataToBackend(data) {
        try {
            const response = await fetch('upload_lx02.php', {
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
        notification.className = `p-4 mb-6 rounded-lg text-white font-semibold transition-opacity duration-300`;
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

