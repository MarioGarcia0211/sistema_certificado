<?php
include "../conexion.php";
$rand = rand(1000, 9999);
if (!empty($_POST)) {
    $alert = "";

    $idCurso = $_POST['idCurso'];
    $nombreCurso = $_POST['nombreCurso'];
    $nombreProfesor = $_POST['nombreProfesor'];
    $descripcion = $_POST['descripcion'];
    $inicio = $_POST['inicio'];
    $fin = $_POST['final'];
    $precio = $_POST['precio'];


    $result = 0;


    $query = mysqli_query($conection, "SELECT * FROM cursos WHERE curso = '$nombreCurso' AND idCurso != '$idCurso'");

    $result = mysqli_fetch_array($query);


    if ($result > 0) {

        $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> El nombre del curso (' . $nombreCurso . ') curso ya existe.
          </div>';
    } else {

        $insert = mysqli_query($conection, "UPDATE cursos SET curso = '$nombreCurso', idUsuarioProfesor = '$nombreProfesor', descripcion = '$descripcion', horaInicio = '$inicio', horaFin = '$fin', precio = '$precio' WHERE idCurso = '$idCurso'");


        if ($insert) {

            $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Curso actualizado correctamente.
              </div>';
        } else {

            $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el curso.
              </div>';
        }
    }
}

//Mostrar datos del curso
if (empty($_GET['id'])) {
    header('Location: lista_cursos.php');
}

$idCurso = $_GET['id'];

$sql = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, cursos.descripcion, cursos.horaInicio, cursos.horaFin, cursos.precio, usuarios.nombre, usuarios.apellido FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso = $idCurso");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_usuario.php');
} else {

    $optionProfe = '';
    while ($data = mysqli_fetch_array($sql)) {

        $idCurso = $data['idCurso'];
        $nombreCurso = $data['curso'];
        $nombreProfesor = $data['nombre'];
        $apellidoProfesor = $data['apellido'];
        $idUsuarioProfesor = $data['idUsuarioProfesor'];
        $descripcion = $data['descripcion'];
        $horaInicio = $data["horaInicio"];
        $horaFinal = $data["horaFin"];
        $precio = $data['precio'];


        if ($idUsuarioProfesor) {
            $optionProfe = '<option value="' . $idUsuarioProfesor . '" selected>' . $nombreProfesor . " " . $apellidoProfesor . '</option>';
        }

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
                <a class="nav-link active">Editar curso</a>
            </li>
        </ul>
        <h1>Registrar curso</h1>

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
                    <input class="form-control" type="text" name="nombreCurso" id="nombreCurso" value="<?php echo $nombreCurso ?>">
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
                    <select class="form-select notItemOne" name="nombreProfesor" id="nombreProfesor">

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

                <!-- Descripcion -->
                <div class="form-group col-md-12">
                    <label class="form-label">Descripcion</label>
                    <textarea class="form-control" name="descripcion" id="descripcion"><?php echo $descripcion ?></textarea>
                </div>
                <!-- Final descripcion -->

                <!-- Inicio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora inicio</label>
                    <input type="time" class="form-control" name="inicio" id="inicio" value="<?php echo $horaInicio ?>">
                </div>
                <!-- Final inicio -->

                <!-- Hora final -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora final</label>
                    <input type="time" class="form-control" name="final" id="final" value="<?php echo $horaFinal ?>">
                </div>
                <!-- Final hora final -->

                <!-- Precio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Precio</label>
                    <input type="number" class="form-control" name="precio" id="precio" value="<?php echo $precio ?>">
                </div>
                <!-- Final precio -->

                <!-- Captcha -->
                <div class="form-group col-md-6">
                    <label class="form-label">Captcha</label>
                    <input type="text" class="form-control" name="captcha" id="captcha">
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Código del captcha</label>
                    <input type="text" class="form-control text-center" name="codigo" id="codigo" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); color:white;" value="<?php echo $rand; ?>" readonly>
                </div>
                <!-- Final captcha -->

                <!-- boton registar -->
                <div class="d-grid justify-content-md-center">
                    <button type="submit" class="btn btn-primary">Crear curso</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>