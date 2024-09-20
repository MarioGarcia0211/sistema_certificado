<?php
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email'])) {

        $alert = '<div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
                    </div>';
    } else {

        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $clave = md5($_POST['clave']);
        $tipo = $_POST['tipo'];
        $numero = $_POST['numero'];

        $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE (email = '$email' AND idUsuario != '$idUsuario')");

        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> El email ya existe.
              </div>';
        } else {

            if (empty($_POST['clave'])) {

                $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', idTipoDocumento ='$tipo', numeroDocumento = '$numero' WHERE idUsuario = '$idUsuario'");
            } else {
                $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', clave = '$clave', idTipoDocumento ='$tipo', numeroDocumento = '$numero' WHERE idUsuario = '$idUsuario'");
            }


            if ($sql_update) {
                $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Usuario actualizado correctamente.
                  </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el usuario.
                  </div>';
            }
        }
    }
}



//Mostrar datos del usuario

if (empty($_GET['id'])) {
    header('Location: lista_usuario.php');
}

$iduser = $_GET['id'];

$query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idTipoDocumento, usuarios.numeroDocumento, usuarios.idRol, roles.rol, tipodocumento.idTipoDocumento, tipodocumento.tipoDocumento FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol INNER JOIN tipodocumento ON usuarios.idTipoDocumento = tipodocumento.idTipoDocumento WHERE idUsuario = $iduser");

$result_sql = mysqli_num_rows($query);

if ($result_sql == 0) {
    header('Location: lista_usuario.php');
} else {

    $optionDoc = '';
    while ($data = mysqli_fetch_array($query)) {

        $iduser = $data['idUsuario'];
        $name = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $rol = $data['rol'];
        $idTipoDocumento = $data['idTipoDocumento'];
        $tipoDocumento = $data['tipoDocumento'];
        $numero = $data['numeroDocumento'];
        

        if ($idTipoDocumento) {
            $optionDoc = '<option value="' . $idTipoDocumento . '" selected>' . $tipoDocumento . '</option>';
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
    <title>Editar</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";

    ?>

    <div class="contenedor">

        <h1>Editar mis datos</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $iduser; ?>">
                <!-- final id -->

                <!-- Nombre -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $name; ?>">
                </div>
                <!-- Final nombre -->

                <!-- Apellido -->
                <div class="form-group col-md-6">
                    <label class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $apellido; ?>">
                </div>
                <!-- Final apellido -->

                <!-- Email -->
                <div class="form-group col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="clave" value="">
                </div>
                <!-- Final contraseña -->

                <!-- Tipo documento -->

                <?php

                include "../conexion.php";
                $query_tipo = mysqli_query($conection, "SELECT * FROM tipodocumento");
                $result_tipo = mysqli_num_rows($query_tipo);
                ?>

                <div class="form-group col-md-6">
                    <label class="form-label">Tipo del documento</label>
                    <select class="form-select notItemOne" name="tipo" id="tipo">
                        <?php
                        echo $optionDoc;
                        if ($result_tipo > 0) {
                            while ($tipo = mysqli_fetch_array($query_tipo)) {
                        ?>
                                <option value="<?php echo $tipo["idTipoDocumento"]; ?>"><?php echo $tipo["tipoDocumento"] ?></option>

                        <?php
                            }
                        }
                        ?>


                    </select>
                </div>
                <!-- Final Tipo documento -->

                <!-- numero -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número del documento</label>
                    <input type="number" class="form-control" name="numero" id="numero" value="<?php echo $numero; ?>">
                </div>
                <!-- Final numero -->

                <!-- boton registar -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="perfil.php" class="btn btn-danger">Volver</a>
                    <button type="submit" class="btn btn-success">Aceptar cambios</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>