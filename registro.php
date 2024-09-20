<?php

$alert = ''; // Esta línea crea una variable llamada $alert y le asigna una cadena vacía como valor inicial. Esta variable sera utilizada posteriormente para almacenar un mensaje de alerta. //

$rand = rand(1000, 9999); // Esta línea crea una variable llamada $rand y le asigna un valor generado aleatoriamente utilizando la función rand(). La función rand(1000, 9999) generará un número aleatorio entre 1000 y 9999 //

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email']) || empty($_POST['clave']) || empty($_POST['tipoDocumento']) || empty($_POST['numero']) || empty($_POST['captcha'])) {

        $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
              </div>';
    } else {

        if ($_POST['captcha'] != $_POST['codigo']) {
            $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
                  </div>';
        } else {

            require_once "conexion.php";

            $nombreUsuario = $_POST['nombre'];
            $apellidoUsuario = $_POST['apellido'];
            $email = $_POST['email'];
            $clave = md5($_POST['clave']);
            $tipoDocumento = $_POST['tipoDocumento'];
            $numeroDocumento = $_POST['numero'];
            $idRol = 3;

            $result = 0;
            $result2 = 0;
            $result3 = 0;

            if ((is_numeric($numeroDocumento) && $email)) {
                $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE numeroDocumento = '$numeroDocumento' AND email = '$email'");
                $result = mysqli_fetch_array($query);

                $query2 = mysqli_query($conection, "SELECT * FROM usuarios WHERE numeroDocumento = '$numeroDocumento'");
                $result2 = mysqli_fetch_array($query2);

                $query3 = mysqli_query($conection, "SELECT * FROM usuarios WHERE email = '$email'");
                $result3 = mysqli_fetch_array($query3);
            }

            if (($result > 0)) {

                $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El número del documento y el email ya existen.
                  </div>';
            } elseif ($result2 > 0) {
                $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El número del documento ya existe.
                  </div>';
            } elseif ($result3 > 0) {
                $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El email ya existe.
                  </div>';
            } else {

                $insert = mysqli_query($conection, "INSERT INTO usuarios (nombre, apellido, email, clave, idTipoDocumento, numeroDocumento, idRol) VALUES ('$nombreUsuario', '$apellidoUsuario', '$email', '$clave', '$tipoDocumento', '$numeroDocumento', '$idRol')");

                $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Usuario registrado correctamente.
                  </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resgistrarse</title>

    <!-- Link CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- FinLink CSS -->

    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Fin Link Bootstrap -->

    <!-- Link Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Fin Link Bootstrap icons -->
</head>

<body>
    <div class="contenedor">
        <div class="registro">
            <h1 class="tituloLogin">Registrate</h1>

            <!-- Alerta -->
            <div class="alerta">
                <?php
                echo isset($alert) ? $alert : '';
                ?>
            </div>
            <!-- Final alerta -->
            <form action="" method="post">

                <div class="row">

                    <!-- Nombre -->
                    <div class="form-group col-md-6">
                        <label class="form-label">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="nombre">
                    </div>
                    <!-- Final nombre -->

                    <!-- Apellido -->
                    <div class="form-group col-md-6">
                        <label class="form-label">Apellido</label>
                        <input class="form-control" type="text" name="apellido" id="apellido">
                    </div>
                    <!-- Final apellido -->

                    <!-- Email -->
                    <div class="form-group col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" id="email">
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

                    include "conexion.php";
                    $query_tipo = mysqli_query($conection, "SELECT * FROM tipoDocumento");
                    $result_tipo = mysqli_num_rows($query_tipo);
                    ?>

                    <div class="form-group col-md-6">
                        <label class="form-label">Tipo de documento</label>
                        <select class="form-select" name="tipoDocumento" id="tipoDocumento">
                            <option selected disabled>Elige el tipo</option>
                            <?php
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
                    <!-- Final tipo documento -->

                    <!-- numero -->
                    <div class="form-group col-md-6">
                        <label class="form-label">Número del documento</label>
                        <input type="text" class="form-control" name="numero" id="numero">
                    </div>
                    <!-- Final numero -->

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
                </div>

                <!-- Boton -->
                <input type="submit" class="btn btn-primary w-100" value="Registrarse">
                <!-- Final boton -->

            </form>
            <div class="footer-text text-center">¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- Final scripts -->
</body>

</html>