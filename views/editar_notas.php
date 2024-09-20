<?php
include "../conexion.php";
$idEstudiante = $_GET['idE'];
$idCurso = $_GET['idC'];
$nombreCurso = '';
$nombreProfesor = '';
$apellidoProfesor = '';
$emailProfesor = '';

$query = mysqli_query($conection, "SELECT cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $idCurso");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $emailProfesor = $data['email'];
    }
}

//Editar notas

if (!empty($_POST)) {
    $notaUno = $_POST['notaUno'];
    $notaDos = $_POST['notaDos'];
    $notaTres = $_POST['notaTres'];
    $totalAsis = $_POST['asistencia'];
    $definitiva = ($notaUno * 0.30) + ($notaDos * 0.30) + ($notaTres * 0.30) + ($totalAsis * 0.10);


    $query = mysqli_query($conection, "UPDATE notas SET notaUno = '$notaUno', notaDos = '$notaDos', notaTres = '$notaTres', notaDefinitiva = '$definitiva' WHERE idCurso = '$idCurso' AND idEstudiante = '$idEstudiante'");

    if ($query) {
        $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Notas actualizada correctamente.
              </div>';
    } else {

        $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar la nota.
          </div>';
    }
}


//Mostar datos de las notas del estudiante
if (empty($_GET['idE']) || empty($_GET['idC'])) {
    header('Location: lista_cursos.php');
}

$nombreEstudiante = '';
$apellidoEstudiante = '';
$nota1 = '';
$nota2 = '';
$nota3 = '';
$asistencia = '';
$definitiva = '';

$sql = mysqli_query($conection, "SELECT notas.idNota, notas.idEstudiante, notas.idCurso, notas.notaUno, notas.notaDos, notas.notaTres, notas.notaDefinitiva, notas.estado, usuarios.nombre, usuarios.apellido, COUNT(CASE WHEN asistencias.estado = 1 THEN 1 END) AS totalAsistencias FROM notas INNER JOIN usuarios ON notas.idEstudiante = usuarios.idUsuario LEFT JOIN asistencias ON notas.idEstudiante = asistencias.idEstudianteA WHERE idCurso = '$idCurso' AND idEstudiante = '$idEstudiante' AND notas.estado = 1;");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_cursos.php');
} else {

    while ($data = mysqli_fetch_array($sql)) {
        $nombreEstudiante = $data['nombre'];
        $apellidoEstudiante = $data['apellido'];
        $nota1 = $data['notaUno'];
        $nota2 = $data['notaDos'];
        $nota3 = $data['notaTres'];
        $asistencia = $data['totalAsistencias'];
        $definitiva = $data['notaDefinitiva'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";

    ?>

    <div class="contenedor">

        <ul class="nav nav-tabs">

            <?php
            if ($_SESSION['idRol'] == '1') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="lista_cursos.php">Lista de cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $idCurso ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="lista_notas.php?id=<?php echo $idCurso ?>">Notas: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Editar nota: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            } elseif ($_SESSION['idRol'] == '2') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mostrar_curso.php?id=<?php echo $idCurso ?>">Curso: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="lista_notas.php?id=<?php echo $idCurso ?>">Notas: <?php echo $nombreCurso ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="">Editar nota: <?php echo $nombreCurso ?></a>
                </li>

            <?php
            }
            ?>

        </ul>

        <h1>Editar notas</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Nombre -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $nombreEstudiante ?>" disabled>
                </div>
                <!-- Final nombre -->

                <!-- Apellido -->
                <div class="form-group col-md-6">
                    <label class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $apellidoEstudiante ?>" disabled>
                </div>
                <!-- Final apellido -->

                <!-- Email -->
                <div class="form-group col-md-4">
                    <label class="form-label">Nota 1</label>
                    <input class="form-control" type="number" name="notaUno" id="notaUno" step="0.01" value="<?php echo $nota1 ?>">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group col-md-4">
                    <label class="form-label">Nota 2</label>
                    <input class="form-control" type="number" name="notaDos" id="notaDos" step="0.01" value="<?php echo $nota2 ?>">
                </div>
                <!-- Final contraseña -->

                <!-- numero -->
                <div class="form-group col-md-4">
                    <label class="form-label">Nota 3</label>
                    <input type="number" class="form-control" name="notaTres" id="notaTres" step="0.01" value="<?php echo $nota3 ?>">
                </div>
                <!-- Final numero -->

                <input type="hidden" class="form-control" name="asistencia" id="asistencia" value="<?php echo $asistencia ?>">

                <!-- boton registar -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="lista_notas.php?id=<?php echo $idCurso ?>" class="btn btn-danger">Volver</a>
                    <button type="submit" class="btn btn-success">Aceptar cambios</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>