<?php 
session_start();
include "../conexion.php";
include "../c2.php";

if ($_POST['action'] == 'buscarEstudiante') {

    //print_r($_POST);

    if (!empty($_POST['estudiante'])) {
        # code...
        $nit = $_POST['estudiante'];

        $query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, tipodocumento.tipoDocumento FROM usuarios INNER JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE usuarios.numeroDocumento LIKE '$nit' AND usuarios.estado = 1 AND idRol = 3");

        $result = mysqli_num_rows($query);

        $data = '';

        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            # code...
            $data = 0;
        }
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    exit;
}

if ($_POST['action'] == 'buscarCurso') {

    //print_r($_POST);

    if (!empty($_POST['curso'])) {
        # code...
        $idCurso = $_POST['curso'];
        $nitEstudiante = $_POST['estudiante'];

        $query = mysqli_query($conection, "SELECT cursos.idCurso, cursos.curso, cursos.idUsuarioProfesor, cursos.descripcion, cursos.horaInicio, cursos.horaFin, cursos.precio, usuarios.nombre, usuarios.apellido, usuarios.email FROM cursos INNER JOIN usuarios ON cursos.idUsuarioProfesor = usuarios.idUsuario WHERE idCurso LIKE '$idCurso'");

        $result = mysqli_num_rows($query);

        $query_descuento = mysqli_query($c2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE estado = 'No canjeado' AND numeroDocumento LIKE '$nitEstudiante'");

        $result_descuento = mysqli_num_rows($query_descuento);

        $data = '';
        $descuento = 0;

        if ($result > 0) {
            if ($result_descuento > 0) {
                $info_descuento = mysqli_fetch_assoc($query_descuento);
                $descuento = $info_descuento['descuento'];
            }

            $data = mysqli_fetch_assoc($query);

            if ($data !== 0) {
                $data['descuento'] = $descuento;
            }
        } else {
            # code...
            $data = 0;
        }
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    exit;
}


if($_POST['action'] == 'procesarMatricula'){
    if (empty($_POST['estudiante'])) {
        echo "error falta el estudiante";
    } else {
        $idEstudiante = $_POST['estudiante'];

        $idCurso = $_POST['curso'];

        $insert = mysqli_query($conection, "INSERT INTO matricula (idCursoM, idEstudianteM, estado) VALUES ('$idCurso', '$idEstudiante', '0')");

        

        if ($insert) {

            $ultimoIdInsertado = mysqli_insert_id($conection);

            $consultaSelect = "SELECT * FROM matricula WHERE idMatricula = $ultimoIdInsertado";
            $resultado = mysqli_query($conection, $consultaSelect);

            if ($resultado) {
                $datos = mysqli_fetch_assoc($resultado);
                echo json_encode($datos, JSON_UNESCAPED_UNICODE);
                $nota = mysqli_query($conection, "INSERT INTO notas (idEstudiante, idCurso, estado) VALUES ('$idEstudiante', '$idCurso', '0')");
            } else {
                echo "error al obtener detalles del estudiante";
            }
        } else {
            echo "error al insertar la matricula";
        }

        mysqli_close($conection);
        exit;
    }
}
?>