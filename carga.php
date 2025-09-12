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
            @apply bg-white/20 rounded-md;
        }
    </style>
</head>
<body class="bg-slate-100 font-sans">

<!-- Top Navigation Bar -->
<nav class="bg-gradient-to-r from-orange-600 to-orange-800 text-white shadow-xl fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0 flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h1 class="text-2xl font-bold text-white">Grammer Quick Inventor</h1>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-2">
                <a href="inicio.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span>Inicio</span>
                </a>
                <a href="carga.php" class="nav-link active flex items-center space-x-2 px-3 py-2 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    <span>Carga</span>
                </a>
                <a href="produccion.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0L8 8.25H3.74a1 1 0 00-.98 1.26l.96 4.87a1 1 0 00.98.74H17a1 1 0 00.98-.74l.96-4.87a1 1 0 00-.98-1.26H12l-.51-5.08zM12 15a1 1 0 100 2h-4a1 1 0 100-2h4z" clip-rule="evenodd" /></svg>
                    <span>Producción</span>
                </a>
                <a href="almacen.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6z" /></svg>
                    <span>Almacén</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                    <span>Location</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                    <span>Usuarios</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" /></svg>
                    <span>Salir</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/20 focus:outline-none">
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
            <a href="inicio.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Inicio</span></a>
            <a href="carga.php" class="block nav-link active flex items-center space-x-2 px-3 py-2 text-base font-medium"><span>Carga</span></a>
            <a href="produccion.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Producción</span></a>
            <a href="almacen.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Almacén</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Location</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Usuarios</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Salir</span></a>
        </div>
    </div>
</nav>

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

