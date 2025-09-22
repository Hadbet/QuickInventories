<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Grammer Quick Inventor</title>
    <?php include 'estaticos/stylesEstandar.php'; ?>
    <style>
        .nav-link.active { @apply bg-white/20 rounded-md; }
        .swal2-input, .swal2-select {
            border-radius: 0.375rem !important;
            border: 1px solid #d1d5db !important;
        }
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
                            <th class="p-3 font-semibold text-slate-600 text-center">Acciones</th>
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
        let allUsersData = [];

        const loadUsers = async () => {
            try {
                const response = await fetch('dao/get_users.php');
                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();
                if (result.success) {
                    allUsersData = result.data;
                    populateTable(allUsersData);
                } else {
                    showError('Error al cargar usuarios: ' + result.message);
                }
            } catch (error) {
                showError('Error de conexión al cargar usuarios.');
            }
        };

        const populateTable = (users) => {
            tableBody.innerHTML = '';
            if (users.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-slate-500">No hay usuarios registrados.</td></tr>`;
                return;
            }

            users.forEach(user => {
                const row = document.createElement('tr');
                row.className = 'border-b border-slate-100 hover:bg-slate-50';

                const rolText = user.Rol == '1' ? 'Super Usuario' : 'Usuario Normal';
                const estatusBadge = user.Estatus == '1'
                    ? `<span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Activo</span>`
                    : `<span class="px-3 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Inactivo</span>`;

                const toggleIcon = user.Estatus == '1'
                    ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>` // Inactivar
                    : `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" /></svg>`; // Activar

                row.innerHTML = `
                    <td class="p-3 text-slate-700 font-medium">${user.IdUsuario}</td>
                    <td class="p-3 text-slate-700">${user.Username}</td>
                    <td class="p-3 text-slate-700">${user.Nombre}</td>
                    <td class="p-3 text-slate-700">${rolText}</td>
                    <td class="p-3 text-slate-700">${estatusBadge}</td>
                    <td class="p-3 text-center">
                        <div class="flex justify-center items-center space-x-4">
                            <button class="toggle-status-btn text-gray-500 hover:text-orange-500" data-userid="${user.IdUsuario}" data-status="${user.Estatus}" title="${user.Estatus == '1' ? 'Inactivar' : 'Activar'}">
                                ${toggleIcon}
                            </button>
                            <button class="edit-user-btn text-gray-500 hover:text-blue-500" data-userid="${user.IdUsuario}" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        };

        tableBody.addEventListener('click', (e) => {
            const toggleBtn = e.target.closest('.toggle-status-btn');
            const editBtn = e.target.closest('.edit-user-btn');

            if (toggleBtn) handleToggleStatus(toggleBtn);
            if (editBtn) handleEditUser(editBtn);
        });

        const handleToggleStatus = (button) => {
            const userId = button.dataset.userid;
            const currentStatus = button.dataset.status;
            const newStatus = currentStatus == '1' ? '0' : '1';
            const actionText = currentStatus == '1' ? 'inactivar' : 'activar';

            Swal.fire({
                title: `¿Estás seguro?`,
                text: `Se va a ${actionText} a este usuario.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#64748b',
                confirmButtonText: `Sí, ${actionText}`,
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/toggle_user_status.php', {
                            method: 'POST', headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ userId, newStatus })
                        });
                        const res = await response.json();
                        if (res.success) {
                            Swal.fire('¡Actualizado!', res.message, 'success');
                            loadUsers();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error de Conexión', 'No se pudo actualizar el estado.', 'error');
                    }
                }
            });
        };

        const handleEditUser = (button) => {
            const userId = button.dataset.userid;
            const user = allUsersData.find(u => u.IdUsuario == userId);
            if (!user) return;

            Swal.fire({
                title: 'Editar Usuario',
                html: `
                    <div class="text-left space-y-4 p-4">
                        <div><label for="swal-username" class="block font-medium text-slate-700 mb-1">Usuario</label><input type="text" id="swal-username" class="swal2-input w-full" value="${user.Username}"></div>
                        <div><label for="swal-nombre" class="block font-medium text-slate-700 mb-1">Nombre Completo</label><input type="text" id="swal-nombre" class="swal2-input w-full" value="${user.Nombre}"></div>
                        <div><label for="swal-rol" class="block font-medium text-slate-700 mb-1">Rol</label>
                            <select id="swal-rol" class="swal2-select w-full">
                                <option value="2" ${user.Rol == '2' ? 'selected' : ''}>Usuario Normal</option>
                                <option value="1" ${user.Rol == '1' ? 'selected' : ''}>Super Usuario</option>
                            </select>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Guardar Cambios',
                confirmButtonColor: '#ea580c',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    return {
                        userId: userId,
                        username: document.getElementById('swal-username').value,
                        nombre: document.getElementById('swal-nombre').value,
                        rol: document.getElementById('swal-rol').value
                    }
                }
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/update_user.php', {
                            method: 'POST', headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(result.value)
                        });
                        const res = await response.json();
                        if (res.success) {
                            Swal.fire('¡Actualizado!', res.message, 'success');
                            loadUsers();
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error de Conexión', 'No se pudieron guardar los cambios.', 'error');
                    }
                }
            });
        };

        userForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(userForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/add_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        title: '¡Éxito!', text: result.message, icon: 'success',
                        timer: 2000, showConfirmButton: false
                    });
                    userForm.reset();
                    loadUsers();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error de Conexión', 'No se pudo registrar el usuario.', 'error');
            }
        });

        const showError = (message) => {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center p-6 text-red-500">${message}</td></tr>`;
        };

        loadUsers();
    });
</script>
</body>
</html>

