<?php include 'estaticos/check_session.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Grammer Quick Inventor</title>
    <?php include 'estaticos/stylesEstandar.php'; ?>
    <style>
        .nav-link.active { @apply bg-white/20 rounded-md; }
    </style>
</head>
<body class="bg-slate-100 font-sans flex flex-col min-h-screen">
<?php include 'estaticos/navegador.php'; ?>

<main class="flex-grow pt-24 pb-10 px-4 md:px-10">
    <!-- Banner Section -->
    <div class="relative h-64 md:h-80 bg-cover bg-center rounded-2xl shadow-lg" style="background-image: url('https://images.unsplash.com/photo-1579546929518-9e396f3cc809?q=80&w=2070&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-2xl">
            <div class="text-center text-white p-4">
                <h2 class="text-4xl md:text-6xl font-extrabold tracking-wider">
                    Mi Perfil
                </h2>
                <p class="mt-4 text-xl font-light">Hola, <span class="font-bold"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span></p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mt-10 max-w-lg mx-auto">
        <div class="bg-white p-8 rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-2xl font-bold text-slate-800 mb-6 text-center">Cambiar Contraseña</h3>
            <form id="update-password-form" class="space-y-6">
                <div>
                    <label for="new_password" class="block text-sm font-semibold text-slate-600 mb-2">Nueva Contraseña</label>
                    <input type="password" id="new_password" name="new_password" class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-semibold text-slate-600 mb-2">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full px-4 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>
                <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 px-6 rounded-lg hover:bg-slate-900 transition-transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-800">
                    Guardar Cambios
                </button>
            </form>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-slate-800 text-slate-300 p-6 mt-10">
    <div class="max-w-7xl mx-auto text-center text-sm">
        <p>&copy; <?php echo date('Y'); ?> Grammer S.A. de C.V. | Desarrollado por: Engadi, Fatima y Hadbet</p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const passwordForm = document.getElementById('update-password-form');

        passwordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                Swal.fire('Error', 'Las contraseñas no coinciden.', 'error');
                return;
            }
            if (newPassword.length < 6) {
                Swal.fire('Atención', 'La contraseña debe tener al menos 6 caracteres.', 'warning');
                return;
            }

            try {
                const response = await fetch('https://grammermx.com/Logistica/QuickInventories/dao/update_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ new_password: newPassword })
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
                    passwordForm.reset();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error de Conexión', 'No se pudo actualizar la contraseña.', 'error');
            }
        });
    });
</script>
</body>
</html>
