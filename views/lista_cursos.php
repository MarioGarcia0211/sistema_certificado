<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de cursos</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_cursos.php">Lista de cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_curso.php">Registrar curso</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Lista de cursos</h1>
                <form class="d-flex" role="search" action="buscar_curso.php" method="get">
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
                                <th scope="col" data-toggle="tooltip" title="ID">Codigo del curso</th>
                                    <th scope="col" data-toggle="tooltip" title="Curso">Nombre del curso</th>
                                    <th scope="col" data-toggle="tooltip" title="Nombre del profesor">Nombre del profesor</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido del profesor">Apellido del profesor</th>
                                    <th scope="col" data-toggle="tooltip" title="Hora de inicio">Hora de inicio</th>
                                    <th scope="col" data-toggle="tooltip" title="Hora final">Hora final</th>
                                    <th scope="col" data-toggle="tooltip" title="Precio">Precio</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                if ($_SESSION['idRol'] == '1') {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalCursos FROM cursos WHERE cursos.estado = 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalCursos'];
                                } else {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalCursos FROM cursos WHERE cursos.estado = 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalCursos'];
                                }


                                $por_pagina = 5;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;

                                $query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, cursos.horaInicio, cursos.horaFin, cursos.precio, usuarios.nombre, usuarios.apellido  FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE cursos.estado = 1 ORDER BY `cursos`.`idCurso` ASC LIMIT $desde,$por_pagina");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                        $idCurso = $data['idCurso'];
                                        $nombreCurso = $data['curso'];
                                        $nombreProfesor = $data["nombre"];
                                        $apellidoProfesor = $data["apellido"];
                                        $inicio = date("g:i A", strtotime($data["horaInicio"]));
                                        $final = date("g:i A", strtotime($data["horaFin"]));
                                        $precio = number_format($data['precio'], 2)
                                ?>

                                        <tr>
                                        <td class="align-middle"><?php echo $idCurso?></td>
                                            <td class="align-middle"><?php echo $nombreCurso ?></td>
                                            <td class="align-middle"><?php echo $nombreProfesor ?></td>
                                            <td class="align-middle"><?php echo $apellidoProfesor ?></td>
                                            <td class="align-middle"><?php echo $inicio ?></td>
                                            <td class="align-middle"><?php echo $final ?></td>
                                            <td class="align-middle">$<?php echo $precio ?></td>
                                            <td class="align-middle">
                                                <div class="d-grid gap-2 d-md-block">
                                                    <?php if ($_SESSION['idRol'] == 1) { ?>

                                                        <a href="mostrar_curso.php?id=<?php echo $data["idCurso"] ?>" class="btn btn-warning btn-sm" type="button" title="Mostrar" name="busqueda" id="busqueda"><i class="bi bi-box-arrow-in-up-right"></i></a>

                                                        <a href="editar_curso.php?id=<?php echo $data["idCurso"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>


                                                        <a href="eliminar_curso.php?id=<?php echo $data["idCurso"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
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