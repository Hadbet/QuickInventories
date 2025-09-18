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
    <!-- XLSX for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Chart.js for Graphs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<?php include 'estaticos/navegador.php'; ?>

<main class="pt-24 pb-10 px-4 md:px-10">
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Chart 1: Counts by User -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Registros Contados por Usuario</h3>
            <div>
                <canvas id="userCountsChart"></canvas>
            </div>
        </div>
        <!-- Chart 2: Stock Difference -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-xl font-bold text-slate-800 mb-4 text-center">Comparativa de Stock Total</h3>
            <div>
                <canvas id="stockDifferenceChart"></canvas>
            </div>
        </div>
    </div>

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
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
            <h3 class="flex items-center text-2xl font-bold text-slate-800 mb-4 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-3 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Análisis de Inventario
            </h3>
            <button id="download-excel-btn" class="bg-green-600 text-white font-bold py-2 px-5 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                <span>Descargar Excel</span>
            </button>
        </div>
        <div id="analysis-table-container" class="table-container overflow-auto"></div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // --- Chart instances (to prevent duplicates) ---
        let userCountsChart = null;
        let stockDifferenceChart = null;

        const createTable = (headers, data, containerId) => { /* ... (código sin cambios) ... */ };

        // --- **NUEVA FUNCIÓN PARA RENDERIZAR GRÁFICA DE USUARIOS** ---
        const renderUserCountsChart = (summaryData) => {
            const ctx = document.getElementById('userCountsChart').getContext('2d');
            const labels = Object.keys(summaryData.countsByUser);
            const data = Object.values(summaryData.countsByUser);

            if (userCountsChart) {
                userCountsChart.destroy(); // Destroy previous chart instance
            }

            userCountsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Registros Contados',
                        data: data,
                        backgroundColor: 'rgba(234, 88, 12, 0.6)',
                        borderColor: 'rgba(234, 88, 12, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1 // Only show whole numbers
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        };

        // --- **NUEVA FUNCIÓN PARA RENDERIZAR GRÁFICA DE DIFERENCIAS** ---
        const renderStockDifferenceChart = (summaryData) => {
            const ctx = document.getElementById('stockDifferenceChart').getContext('2d');
            const data = summaryData.stockComparison;

            if (stockDifferenceChart) {
                stockDifferenceChart.destroy();
            }

            stockDifferenceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Stock en Sistema', 'Stock Contado'],
                    datasets: [{
                        label: 'Unidades Totales',
                        data: [data.system, data.counted],
                        backgroundColor: [
                            'rgba(100, 116, 139, 0.6)', // slate-500
                            'rgba(234, 88, 12, 0.6)'   // orange-500
                        ],
                        borderColor: [
                            'rgba(100, 116, 139, 1)',
                            'rgba(234, 88, 12, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` ${context.dataset.label}: ${context.parsed.y.toLocaleString('es-MX')}`;
                                }
                            }
                        }
                    }
                }
            });
        };


        const loadInventoryData = async () => {
            try {
                // Modificado para obtener la respuesta completa
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/get_inventory_summary.php');

                // Mejor manejo de errores
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error(`Error del servidor: ${response.status} ${response.statusText}. Respuesta: ${errorText}`);
                }

                const result = await response.json();

                if (result.success) {
                    const allData = result.data;
                    const summary = result.summary; // **OBTENER DATOS DE RESUMEN**

                    analysisDataForExport = allData;

                    // --- **LLAMAR A LAS FUNCIONES PARA RENDERIZAR GRÁFICAS** ---
                    renderUserCountsChart(summary);
                    renderStockDifferenceChart(summary);

                    // --- El resto del código para las tablas sigue igual ---
                    const pending = allData.filter(item => item.Estado == '0');
                    const captured = allData.filter(item => item.Estado == '1');
                    const newSystem = allData.filter(item => item.Estado == '2');

                    const capturedHeaders = [ { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Contador', key: 'UsuarioContador' }, { label: 'Comentario', key: 'Comentario' } ];
                    const pendingHeaders = [ { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Stock Sistema', key: 'AvadaibleStock' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Ubicación', key: 'StorageBin' } ];
                    const newSystemHeaders = [ { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' }, { label: 'Contador', key: 'UsuarioContador' }, { label: 'Ubicación', key: 'StorageBin' } ];

                    const analysisHeaders = [
                        { label: 'Material', key: 'Material' }, { label: 'Descripción', key: 'Description' }, { label: 'Ubicación', key: 'StorageBin' }, { label: 'SUN', key: 'Sun' }, { label: 'Stock Sistema', key: 'AvadaibleStock' }, { label: 'Cant. Contada', key: 'CantidadContada' }, { label: 'UM', key: 'UnidadMedida' },
                        { label: 'Cumplimiento', key: 'Cumplimiento', format: (row) => { /* ... */ } },
                        { label: 'Costo Total Contado', key: 'CostoTotalContado', format: (row) => { /* ... */ } },
                        { label: 'Contador', key: 'UsuarioContador' }
                    ];

                    createTable(pendingHeaders, pending, 'pending-table-container');
                    createTable(capturedHeaders, captured, 'captured-table-container');
                    createTable(newSystemHeaders, newSystem, 'new-system-table-container');
                    createTable(analysisHeaders, allData, 'analysis-table-container');

                } else { throw new Error(result.message); }
            } catch (error) {
                console.error('Error loading inventory data:', error);
                // ... (código de manejo de errores sin cambios) ...
            }
        };

        const downloadBtn = document.getElementById('download-excel-btn');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', () => { /* ... (código sin cambios) ... */ });
        }
        loadInventoryData();
    });
</script>
</body>
</html>
