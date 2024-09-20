<?php
include "../conexion.php";
$rand = rand(1000, 9999);
if (!empty($_POST)) {
    $idCurso = $_POST['idCurso'];
    $query_delete = mysqli_query($conection, "UPDATE cursos SET estado = 0 WHERE idCurso = $idCurso");

    if ($query_delete) {

        header("location: lista_cursos.php");
    }
}

//Mostrar datos del curso
if (empty($_GET['id'])) {
    header('Location: lista_cursos.php');
}

$idCurso = $_GET['id'];

$sql = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, usuarios.nombre, usuarios.apellido FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $idCurso");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_cursos.php');
} else {

    $optionProfe = '';
    while ($data = mysqli_fetch_array($sql)) {

        $idCurso = $data['idCurso'];
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $idUsuarioProfesor = $data['idUsuarioProfesor'];
        // $email = $data['email'];
        // $idTipoDocumento = $data['idTipoDocumento'];
        // $tipoDocumento = $data['tipoDocumento'];
        // $numero = $data['numeroDocumento'];
        // $idRol = $data['idRol'];
        // $rol = $data['rol'];


        if ($idUsuarioProfesor) {
            $optionProfe = '<option value="' . $idUsuarioProfesor . '" selected>' . $nombreProfesor . " " . $apellidoProfesor . '</option>';
        }

        // if ($idTipoDocumento) {
        //     $optionDoc = '<option value="' . $idTipoDocumento . '" selected>' . $tipoDocumento . '</option>';
        // }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar curso</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_cursos.php">Lista de cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_curso.php">Registrar curso</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active">Eliminar usuario</a>
            </li>
        </ul>
        <h1>Registrar curso</h1>

        <div>
            <p>¿Estas seguro que quieres eliminar este curso?</p>
        </div>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id del curso -->

                <input class="form-control" type="hidden" name="idCurso" id="idCurso" value="<?php echo $idCurso ?>">
                <!-- Final id del curso -->
                <!-- Nombre del curso -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del Curso</label>
                    <input class="form-control" type="text" name="nombreCurso" id="nombreCurso" value="<?php echo $nombreCurso ?>" disabled>
                </div>
                <!-- Final nombre del curso -->

                <!-- Nombre del profesor -->
                <?php
                include "../conexion.php";
                $query_tipo = mysqli_query($conection, "SELECT * FROM usuarios WHERE idRol = '2'");
                $result_tipo = mysqli_num_rows($query_tipo);
                ?>

                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del profesor</label>
                    <select class="form-select notItemOne" name="nombreProfesor" id="nombreProfesor" disabled>

                        <?php
                        echo $optionProfe;
                        if ($result_tipo > 0) {
                            while ($profe = mysqli_fetch_array($query_tipo)) {

                        ?>
                                <option value="<?php echo $profe["idUsuario"]; ?>"><?php echo $profe["nombre"] . ' ' . $profe["apellido"] ?></option>

                        <?php
                            }
                        }
                        ?>


                    </select>
                </div>
                <!-- Final Nombre del profesor -->

                <!-- botones -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="lista_cursos.php" class="btn btn-primary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </div>
                <!-- Final botones -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>