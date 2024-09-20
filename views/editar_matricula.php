<?php
include "../conexion.php";
include "../c2.php";


$alert = '';
//-----------------------Editar-------------------------------------
if (!empty($_POST)) {
    $idMatricula = $_GET['id'];
    $estado = $_POST['estadoMatricula'];
    $idE = $_POST['idE'];
    $idC = $_POST['idC'];
    $numDoc = $_POST['numDoc'];
    $query = mysqli_query($conection, "UPDATE matricula SET estado = '$estado' WHERE idMatricula = '$idMatricula'");


    if ($query) {
        $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Matricula actualizada correctamente.
              </div>';
              if ($estado == 1) {
                $update = mysqli_query($conection, "UPDATE notas SET estado = 1 WHERE idCurso = '$idC' AND idEstudiante = '$idE'");
                
                $canjear = mysqli_query($c2, "UPDATE descuentos SET estado = 'Canjeado' WHERE numeroDocumento = '$numDoc'");

            } elseif ($estado == 0) {
                $update = mysqli_query($conection, "UPDATE notas SET estado = 0 WHERE idCurso = '$idC' AND idEstudiante = '$idE'");
            }
    } else {

        $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar la matricula.
          </div>';
    }
}




//-------------------------Mostrar datos------------------------------
if (empty($_GET['id'])) {
    header('Location: lista_cursos.php');
}

$idMatricula = $_GET['id'];
$idCursoM = '';
$idEstudianteM = '';
$nombreEstudiante = '';
$apellidoEstudiante = '';
$documento = '';
$numeroDocumento = '';
$email = '';
$curso = '';
$estado = '';
$precio = '';
$horaInicio = '';
$horaFinal = '';
$descuento = 0;
$total = 0;

$sql = mysqli_query($conection, "SELECT matricula.idMatricula, matricula.idCursoM, matricula.idEstudianteM, matricula.estado, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento, cursos.curso, cursos.horaInicio, cursos.horaFin, cursos.precio FROM matricula INNER JOIN usuarios ON matricula.idEstudianteM = usuarios.idUsuario JOIN cursos ON matricula.idCursoM = cursos.idCurso JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idMatricula = $idMatricula");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_usuario.php');
} else {

    $optionEstado = '';
    while ($data = mysqli_fetch_array($sql)) {
        $nombreEstudiante = $data['nombre'];
        $apellidoEstudiante = $data['apellido'];
        $idCursoM = $data['idCursoM'];
        $idEstudianteM = $data['idEstudianteM'];
        $email = $data['email'];
        $documento = $data['tipoDocumento'];
        $numeroDocumento = $data['numeroDocumento'];
        $curso = $data['curso'];
        $estado = $data['estado'];
        $precio = $data['precio'];
        $horaInicio = $data['horaInicio'];
        $horaFinal = $data['horaFin'];

        if ($estado == 0) {
            $optionEstado = '<option value="' . $estado . '" selected>' . "No pagado" . '</option>';
        } else {
            $optionEstado = '<option value="' . $estado . '" selected>' . "Pagado" . '</option>';
        }
    }
    $query_descuento = mysqli_query($c2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE estado = 'No canjeado' AND numeroDocumento LIKE '$numeroDocumento'");
	$result_descuento = mysqli_num_rows($query_descuento);
    if ($result_descuento > 0) {
        $info_descuento = mysqli_fetch_assoc($query_descuento);
        $numero_descuento = $info_descuento['descuento'];

        
    } else {
        $numero_descuento = 0;
    }

    $descuento = $precio * ($numero_descuento / 100);
    $total = $precio - $descuento;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar matricula</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_matricula.php">Lista de matricula</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active">Editar matricula</a>
            </li>
        </ul>
        <h1>Editar matricula</h1>

        <form action="" name="" id="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <div class="row align-items-center">

                <!-- Nombre -->
                <div class="form-group col-md-4">
                    <label class="form-label">Nombre del estudiante</label>
                    <input class="form-control" type="text" disabled name="nombre" id="nombre" value="<?php echo $nombreEstudiante ?>">
                </div>
                <!-- Final nombre -->

                <!-- Nombre -->
                <div class="form-group col-md-4">
                    <label class="form-label">Apellido del estudiante</label>
                    <input class="form-control" type="text" disabled name="apellido" id="apellido" value="<?php echo $apellidoEstudiante ?>">
                </div>
                <!-- Final nombre -->

                <!-- Email -->
                <div class="form-group col-md-4">
                    <label class="form-label">Correo electronico</label>
                    <input class="form-control" type="text" disabled name="email" id="email" value="<?php echo $email ?>">
                </div>
                <!-- Final email -->

                <!-- Tipo documento -->
                <div class="form-group col-md-4">
                    <label class="form-label">Tipo documento</label>
                    <input class="form-control" type="text" disabled name="tipoDocumento" id="tipoDocumento" value="<?php echo $documento ?>">
                </div>
                <!-- Final Tipo documento -->

                <!-- Numero documento -->
                <div class="form-group col-md-4">
                    <label class="form-label">Número del documento</label>
                    <input class="form-control" type="number" name="numeroDocumento" id="numeroDocumento" disabled value="<?php echo $numeroDocumento ?>">
                </div>
                <!-- Final numero documento -->

                <input type="hidden" name="idE" value="<?php echo $idEstudianteM; ?>">
                <input type="hidden" name="idC" value="<?php echo $idCursoM; ?>">
                <input type="hidden" name="numDoc" value="<?php echo $numeroDocumento ?>">


                <!-- Estado de la matricula -->
                <div class="form-group col-md-4">
                    <label class="form-label">Estado de la matricula</label>
                    <select class="form-select notItemOne" name="estadoMatricula" id="estadoMatricula">
                        <?php echo $optionEstado ?>
                        <option value="0">No pagado</option>
                        <option value="1">Pagado</option>
                    </select>
                </div>
                <!-- Final estado de la matricula -->

                <!-- Curso -->
                <div class="form-group col-md-4">
                    <label class="form-label">Nombre del Curso</label>
                    <input class="form-control" type="text" name="nombreCurso" id="nombreCurso" disabled value="<?php echo $curso ?>">
                </div>
                <!-- Final curso -->

                <!-- Inicio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora inicio</label>
                    <input type="time" class="form-control" name="inicio" id="inicio" value="<?php echo $horaInicio ?>" disabled>
                </div>
                <!-- Final inicio -->

                <!-- Hora final -->
                <div class="form-group col-md-4">
                    <label class="form-label">Hora final</label>
                    <input type="time" class="form-control" name="final" id="final" value="<?php echo $horaFinal ?>" disabled>
                </div>
                <!-- Final hora final -->

                <!-- Precio -->
                <div class="form-group col-md-4">
                    <label class="form-label">Precio</label>
                    <input type="text" class="form-control" name="precio" id="precio" value="<?php echo  number_format($precio, 2); ?>" disabled>
                </div>
                <!-- Final precio -->

                 <!-- Descuento -->
                <div class="form-group col-md-4">
                    <label class="form-label">Descuento</label>
                    <input class="form-control" type="text" disabled name="descuento" id="descuento" value="<?php echo $numero_descuento .'%'; ?>">
                </div>
                <!-- Fin descuento -->

                <!-- Total -->
                <div class="form-group col-md-4">
                    <label class="form-label">Total</label>
                    <input class="form-control" type="text" disabled name="total" id="total" value="<?php echo  number_format($total, 2) ?>">
                </div>
                <!-- Fin total -->

                <!-- Botones -->
                <div class="form-group col-12 d-flex">

                    <div class="d-grid gap-2 d-md-block mx-auto">

                        <button class="btn btn-primary " type="submit" title="">Editar</button>

                    </div>
                </div>
            </div>
        </form>

    </div>
    <?php include "includes/footer.php"; ?>
</body>

</html>