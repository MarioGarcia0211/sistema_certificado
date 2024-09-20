<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de matricula</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_matricula.php">Lista de matricula</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="matricula.php">Registrar matricula</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Lista de matricula</h1>
                <form class="d-flex" role="search" action="buscar_matricula.php" method="get">
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
                                    <th scope="col" data-toggle="tooltip" title="ID de la matricula">ID de la matricula</th>
                                    <th scope="col" data-toggle="tooltip" title="Nombre del estudiante">Nombre del estudiante</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido del estudiante">Apellido del estudiante</th>
                                    <th scope="col" data-toggle="tooltip" title="Curso">Curso</th>
                                    <th scope="col" data-toggle="tooltip" title="Estado">Estado</th>
                                    <th scope="col" data-toggle="tooltip" title="Estado">Nota</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                if ($_SESSION['idRol'] == '1') {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalMatricula FROM matricula WHERE matricula.estado = 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalMatricula'];
                                } else {
                                    $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalMatricula FROM matricula WHERE matricula.estado = 1");
                                    $result_register = mysqli_fetch_array($sql_registe);
                                    $total_registro = $result_register['totalMatricula'];
                                }


                                $por_pagina = 7;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_por_paginas = ceil($total_registro / $por_pagina) + 2;


                                $query = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, matricula.estado, usuarios.nombre, usuarios.apellido, cursos.curso, notas.notaDefinitiva FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN cursos ON matricula.idCursoM = cursos.idCurso JOIN notas ON matricula.idCursoM = notas.idCurso AND matricula.idEstudianteM = notas.idEstudiante ORDER BY `matricula`.`idMatricula` ASC LIMIT $desde,$por_pagina");

                                $result = mysqli_num_rows($query);
                                $estado = '';
                                $clase = '';

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                            <td class="align-middle"><?php echo $data["idMatricula"] ?></td>
                                            <td class="align-middle"><?php echo $data["nombre"] ?></td>
                                            <td class="align-middle"><?php echo $data["apellido"] ?></td>
                                            <td class="align-middle"><?php echo $data["curso"] ?></td>
                                            <?php if ($data['estado'] == 1) {
                                                $estado = 'Pagado';
                                                $clase = 'text-bg-success';
                                            } else {
                                                $estado = 'No pagado';
                                                $clase = 'text-bg-danger';
                                            }
                                            
                                            if($data["notaDefinitiva"] >= 3){
                                                $estadoC = 'text-bg-success';
                                                $calificacion = 'Aprobado';
                                            } else if($data["notaDefinitiva"] < 3) {
                                                $estadoC = 'text-bg-danger';
                                                $calificacion = 'No aprobado';
                                            }

                                            ?>
                                            <td class="align-middle <?php echo $clase ?>"><?php echo $estado ?></td>
                                            <td class="align-middle <?php echo $estadoC ?>"><?php echo $calificacion ?></td>
                                            <td class="align-middle">
                                                <div class="d-grid gap-2 d-md-block">
                                                    <?php if ($_SESSION['idRol'] == 1) { ?>

                                                        <!-- Mostrar matricula -->
                                                        <a target="_blank" href="mostrar_matricula.php?id=<?php echo $data["idMatricula"] ?>" class="btn btn-danger btn-sm" type="button" title="Mostrar" name="busqueda" id="busqueda"><i class="bi bi-filetype-pdf"></i></a>

                                                        <!-- Editar Matricula -->
                                                        <a href="editar_matricula.php?id=<?php echo $data["idMatricula"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>


                                                        <?php if ($data['notaDefinitiva'] >= 3) { ?>
                                                            <a target="_blank" href="mostrar_certificado.php?id=<?php echo $data["idMatricula"] ?>" class="btn btn-secondary btn-sm" type="button" title="Certificado"><i class="bi bi-receipt"></i></a>
                                                        <?php } ?>

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