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
    $busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
        //header('location: lista_usuarios.php');

        echo '<script>window.location.href = "lista_cursos.php";</script>';
    }


    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_cursos.php">Lista de cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_cursos.php">Registrar curso</a>
            </li>
        </ul>

        <nav class="navbar">
            <h1>Lista de cursos</h1>

            <form class="d-flex" role="search" action="buscar_curso.php" method="get">
                <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo $busqueda; ?>">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </nav>

        <div class="card border">
            <div class="card-body">
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>
                                <th scope="col" data-toggle="tooltip" title="ID">ID</th>
                                    <th scope="col" data-toggle="tooltip" title="Nombre">Nombre del curso</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Nombre del profesor</th>
                                    <th scope="col" data-toggle="tooltip" title="Email">Apellido del profesor</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion

                                $query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido  FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE (cursos.curso LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%') AND
                                cursos.estado = 1");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                        <td class="align-middle"><?php echo $data["idCurso"] ?></td>
                                            <td class="align-middle"><?php echo $data["curso"] ?></td>
                                            <td class="align-middle"><?php echo $data["nombre"] ?></td>
                                            <td class="align-middle"><?php echo $data["apellido"] ?></td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-block">
                                                    <?php if ($_SESSION['idRol'] == 1) { ?>
                                                        <a href="editar_curso.php?id=<?php echo $data["idCurso"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>


                                                        <a href="eliminar_curso.php?id=<?php echo $data["idCurso"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">No hay datos con la palabra buscada: "<?php echo $busqueda ?>"</td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>