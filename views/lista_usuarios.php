<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_usuarios.php">Lista de usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_usuario.php">Registrar usuario</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Lista de usuarios</h1>
                <form class="d-flex" role="search" action="buscar_usuario.php" method="get">
                    <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </nav>

        <div class="card border">
            <div class="card-body">
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>
                                <th scope="col" data-toggle="tooltip" title="ID">ID</th>
                                    <th scope="col" data-toggle="tooltip" title="Nombre">Nombre</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Apellido</th>
                                    <th scope="col" data-toggle="tooltip" title="Email">Email</th>
                                    <th scope="col" data-toggle="tooltip" title="Rol">Rol</th>
                                    <th scope="col" data-toggle="tooltip" title="Rol">Documento</th>
                                    <th scope="col" data-toggle="tooltip" title="Rol">N° de documento</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                if ($_SESSION['idRol'] == '1') {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM usuarios WHERE usuarios.estado = 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalUsuarios'];
                                } else {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM usuarios WHERE usuarios.estado = 1 AND usuarios.idRol != 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalUsuarios'];
                                }


                                $por_pagina = 5;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;

                                if ($_SESSION['idRol'] == '1') {
                                    $query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, usuarios.idRol, roles.rol, tipodocumento.tipoDocumento FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol INNER JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE usuarios.estado = 1 ORDER BY `usuarios`.`idUsuario` ASC LIMIT $desde,$por_pagina");
                                } else {
                                    $query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, usuarios.idRol, roles.rol, tipodocumento.tipoDocumento FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol INNER JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE usuarios.estado = 1 AND usuarios.idRol != 1 ORDER BY `usuarios`.`idUsuario` ASC LIMIT $desde,$por_pagina");
                                }
                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                        <td class="align-middle"><?php echo $data["idUsuario"] ?></td>
                                            <td class="align-middle"><?php echo $data["nombre"] ?></td>
                                            <td class="align-middle"><?php echo $data["apellido"] ?></td>
                                            <td class="align-middle"><?php echo $data["email"] ?></td>
                                            <td class="align-middle"><?php echo $data["rol"] ?></td>
                                            <td class="align-middle"><?php echo $data["tipoDocumento"] ?></td>
                                            <td class="align-middle"><?php echo $data["numeroDocumento"] ?></td>
                                            <td class="align-middle">
                                                <div class="d-grid gap-2 d-md-block">
                                                    <?php if ($data["idRol"] != 1) { ?>
                                                        <a href="editar_usuario.php?id=<?php echo $data["idUsuario"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>


                                                        <a href="eliminar_usuario.php?id=<?php echo $data["idUsuario"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">

                            <?php
                            if ($pagina != 1) {


                            ?>

                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                                </li>
                            <?php
                            }

                            if ($pagina != $total_por_paginas - 1) {

                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
                                </li>

                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                    <ul class="pagination justify-content-end">

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>