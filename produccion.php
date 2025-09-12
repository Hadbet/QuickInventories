<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producción - Grammer Quick Inventor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
                <a href="index.html" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                    <span>Inicio</span>
                </a>
                <a href="index.html" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                    <span>Carga</span>
                </a>
                <a href="produccion.html" class="nav-link active flex items-center space-x-2 px-3 py-2 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0L8 8.25H3.74a1 1 0 00-.98 1.26l.96 4.87a1 1 0 00.98 .74H17a1 1 0 00.98-.74l.96-4.87a1 1 0 00-.98-1.26H12l-.51-5.08zM12 15a1 1 0 100 2h-4a1 1 0 100-2h4z" clip-rule="evenodd" /></svg>
                    <span>Producción</span>
                </a>
                <a href="almacen.html" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md">
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
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="inicio.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Inicio</span></a>
            <a href="carga.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Carga</span></a>
            <a href="produccion.php" class="block nav-link active flex items-center space-x-2 px-3 py-2 text-base font-medium"><span>Producción</span></a>
            <a href="almacen.php" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Almacén</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Location</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Usuarios</span></a>
            <a href="#" class="block nav-link flex items-center space-x-2 px-3 py-2 text-base font-medium text-white hover:bg-white/20 rounded-md"><span>Salir</span></a>
        </div>
    </div>
</nav>

<main>
    <!-- Banner Section -->
    <div class="relative h-64 md:h-80 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1555505019-8c3f1c4aba5f?q=80&w=1974&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-wider text-center px-4">
                Captura de Producción
            </h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-10 p-6 md:p-10">
        <!-- Search Section -->
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-slate-700 mb-6 text-center">Buscar Material en Ubicación</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="material-input" class="block text-sm font-medium text-slate-600 mb-1">Número de Parte (Material)</label>
                    <input type="text" id="material-input" placeholder="Introduce el número de parte..." class="w-full p-3 border border-slate-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 transition">
                </div>
                <div>
                    <label for="storagebin-input" class="block text-sm font-medium text-slate-600 mb-1">Storage Bin</label>
                    <input type="text" id="storagebin-input" placeholder="Introduce el Storage Bin..." class="w-full p-3 border border-slate-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 transition">
                </div>
            </div>
            <div id="notification-area" class="mt-6"></div>
        </div>

        <!-- Capture Form Area -->
        <div id="capture-form-area" class="mt-8 max-w-4xl mx-auto hidden">
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">Detalles del Material</h3>
                <div class="space-y-4">
                    <input type="hidden" id="inventory-id">
                    <div>
                        <label class="block text-sm font-medium text-slate-500">Descripción</label>
                        <input type="text" id="description-output" class="w-full mt-1 p-3 bg-slate-100 border border-slate-300 rounded-lg" readonly>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-500">Unidad de Medida</label>
                            <input type="text" id="unit-output" class="w-full mt-1 p-3 bg-slate-100 border border-slate-300 rounded-lg" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-500">Storage Type</label>
                            <input type="text" id="storagetype-output" class="w-full mt-1 p-3 bg-slate-100 border border-slate-300 rounded-lg" readonly>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6 pt-4">
                        <div>
                            <label for="quantity-input" class="block text-sm font-medium text-slate-700">Cantidad Producida *</label>
                            <input type="number" step="any" id="quantity-input" placeholder="0.00" class="w-full mt-1 p-3 border border-slate-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div>
                            <label for="comments-input" class="block text-sm font-medium text-slate-700">Comentarios</label>
                            <input type="text" id="comments-input" placeholder="Añade un comentario..." class="w-full mt-1 p-3 border border-slate-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-right">
                    <button id="capture-button" class="bg-orange-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-orange-700 transition-colors text-lg">
                        Capturar
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const materialInput = document.getElementById('material-input');
        const storagebinInput = document.getElementById('storagebin-input');
        const notificationArea = document.getElementById('notification-area');
        const captureFormArea = document.getElementById('capture-form-area');
        const captureButton = document.getElementById('capture-button');

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

        const handleSearch = () => {
            const material = materialInput.value.trim();
            const storageBin = storagebinInput.value.trim();

            if (material && storageBin) {
                searchMaterial(material, storageBin);
            }
        };

        materialInput.addEventListener('keypress', e => e.key === 'Enter' && handleSearch());
        storagebinInput.addEventListener('keypress', e => e.key === 'Enter' && handleSearch());

        async function searchMaterial(material, storageBin) {
            try {
                const response = await fetch(`https://grammermx.com/Logistica/QuickInventories/dao/search_production.php?material=${encodeURIComponent(material)}&storagebin=${encodeURIComponent(storageBin)}`);
                if (!response.ok) throw new Error('La respuesta del servidor no fue correcta.');
                const result = await response.json();

                if (result.success && result.data) {
                    notificationArea.innerHTML = '';
                    populateCaptureForm(result.data);
                } else {
                    captureFormArea.classList.add('hidden');
                    showNotification(result.message || 'Material no encontrado en esta ubicación.', 'orange');
                }
            } catch (error) {
                showNotification(`Error de conexión: ${error.message}`, 'red');
            }
        }

        function populateCaptureForm(data) {
            document.getElementById('inventory-id').value = data.IdInventario;
            document.getElementById('description-output').value = data.Description;
            document.getElementById('unit-output').value = data.UnidadMedida;
            document.getElementById('storagetype-output').value = data.StorageType;
            document.getElementById('quantity-input').value = '';
            document.getElementById('comments-input').value = '';

            captureFormArea.classList.remove('hidden');
            document.getElementById('quantity-input').focus();
        }

        captureButton.addEventListener('click', async () => {
            const updateData = {
                IdInventario: document.getElementById('inventory-id').value,
                CantidadContada: document.getElementById('quantity-input').value,
                Comentario: document.getElementById('comments-input').value,
            };

            if (!updateData.CantidadContada) {
                Swal.fire('Campo Requerido', 'Por favor, introduce la cantidad producida.', 'warning');
                return;
            }

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/update_production.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(updateData)
                });
                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: result.message,
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        // Reset form
                        captureFormArea.classList.add('hidden');
                        materialInput.value = '';
                        storagebinInput.value = '';
                        materialInput.focus();
                    });
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                Swal.fire('Error', `Ocurrió un error al guardar: ${error.message}`, 'error');
            }
        });

        function showNotification(message, color) {
            const colorClasses = {
                green: 'bg-green-100 border-green-400 text-green-700',
                red: 'bg-red-100 border-red-400 text-red-700',
                orange: 'bg-orange-100 border-orange-400 text-orange-700',
            };
            notificationArea.innerHTML = `<div class="border-l-4 p-4 ${colorClasses[color]}" role="alert"><p>${message}</p></div>`;
            setTimeout(() => { notificationArea.innerHTML = ''; }, 5000);
        }
    });
</script>
</body>
</html>
