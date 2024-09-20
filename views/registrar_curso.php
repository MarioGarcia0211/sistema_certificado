<?php
include "../conexion.php";
$rand = rand(1000, 9999);
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombreCurso']) || empty($_POST['nombreProfesor']) || empty($_POST['captcha']) ||  empty($_POST['inicio']) || empty($_POST['final']) || empty($_POST['precio'])) {

        $alert = '<div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
      </div>';
    } else {
        if ($_POST['captcha'] != $_POST['codigo']) {
            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
          </div>';
        } else {


            $nombreCurso = $_POST['nombreCurso'];
            $nombreProfesor = $_POST['nombreProfesor'];
            $descripcion = $_POST['descripcion'];
            $inicio = $_POST['inicio'];
            $fin = $_POST['final'];
            $precio = $_POST['precio'];

            $result = 0;


            $query = mysqli_query($conection, "SELECT * FROM cursos WHERE curso = '$nombreCurso'");

            $result = mysqli_fetch_array($query);


            if ($result > 0) {

                $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> El curso ya existe.
          </div>';
            } else {

                $insert = mysqli_query($conection, "INSERT INTO cursos (curso, idUsuarioProfesor, descripcion, horaInicio, horaFin, precio) VALUES ('$nombreCurso', '$nombreProfesor', '$descripcion', '$inicio', '$fin', '$precio')");

                

                if ($insert) {

                    $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Curso registrado correctamente.
              </div>';
                } else {

                    $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Error al registrar el curso.
              </div>';
                }
            }
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
                <a class="nav-link active" href="registrar_curso.php">Registrar curso</a>
            </li>
        </ul>
        <h1>Registrar curso</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">
                <!-- Nombre del curso -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del Curso</label>
                    <input class="form-control" type="text" name="nombreCurso" id="nombreCurso">
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
                    <select class="form-select" name="nombreProfesor" id="nombreProfesor">
                        <option selected disabled>Elige al profesor</option>
                        <?php
                        if ($result_tipo > 0) {
                            while ($profe = mysqli_fetch_array($query_tipo)) {
                                
                        ?>
                                <option value="<?php echo $profe["idUsuario"]; ?>"><?php echo $profe["nombre"].' '. $profe["apellido"]?></option>

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
                    <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
                </div>
                <!-- Final descripcion -->

                <!-- Inicio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora inicio</label>
                    <input type="time" class="form-control" name="inicio" id="inicio">
                </div>
                <!-- Final inicio -->

                <!-- Hora final -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora Final</label>
                    <input type="time" class="form-control" name="final" id="final">
                </div>
                <!-- Final hora final -->

                <!-- Precio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Precio</label>
                    <input type="number" class="form-control" name="precio" id="precio">
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