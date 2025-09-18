<?php
// Obtiene el nombre del archivo de la página actual (ej. "inicio.php")
$currentPage = basename($_SERVER['PHP_SELF']);

// Si la sesión no está iniciada, la iniciamos para poder leer el rol.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Determinamos el rol del usuario. Si no está definido, asumimos un rol sin permisos (e.g., 0).
$userRol = isset($_SESSION['rol']) ? $_SESSION['rol'] : 0;
?>
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
                <?php if ($userRol == 1) : // Menú para Super Usuario ?>
                    <a href="inicio.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'inicio.php') ? 'active' : ''; ?>"><span>Inicio</span></a>
                    <a href="carga.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'carga.php') ? 'active' : ''; ?>"><span>Carga</span></a>
                <?php endif; ?>

                <?php if ($userRol == 1 || $userRol == 2) : // Menú para ambos roles ?>
                    <a href="produccion.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'produccion.php') ? 'active' : ''; ?>"><span>Producción</span></a>
                    <a href="almacen.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'almacen.php') ? 'active' : ''; ?>"><span>Almacén</span></a>
                <?php endif; ?>

                <?php if ($userRol == 1) : // Menú solo para Super Usuario ?>
                    <a href="usuarios.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'usuarios.php') ? 'active' : ''; ?>"><span>Usuarios</span></a>
                <?php endif; ?>

                <a href="perfil.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md <?php echo ($currentPage == 'perfil.php') ? 'active' : ''; ?>"><span>Perfil</span></a>
                <a href="logout.php" class="nav-link flex items-center space-x-2 px-3 py-2 text-sm font-medium text-white hover:bg-white/20 rounded-md"><span>Salir</span></a>

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
            <?php if ($userRol == 1) : ?>
                <a href="inicio.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'inicio.php') ? 'active' : ''; ?>">Inicio</a>
                <a href="carga.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'carga.php') ? 'active' : ''; ?>">Carga</a>
            <?php endif; ?>

            <?php if ($userRol == 1 || $userRol == 2) : ?>
                <a href="produccion.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'produccion.php') ? 'active' : ''; ?>">Producción</a>
                <a href="almacen.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'almacen.php') ? 'active' : ''; ?>">Almacén</a>
            <?php endif; ?>

            <?php if ($userRol == 1) : ?>
                <a href="usuarios.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'usuarios.php') ? 'active' : ''; ?>">Usuarios</a>
            <?php endif; ?>

            <a href="perfil.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md <?php echo ($currentPage == 'perfil.php') ? 'active' : ''; ?>">Perfil</a>
            <a href="logout.php" class="block nav-link px-3 py-2 text-base font-medium text-white rounded-md">Salir</a>
        </div>
    </div>
</nav>

