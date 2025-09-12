<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Grammer Quick Inventor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .nav-link.active {
            @apply bg-white/20 rounded-md;
        }
        /* Custom scrollbar for tables */
        .table-container::-webkit-scrollbar {
            height: 8px;
        }
        .table-container::-webkit-scrollbar-track {
            background: #f1f5f9; /* slate-100 */
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* slate-300 */
            border-radius: 4px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* slate-400 */
        }
    </style>
</head>
<body class="bg-slate-100 font-sans">

<!-- Top Navigation Bar -->
<nav class="bg-gradient-to-r from-orange-600 to-orange-800 text-white shadow-xl fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <div class="flex-shrink-0 flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                <h1 class="text-2xl font-bold text-white">Grammer Quick Inventor</h1>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <a href="inicio.php" class="nav-link active flex items-center space-x-2 px-3 py-2 text-sm font-medium"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg><span>Inicio</span></a>
                <a href="carga.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg><span>Carga</span></a>
                <a href="produccion.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0L8 8.25H3.74a1 1 0 00-.98 1.26l.96 4.87a1 1 0 00.98 .74H17a1 1 0 00.98-.74l.96-4.87a1 1 0 00-.98-1.26H12l-.51-5.08zM12 15a1 1 0 100 2h-4a1 1 0 100-2h4z" clip-rule="evenodd" /></svg><span>Producción</span></a>
                <a href="almacen.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6z" /></svg><span>Almacén</span></a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg><span>Location</span></a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg><span>Usuarios</span></a>
                <a href="#" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" /></svg><span>Salir</span></a>
            </div>
            <div class="md:hidden flex items-center"><button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/20 focus:outline-none"><svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path id="menu-open-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /><path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button></div>
        </div>
    </div>
    <div id="mobile-menu" class="md:hidden hidden"><div class="px-2 pt-2 pb-3 space-y-1 sm:px-3"></div></div>
</nav>

<main class="pt-24 pb-10 px-4 md:px-10">
    <!-- Status Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Pendientes -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="flex items-center text-xl font-bold text-slate-800 mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Pendientes</h3>
            <div id="pending-table-container" class="table-container max-h-80 overflow-auto"></div>
        </div>
        <!-- Capturados -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="flex items-center text-xl font-bold text-slate-800 mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Capturados</h3>
            <div id="captured-table-container" class="table-container max-h-80 overflow-auto"></div>
        </div>
        <!-- Fuera de Sistema -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="flex items-center text-xl font-bold text-slate-800 mb-4"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Fuera de Sistema</h3>
            <div id="new-system-table-container" class="table-container max-h-80 overflow-auto"></div>
        </div>
    </div>

    <!-- Analysis Table -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-2xl font-bold text-slate-800 mb-4">Análisis de Inventario</h3>
        <div id="analysis-table-container" class="table-container overflow-auto"></div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Mobile menu logic
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuButton) {
            menuButton.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }

        const createTable = (headers, data, containerId) => {
            const container = document.getElementById(containerId);
            if (!container) return;

            if (data.length === 0) {
                container.innerHTML = `<div class="text-center py-10 text-slate-500">No hay datos para mostrar.</div>`;
                return;
            }

            let tableHtml = '<table class="w-full text-left text-sm">';
            tableHtml += '<thead><tr class="border-b-2 border-slate-200">';
            headers.forEach(h => tableHtml += `<th class="p-3 font-semibold text-slate-600">${h.label}</th>`);
            tableHtml += '</tr></thead><tbody>';

            data.forEach(row => {
                tableHtml += '<tr class="border-b border-slate-100 hover:bg-slate-50">';
                headers.forEach(h => {
                    let value = row[h.key] ?? 'N/A';
                    if (h.format) {
                        value = h.format(row);
                    }
                    tableHtml += `<td class="p-3 text-slate-700">${value}</td>`;
                });
                tableHtml += '</tr>';
            });

            tableHtml += '</tbody></table>';
            container.innerHTML = tableHtml;
        };

        const loadInventoryData = async () => {
            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/get_inventory_summary.php');
                if (!response.ok) throw new Error('Network response was not ok.');
                const result = await response.json();

                if (result.success) {
                    const allData = result.data;

                    // Filter data for status tables
                    const pending = allData.filter(item => item.Estado == '0');
                    const captured = allData.filter(item => item.Estado == '1');
                    const newSystem = allData.filter(item => item.Estado == '2');

                    // Define headers for each table
                    const capturedHeaders = [
                        { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Contador', key: 'UsuarioContador' }, { label: 'Comentario', key: 'Comentario' }
                    ];
                    const pendingHeaders = [
                        { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Stock Sistema', key: 'AvadaibleStock' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Ubicación', key: 'StorageBin' }
                    ];
                    const newSystemHeaders = [
                        { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Contador', key: 'UsuarioContador' }, { label: 'Ubicación', key: 'StorageBin' }
                    ];
                    const analysisHeaders = [
                        { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Ubicación', key: 'StorageBin' }, { label: 'Stock Sistema', key: 'AvadaibleStock' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' },
                        {
                            label: 'Cumplimiento',
                            key: 'Cumplimiento',
                            format: (row) => {
                                const available = parseFloat(row.AvadaibleStock);
                                const counted = parseFloat(row.CantidadContada);
                                if (isNaN(available) || isNaN(counted)) return '<span class="text-slate-400">N/A</span>';
                                if (available > 0) {
                                    const percentage = (counted / available) * 100;
                                    const color = percentage < 95 ? 'text-red-500' : (percentage > 105 ? 'text-blue-500' : 'text-green-500');
                                    return `<span class="font-bold ${color}">${percentage.toFixed(1)}%</span>`;
                                }
                                if (available === 0 && counted === 0) return '<span class="font-bold text-green-500">100%</span>';
                                return '<span class="font-bold text-sky-500">Extra</span>';
                            }
                        },
                        {
                            label: 'Costo Total Contado',
                            key: 'CostoTotalContado',
                            format: (row) => {
                                const cost = parseFloat(row.CostoTotalContado);
                                if (isNaN(cost)) return '<span class="text-slate-400">N/A</span>';
                                return cost.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' });
                            }
                        },
                        { label: 'Contador', key: 'UsuarioContador' }
                    ];

                    // Create tables
                    createTable(pendingHeaders, pending, 'pending-table-container');
                    createTable(capturedHeaders, captured, 'captured-table-container');
                    createTable(newSystemHeaders, newSystem, 'new-system-table-container');
                    createTable(analysisHeaders, allData, 'analysis-table-container');

                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                console.error('Error loading inventory data:', error);
                const containers = ['pending-table-container', 'captured-table-container', 'new-system-table-container', 'analysis-table-container'];
                containers.forEach(id => {
                    const el = document.getElementById(id);
                    if(el) el.innerHTML = `<div class="text-center py-10 text-red-500">Error al cargar los datos: ${error.message}</div>`;
                });
            }
        };

        loadInventoryData();
    });
</script>
</body>
</html>
