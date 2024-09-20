<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
?>

<style>
    .active {
        background: #f4f5f8;
        width: 100%;
        border-radius: 5px;
        padding-left: 10px;
    }
</style>

<nav class="navbar sticky-top navbar-expand-lg shadow" style="background-color: white;">
    <div class="container-fluid">
        <!-- Titulo del navbar -->
        <a class="navbar-brand mb-0 h1 titulo-navbar" href="index.php">Sistema</a>
        <!-- Final titulo del navbar -->

        <!-- Boton del menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Final boton del menu -->

        <!-- Menu offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">

            <!-- Encabezado del offcanvas -->
            <div class="offcanvas-header shadow">
                <!-- Titulo del menu -->
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <!-- Final titulo del menu -->

                <!-- Boton salir del menu -->
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                <!-- Final boton salir del menu -->
            </div>
            <!-- Final encabezado del offcanvas -->

            <!-- Cuerpo del offcanvas -->
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <!-- inicio -->

                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" aria-current="page" href="index.php"><i class="bi bi-house-fill"></i> Inicio</a>
                    </li>
                    <!-- Final inicio -->

                    <!-- Perfil -->
                    <li class="nav-item centrar">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'perfil.php' || basename($_SERVER['PHP_SELF']) == 'editar_datos.php' ? 'active' : ''; ?>" aria-current="page" href="perfil.php"><i class="bi bi-file-person"></i> Mi perfil</a>
                    </li>
                    <!-- Final perfil -->

                    <?php
                    if ($_SESSION['idRol'] == '1') {

                    ?>

                        <!-- Usuarios -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_usuarios.php' || basename($_SERVER['PHP_SELF']) == 'editar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'registrar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_usuario.php' || basename($_SERVER['PHP_SELF']) == 'buscar_usuario.php' ? 'active' : ''; ?>" aria-current="page" href="lista_usuarios.php"><i class="bi bi-people"></i> Usuarios</a>
                        </li>
                        <!-- Usuarios -->

                        <!-- Cursos -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_cursos.php' || basename($_SERVER['PHP_SELF']) == 'mostrar_curso.php' || basename($_SERVER['PHP_SELF']) == 'editar_curso.php' || basename($_SERVER['PHP_SELF']) == 'registrar_asistencia.php' || basename($_SERVER['PHP_SELF']) == 'registrar_curso.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_curso.php' || basename($_SERVER['PHP_SELF']) == 'buscar_curso.php' ? 'active' : ''; ?>" aria-current="page" href="lista_cursos.php"><i class="bi bi-journals"></i> Cursos</a>
                        </li>
                        <!-- Final Cursos -->

                        <!-- Matricula -->
                        <li class="nav-item centrar">
                            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lista_matricula.php' || basename($_SERVER['PHP_SELF']) == 'editar_matricula.php' ||  basename($_SERVER['PHP_SELF']) == 'registrar_matricula.php' || basename($_SERVER['PHP_SELF']) == 'eliminar_matricula.php' || basename($_SERVER['PHP_SELF']) == 'buscar_matricula.php' ? 'active' : ''; ?>" aria-current="page" href="lista_matricula.php"><i class="bi bi-stack"></i> Matricula</a>
                        </li>
                        <!-- Final matricula -->

                    <?php } ?>

                    <!-- Boton cerrar sesion -->
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="cerrar.php"><button class="btn btn-primary">Cerrar sesión</button></a>
                    </li>
                    <!-- Final boton cerrar sesion -->

                </ul>

            </div>
            <!-- Final cuerpo del offcanvas -->
        </div>
        <!-- Final menu offcanvas -->
    </div>
</nav>