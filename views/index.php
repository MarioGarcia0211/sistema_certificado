<?php
include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <?php include "includes/scripts.php"; ?>
    <style>
        .card {
            height: 100%;
        }
    </style>
</head>

<body>
    <?php include "includes/navbar.php";
    $idUsuario = $_SESSION['idUsuario'];
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Nueva York

    $fechaHoraActual = date("Y-m-d H:i:s");
    //echo "La fecha y hora actual en Colombia es: $fechaHoraActual";
    ?>

    <div class="contenedor">
        <h1>Bienvenido <?php echo $nombre . ' ' . $apellido ?></h1>

        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">

            <?php
            $por_pagina = 12;

            if (empty($_GET['pagina'])) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }



            if ($_SESSION['idRol'] == '1') {
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalCursos FROM cursos WHERE cursos.estado = 1 ");
                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['totalCursos'];

                $desde = ($pagina - 1) * $por_pagina;
                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;

                $query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido  FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE cursos.estado = 1 ORDER BY `cursos`.`curso` ASC LIMIT $desde,$por_pagina");
            } else if ($_SESSION['idRol'] == '2') {
                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalCursos FROM cursos WHERE cursos.estado = 1 AND cursos.idUsuarioProfesor = '$idUsuario'");
                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['totalCursos'];

                $desde = ($pagina - 1) * $por_pagina;
                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;

                $query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido  FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE cursos.estado = 1 AND cursos.idUsuarioProfesor = '$idUsuario' ORDER BY `cursos`.`curso` ASC LIMIT $desde,$por_pagina");
            } elseif ($_SESSION['idRol'] == '3') {
                $query = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, matricula.estado, matricula.fecha, usuarios.nombre, usuarios.apellido, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento, cursos.idCurso, cursos.curso, cursos.precio FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN cursos ON matricula.idCursoM = cursos.idCurso JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idEstudianteM = '$idUsuario' AND matricula.estado = 1");
            }


            $result = mysqli_num_rows($query);

            if ($result > 0) {
                while ($data = mysqli_fetch_array($query)) {
            ?>


                    <div class="col">
                        <div class="card text-center">
                            <img src="./image/shapes.svg" class="card-img-top" alt="">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $data['curso'] ?></h3>
                            </div>
                            <div class="card-body">
                                <a class="btn btn-primary" href="mostrar_curso.php?id=<?php echo $data['idCurso'] ?>">Entrar</a>
                            </div>

                        </div>
                    </div>

            <?php
                }
            }
            ?>
        </div>
    </div>



    <?php include "includes/footer.php"; ?>
</body>

</html>