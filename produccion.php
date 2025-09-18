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
<?php include 'estaticos/navegador.php'; ?>
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
                            <label for="quantity-input" class="block text-sm font-medium text-slate-700">Cantidad Contada *</label>
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
<?php include 'estaticos/footer.php'; ?>

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
