<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacén - Grammer Quick Inventor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Active nav link style */
        .nav-link.active {
            @apply bg-white/20 rounded-md;
        }
        .swal2-popup {
            font-family: 'font-sans';
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
                <a href="index.html" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span>Inicio</span>
                </a>
                <a href="index.html" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    <span>Carga</span>
                </a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0L8 8.25H3.74a1 1 0 00-.98 1.26l.96 4.87a1 1 0 00.98.74H17a1 1 0 00.98-.74l.96-4.87a1 1 0 00-.98-1.26H12l-.51-5.08zM12 15a1 1 0 100 2h-4a1 1 0 100-2h4z" clip-rule="evenodd" /></svg>
                    <span>Producción</span>
                </a>
                <a href="almacen.html" class="nav-link active flex items-center space-x-2 px-3 py-2 text-sm font-medium">
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
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path id="menu-open-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden"><div class="px-2 pt-2 pb-3 space-y-1 sm:px-3"></div></div>
</nav>

<main>
    <!-- Banner Section -->
    <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1586528116311-06924112d76a?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-wider text-center px-4">
                Captura de SUN
            </h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-10 p-6 md:p-10">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-bold text-slate-700 mb-4 text-center">Escanea o introduce un SUN</h2>
            <div class="relative">
                <input type="text" id="sun-input" placeholder="Introduce el código SUN y presiona Enter..." class="w-full p-4 pr-12 text-lg border-2 border-slate-300 rounded-full shadow-sm focus:ring-orange-500 focus:border-orange-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute right-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>

        <div id="notification-area" class="max-w-4xl mx-auto mt-6"></div>

        <!-- Results Area -->
        <div id="results-area" class="mt-8 max-w-6xl mx-auto hidden">
            <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Resultados</h3>
                <table class="w-full text-left">
                    <thead>
                    <tr class="border-b-2 border-slate-200">
                        <th class="p-3">Material</th>
                        <th class="p-3">Descripción</th>
                        <th class="p-3">Stock Actual</th>
                        <th class="p-3">Cantidad Contada</th>
                        <th class="p-3">Comentarios</th>
                        <th class="p-3">SUN</th>
                    </tr>
                    </thead>
                    <tbody id="results-tbody">
                    <!-- Rows will be inserted here by JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <button id="capture-button" class="bg-slate-800 text-white font-bold py-3 px-12 rounded-lg hover:bg-slate-900 transition-colors text-lg">
                    Capturar Conteo
                </button>
            </div>
        </div>

        <!-- New Item Form Area -->
        <div id="new-item-form-area" class="mt-8 max-w-4xl mx-auto hidden">
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold text-slate-800 mb-6">SUN no encontrado - Registrar Nuevo Material</h3>
                <form id="new-item-form" class="space-y-4">
                    <input type="hidden" id="new-sun-hidden">
                    <div>
                        <label for="new-material" class="block font-medium text-slate-700">Número de Parte (Material)</label>
                        <input type="text" id="new-material" required class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label for="new-description" class="block font-medium text-slate-700">Descripción</label>
                        <input type="text" id="new-description" required class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new-storagetype" class="block font-medium text-slate-700">Storage Type</label>
                            <input type="text" id="new-storagetype" class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="new-storagebin" class="block font-medium text-slate-700">Storage Bin</label>
                            <input type="text" id="new-storagebin" class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new-quantity" class="block font-medium text-slate-700">Cantidad Contada</label>
                            <input type="number" id="new-quantity" step="any" required class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="new-unit" class="block font-medium text-slate-700">Unidad de Medida</label>
                            <input type="text" id="new-unit" required class="w-full mt-1 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                    <div class="text-right pt-4">
                        <button type="submit" class="bg-orange-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-700 transition-colors">
                            Registrar Nuevo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sunInput = document.getElementById('sun-input');
        const resultsArea = document.getElementById('results-area');
        const resultsTbody = document.getElementById('results-tbody');
        const newItemFormArea = document.getElementById('new-item-form-area');
        const newItemForm = document.getElementById('new-item-form');
        const notificationArea = document.getElementById('notification-area');
        const captureButton = document.getElementById('capture-button');

        let scannedItems = new Set();

        sunInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && sunInput.value.trim() !== '') {
                e.preventDefault();
                searchSun(sunInput.value.trim());
            }
        });

        async function searchSun(sunValue) {
            if (scannedItems.has(sunValue)) {
                showNotification(`El SUN ${sunValue} ya ha sido agregado a la lista.`, 'orange');
                sunInput.value = '';
                sunInput.focus();
                return;
            }

            try {
                const response = await fetch(`https://grammermx.com/Logistica/QuickInventories/dao/search_sun.php?sun=${encodeURIComponent(sunValue)}`);
                if (!response.ok) throw new Error('Network response was not ok.');
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    newItemFormArea.classList.add('hidden');
                    resultsArea.classList.remove('hidden');
                    addItemsToTable(result.data);
                    showNotification(`SUN ${sunValue} encontrado y agregado.`, 'green');
                } else {
                    document.getElementById('new-sun-hidden').value = sunValue;
                    resultsArea.classList.add('hidden');
                    newItemFormArea.classList.remove('hidden');
                    showNotification(`SUN ${sunValue} no encontrado. Por favor, registre los datos.`, 'blue');
                }
                sunInput.value = '';
                sunInput.focus();

            } catch (error) {
                showNotification(`Error de conexión: ${error.message}`, 'red');
            }
        }

        function addItemsToTable(items) {
            items.forEach(item => {
                if (scannedItems.has(item.Sun)) return;

                scannedItems.add(item.Sun);
                const row = document.createElement('tr');
                row.className = 'border-b border-slate-200 hover:bg-slate-50';
                row.dataset.id = item.IdInventario;

                row.innerHTML = `
                    <td class="p-3">${item.Material}</td>
                    <td class="p-3">${item.Description}</td>
                    <td class="p-3">${item.AvadaibleStock} ${item.UnidadMedida}</td>
                    <td class="p-3">
                        <input type="number" step="any" placeholder="0.00" class="w-32 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500 quantity-input">
                    </td>
                    <td class="p-3">
                        <input type="text" placeholder="Comentario..." class="w-full p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500 comment-input">
                    </td>
                    <td class="p-3">${item.Sun}</td>
                `;
                resultsTbody.appendChild(row);
            });
        }

        newItemForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newItemData = {
                Sun: document.getElementById('new-sun-hidden').value,
                Material: document.getElementById('new-material').value,
                Description: document.getElementById('new-description').value,
                StorageType: document.getElementById('new-storagetype').value,
                StorageBin: document.getElementById('new-storagebin').value,
                CantidadContada: document.getElementById('new-quantity').value,
                UnidadMedida: document.getElementById('new-unit').value,
            };

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/insert_inventory.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(newItemData)
                });
                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    });
                    newItemForm.reset();
                    newItemFormArea.classList.add('hidden');
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                Swal.fire({
                    title: 'Error',
                    text: `No se pudo registrar el material: ${error.message}`,
                    icon: 'error',
                    confirmButtonColor: '#ea580c'
                });
            }
        });

        captureButton.addEventListener('click', async () => {
            const itemsToUpdate = [];
            const rows = resultsTbody.querySelectorAll('tr');

            rows.forEach(row => {
                const quantityInput = row.querySelector('.quantity-input');
                if (quantityInput.value !== '') {
                    itemsToUpdate.push({
                        IdInventario: row.dataset.id,
                        CantidadContada: quantityInput.value,
                        Comentario: row.querySelector('.comment-input').value
                    });
                }
            });

            if (itemsToUpdate.length === 0) {
                Swal.fire('Atención', 'No has introducido ninguna cantidad contada.', 'warning');
                return;
            }

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/update_inventory.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(itemsToUpdate)
                });
                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '¡Conteo Guardado!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        resultsTbody.innerHTML = '';
                        resultsArea.classList.add('hidden');
                        scannedItems.clear();
                    });
                } else {
                    throw new Error(result.message);
                }
            } catch(error) {
                Swal.fire('Error', `Ocurrió un error al guardar: ${error.message}`, 'error');
            }
        });

        function showNotification(message, color) {
            const colorClasses = {
                green: 'bg-green-100 border-green-400 text-green-700',
                red: 'bg-red-100 border-red-400 text-red-700',
                blue: 'bg-blue-100 border-blue-400 text-blue-700',
                orange: 'bg-orange-100 border-orange-400 text-orange-700',
            };
            notificationArea.innerHTML = `<div class="border-l-4 p-4 ${colorClasses[color]}" role="alert"><p>${message}</p></div>`;
        }
    });
</script>
</body>
</html>
