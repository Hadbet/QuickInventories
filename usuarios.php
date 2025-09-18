<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Grammer Quick Inventor</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .nav-link.active { @apply bg-white/20 rounded-md; }
    </style>
</head>
<body class="bg-slate-100 font-sans flex flex-col min-h-screen">
<?php include 'estaticos/navegador.php'; ?>

<main class="flex-grow pt-24 pb-10 px-4 md:px-10">
    <!-- Banner Section -->
    <div class="relative h-64 md:h-80 bg-cover bg-center rounded-2xl shadow-lg" style="background-image: url('https://images.unsplash.com/photo-1554435493-93422e8220c8?q=80&w=1936&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center rounded-2xl">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white tracking-wider text-center px-4">
                Administración de Usuarios
            </h2>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Registration Form -->
        <div class="lg:col-span-1">
            <div class="bg-white p-8 rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 text-center">Registrar Nuevo Usuario</h3>
                <form id="add-user-form" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-600 mb-2">Usuario</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-shadow" required>
                    </div>
                    <div>
                        <label for="nombre" class="block text-sm font-semibold text-slate-600 mb-2">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-shadow" required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-600 mb-2">Contraseña</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-shadow" required>
                    </div>
                    <div>
                        <label for="rol" class="block text-sm font-semibold text-slate-600 mb-2">Rol</label>
                        <select id="rol" name="rol" class="bg-white w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-shadow" required>
                            <option value="2">Usuario Normal</option>
                            <option value="1">Super Usuario</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 px-6 rounded-lg hover:bg-slate-900 transition-transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-800">
                        Registrar Usuario
                    </button>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold text-slate-800 mb-6">Lista de Usuarios</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                        <tr class="border-b-2 border-slate-200">
                            <th class="p-3 font-semibold text-slate-600">ID</th>
                            <th class="p-3 font-semibold text-slate-600">Usuario</th>
                            <th class="p-3 font-semibold text-slate-600">Nombre</th>
                            <th class="p-3 font-semibold text-slate-600">Rol</th>
                            <th class="p-3 font-semibold text-slate-600">Estatus</th>
                        </tr>
                        </thead>
                        <tbody id="users-table-body">
                        <!-- User rows will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-slate-800 text-slate-300 p-6 mt-10">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center text-center sm:text-left text-sm space-y-4 sm:space-y-0">
        <p>&copy; <?php echo date('Y'); ?> Grammer S.A. de C.V. Todos los derechos reservados.</p>
        <p>Desarrollado por: <span class="font-semibold">Engadi, Fatima y Hadbet</span></p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const userForm = document.getElementById('add-user-form');
        const tableBody = document.getElementById('users-table-body');

        const loadUsers = async () => {
            try {
                const response = await fetch('dao/get_users.php');
                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();

                if (result.success) {
                    populateTable(result.data);
                } else {
                    showError('Error al cargar usuarios: ' + result.message);
                }
            } catch (error) {
                showError('Error de conexión al cargar usuarios.');
            }
        };

        const populateTable = (users) => {
            tableBody.innerHTML = ''; // Clear existing table
            if(users.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center p-6 text-slate-500">No hay usuarios registrados.</td></tr>`;
                return;
            }

            users.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'border-b border-slate-100 hover:bg-slate-50';

                const rolText = user.Rol == '1' ? 'Super Usuario' : 'Usuario Normal';
                const estatusBadge = user.Estatus == '1'
                    ? `<span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Activo</span>`
                    : `<span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Inactivo</span>`;

                row.innerHTML = `
                <td class="p-3 text-slate-700 font-medium">${user.IdUsuario}</td>
                <td class="p-3 text-slate-700">${user.Username}</td>
                <td class="p-3 text-slate-700">${user.Nombre}</td>
                <td class="p-3 text-slate-700">${rolText}</td>
                <td class="p-3 text-slate-700">${estatusBadge}</td>
            `;
                tableBody.appendChild(row);
            });
        };

        userForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(userForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('dao/add_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: result.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    userForm.reset();
                    loadUsers(); // Refresh the table
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error de Conexión', 'No se pudo registrar el usuario.', 'error');
            }
        });

        const showError = (message) => {
            tableBody.innerHTML = `<tr><td colspan="5" class="text-center p-6 text-red-500">${message}</td></tr>`;
        };

        // Initial load
        loadUsers();
    });
</script>
</body>
</html>

