<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacén - Grammer Quick Inventor</title>
    <?php include 'estaticos/stylesEstandar.php'; ?>
    <style>
        /* Active nav link style */
        .nav-link.active {
            @apply bg-white/20 rounded-md;
        }
        .swal2-popup {
            font-family: 'font-sans';
        }
        .swal2-input {
            border-radius: 0.375rem !important; /* Tailwind's rounded-md */
            border: 1px solid #d1d5db !important; /* Tailwind's border-slate-300 */
        }
        .swal2-input:focus {
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.3) !important; /* Ring for focus */
            border-color: #ea580c !important; /* Tailwind's border-orange-500 */
        }
        .quantity-input:disabled {
            @apply bg-slate-200; /* No longer a pointer as the cell is not the trigger */
        }
    </style>
</head>
<body class="bg-slate-100 font-sans">

<?php include 'estaticos/navegador.php'; ?>

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
        <div id="results-area" class="mt-8 max-w-7xl mx-auto hidden">
            <div class="bg-white p-6 rounded-2xl shadow-lg overflow-x-auto">
                <h3 class="text-2xl font-bold text-slate-800 mb-4">Materiales a Contar</h3>
                <table class="w-full text-left">
                    <thead>
                    <tr class="border-b-2 border-slate-200">
                        <th class="p-3">Material</th>
                        <th class="p-3">Descripción</th>
                        <th class="p-3">Stock Actual</th>
                        <th class="p-3">Cantidad Contada</th>
                        <th class="p-3">Comentarios</th>
                        <th class="p-3">SUN</th>
                        <th class="p-3 text-center">Acción</th>
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
    </div>
</main>
<?php include 'estaticos/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sunInput = document.getElementById('sun-input');
        const resultsArea = document.getElementById('results-area');
        const resultsTbody = document.getElementById('results-tbody');
        const notificationArea = document.getElementById('notification-area');
        const captureButton = document.getElementById('capture-button');
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        let scannedItems = new Set();

        menuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            openIcon.classList.toggle('hidden');
            openIcon.classList.toggle('inline-flex');
            closeIcon.classList.toggle('hidden');
        });

        sunInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && sunInput.value.trim() !== '') {
                e.preventDefault();
                searchSun(sunInput.value.trim());
            }
        });

        async function searchSun(sunValue) {
            if (scannedItems.has(sunValue)) {
                showNotification(`El SUN ${sunValue} ya ha sido agregado a la lista actual.`, 'orange');
                sunInput.value = '';
                sunInput.focus();
                return;
            }

            try {
                const response = await fetch(`https://grammermx.com/Logistica/QuickInventories/dao/search_sun.php?sun=${encodeURIComponent(sunValue)}`);
                if (!response.ok) throw new Error('Network response was not ok.');
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    const firstItem = result.data[0];

                    if (firstItem.Estado == '1') {
                        showNotification(`El SUN ${sunValue} ya fue capturado y no se puede contar de nuevo.`, 'orange');
                        sunInput.value = '';
                        sunInput.focus();
                        return;
                    }

                    resultsArea.classList.remove('hidden');
                    addItemsToTable(result.data);
                    showNotification(`SUN ${sunValue} encontrado y agregado a la lista.`, 'green');

                } else {
                    showNewItemModal(sunValue);
                }
                sunInput.value = '';
                sunInput.focus();

            } catch (error) {
                showNotification(`Error de conexión: ${error.message}`, 'red');
            }
        }

        function addItemsToTable(items) {
            items.forEach(item => {
                if (!item || !item.Sun || scannedItems.has(item.Sun)) return;

                scannedItems.add(item.Sun);
                const row = document.createElement('tr');
                row.className = 'border-b border-slate-200 hover:bg-slate-50';
                row.dataset.id = item.IdInventario;
                row.dataset.originalEstado = item.Estado;

                const stock = parseFloat(String(item.AvadaibleStock).replace(/,/g, '')) || 0;

                row.innerHTML = `
                    <td class="p-3">${item.Material}</td>
                    <td class="p-3">${item.Description}</td>
                    <td class="p-3">${stock} ${item.UnidadMedida}</td>
                    <td class="p-3">
                        <input type="number" value="${stock}" step="any" placeholder="0.00" class="w-32 p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500 quantity-input" disabled>
                    </td>
                    <td class="p-3">
                        <input type="text" placeholder="Comentario..." class="w-full p-2 border border-slate-300 rounded-md focus:ring-orange-500 focus:border-orange-500 comment-input">
                    </td>
                    <td class="p-3 font-mono">${item.Sun}</td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center items-center space-x-3">
                            <button class="text-blue-500 hover:text-blue-700 edit-btn" title="Editar cantidad">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button class="text-red-500 hover:text-red-700 delete-btn" title="Eliminar fila">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                `;
                resultsTbody.appendChild(row);
            });
        }

        resultsTbody.addEventListener('click', (e) => {
            const deleteButton = e.target.closest('.delete-btn');
            if (deleteButton) {
                const row = deleteButton.closest('tr');
                const sunCell = row.cells[5];
                if(sunCell) {
                    const sunToRemove = sunCell.textContent;
                    scannedItems.delete(sunToRemove);
                }
                row.remove();
                if (resultsTbody.rows.length === 0) {
                    resultsArea.classList.add('hidden');
                }
                return;
            }

            const editButton = e.target.closest('.edit-btn');
            if (editButton) {
                const row = editButton.closest('tr');
                const quantityInput = row.querySelector('.quantity-input');

                if (quantityInput && quantityInput.disabled) {
                    Swal.fire({
                        title: '¿Modificar Cantidad?',
                        text: "Solo aplica cuando es una caja abierta. ¿Deseas editar la cantidad?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ea580c',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Sí, editar',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            quantityInput.disabled = false;
                            quantityInput.focus();
                            quantityInput.select();
                        }
                    });
                }
            }
        });

        function showNewItemModal(sunValue) {
            Swal.fire({
                title: 'Registrar Nuevo Material',
                html: `
                    <div class="text-left space-y-4 p-4">
                        <div><label for="modal-material" class="block font-medium text-slate-700 mb-1">Número de Parte (Material) *</label><input type="text" id="modal-material" class="swal2-input w-full"></div>
                        <div><label for="modal-description" class="block font-medium text-slate-700 mb-1">Descripción *</label><input type="text" id="modal-description" class="swal2-input w-full"></div>
                        <div><label for="modal-storagetype" class="block font-medium text-slate-700 mb-1">Storage Type</label><input type="text" id="modal-storagetype" class="swal2-input w-full"></div>
                        <div><label for="modal-storagebin" class="block font-medium text-slate-700 mb-1">Storage Bin</label><input type="text" id="modal-storagebin" class="swal2-input w-full"></div>
                        <div class="flex space-x-4">
                            <div class="flex-1"><label for="modal-quantity" class="block font-medium text-slate-700 mb-1">Cantidad Contada *</label><input type="number" step="any" id="modal-quantity" class="swal2-input w-full"></div>
                            <div class="flex-1"><label for="modal-unit" class="block font-medium text-slate-700 mb-1">Unidad de Medida *</label><input type="text" id="modal-unit" class="swal2-input w-full"></div>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Registrar y Agregar',
                confirmButtonColor: '#ea580c',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                width: '48rem',
                didOpen: () => { document.getElementById('modal-material').focus(); },
                preConfirm: () => {
                    const newItemData = {
                        Sun: sunValue, Material: document.getElementById('modal-material').value, Description: document.getElementById('modal-description').value, StorageType: document.getElementById('modal-storagetype').value, StorageBin: document.getElementById('modal-storagebin').value, CantidadContada: document.getElementById('modal-quantity').value, UnidadMedida: document.getElementById('modal-unit').value,
                    };

                    if (!newItemData.Material || !newItemData.Description || !newItemData.CantidadContada || !newItemData.UnidadMedida) {
                        Swal.showValidationMessage(`Por favor, complete todos los campos requeridos (*).`);
                        return false;
                    }

                    Swal.showLoading();
                    return fetch('https://grammermx.com/Logistica/QuickInventories/dao/insert_inventory.php', {
                        method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(newItemData)
                    })
                        .then(response => {
                            if (!response.ok) throw new Error(`Error del Servidor: ${response.statusText}`);
                            const contentType = response.headers.get("content-type");
                            if (contentType && contentType.includes("application/json")) { return response.json(); }
                            else { return response.text().then(text => { throw new Error(`Respuesta inesperada: ${text}`); }); }
                        })
                        .catch(error => { Swal.showValidationMessage(`La solicitud falló: ${error}`); });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const serverResponse = result.value;
                    if (serverResponse && serverResponse.success) {
                        Swal.fire({ title: '¡Éxito!', text: serverResponse.message, icon: 'success', timer: 1500, showConfirmButton: false });
                        searchSun(sunValue);
                    } else {
                        Swal.fire('Error', `No se pudo registrar: ${serverResponse ? serverResponse.message : 'Respuesta inválida.'}`, 'error');
                    }
                }
            });
        }

        captureButton.addEventListener('click', async () => {
            const itemsToUpdate = [];
            const rows = resultsTbody.querySelectorAll('tr');
            let hasEmptyQuantities = false;

            rows.forEach(row => {
                const quantityInput = row.querySelector('.quantity-input');
                if (!quantityInput.disabled && (quantityInput.value === '' || quantityInput.value === null)) {
                    hasEmptyQuantities = true;
                }
                itemsToUpdate.push({
                    IdInventario: row.dataset.id,
                    CantidadContada: quantityInput.value || 0,
                    Comentario: row.querySelector('.comment-input').value,
                    originalEstado: row.dataset.originalEstado
                });
            });

            if (itemsToUpdate.length === 0) {
                Swal.fire('Atención', 'No hay materiales en la lista para capturar.', 'warning');
                return;
            }

            if (hasEmptyQuantities) {
                const confirmation = await Swal.fire({
                    title: 'Cantidades Vacías', text: "Algunos campos de 'Cantidad Contada' están vacíos y se guardarán como 0. ¿Deseas continuar?", icon: 'warning', showCancelButton: true, confirmButtonColor: '#ea580c', cancelButtonColor: '#64748b', confirmButtonText: 'Sí, continuar', cancelButtonText: 'No, déjame revisar'
                });
                if (!confirmation.isConfirmed) return;
            }

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/update_inventory.php', {
                    method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(itemsToUpdate)
                });
                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '¡Conteo Guardado!', text: result.message, icon: 'success', confirmButtonColor: '#ea580c'
                    }).then(() => {
                        resultsTbody.innerHTML = '';
                        resultsArea.classList.add('hidden');
                        scannedItems.clear();
                    });
                } else { throw new Error(result.message); }
            } catch(error) {
                Swal.fire('Error', `Ocurrió un error al guardar: ${error.message}`, 'error');
            }
        });

        function showNotification(message, color) {
            const colorClasses = {
                green: 'bg-green-100 border-green-400 text-green-700', red: 'bg-red-100 border-red-400 text-red-700', blue: 'bg-blue-100 border-blue-400 text-blue-700', orange: 'bg-orange-100 border-orange-400 text-orange-700',
            };
            notificationArea.innerHTML = `<div class="border-l-4 p-4 ${colorClasses[color]}" role="alert"><p>${message}</p></div>`;
            setTimeout(() => { notificationArea.innerHTML = ''; }, 4000);
        }
    });
</script>
</body>
</html>

