<?php

$alert = ''; // Esta línea crea una variable llamada $alert y le asigna una cadena vacía como valor inicial. Esta variable sera utilizada posteriormente para almacenar un mensaje de alerta. //

$rand = rand(1000, 9999); // Esta línea crea una variable llamada $rand y le asigna un valor generado aleatoriamente utilizando la función rand(). La función rand(1000, 9999) generará un número aleatorio entre 1000 y 9999 //

session_start();
if (!empty($_SESSION['active'])) {
    header('location: views/');
} else {
    if (!empty($_POST)) {

        if (empty($_POST['email']) || empty($_POST['clave']) || empty($_POST['captcha'])) {
            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Todos los datos son obligatorios.
              </div>';
        } else {
            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el código.
              </div>';
            } else {

                require_once "conexion.php";

                $email = mysqli_real_escape_string($conection, $_POST['email']);
                $clave = md5(mysqli_real_escape_string($conection, $_POST['clave']));
                $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE email = '$email' AND clave = '$clave'");

                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    $data = mysqli_fetch_array($query);
                    $_SESSION['active'] = true;
                    $_SESSION['idUsuario'] = $data['idUsuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['apellido'] = $data['apellido'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['clave'] = $data['clave'];
                    $_SESSION['idTipoDocumento'] = $data['idTipoDocumento'];
                    $_SESSION['numeroDocumento'] = $data['numeroDocumento'];
                    $_SESSION['idRol'] = $data['idRol'];
                    $_SESSION['estado'] = $data['estado'];

                    header('location: views/');
                } else {

                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El email o la contraseña son incorrectas.
                  </div>';
                    session_destroy();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesion</title>

    <!-- Link CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- FinLink CSS -->

    <!-- Link Bootstrap -->
    <link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- Fin Link Bootstrap -->

    <!-- Link Bootstrap icons -->
    <link rel="stylesheet" href="">
    <!-- Fin Link Bootstrap icons -->
</head>

<body>
    <div class="contenedor">
        <div class="login">
            <h1 class="tituloLogin">Iniciar Sesión</h1>

            <!-- Alerta -->
            <div class="alerta">
                <?php
                echo isset($alert) ? $alert : '';
                ?>
            </div>
            <!-- Final alerta -->
            <form action="" method="post">

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" autocomplete="off">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="clave" autocomplete="off">
                </div>
                <!-- Final contraseña -->

                <!-- Captcha -->
                <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label class="form-label">Captcha</label>
                        <input type="text" class="form-control" name="captcha" id="captcha">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Código del captcha</label>
                        <input type="text" class="form-control text-center" name="codigo" id="codigo" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); color:white;" value="<?php echo $rand; ?>" readonly>
                    </div>
                </div>
                <!-- Final captcha -->

                <!-- Boton -->
                <input type="submit" class="btn btn-primary w-100" value="Ingresar">
                <!-- Final boton -->

            </form>
            <div class="footer-text text-center">¿Eres nuevo usuario? <a href="registro.php">Regístrate</a></div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="libraries/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="libraries/bootstrap/js/bootstrap.min.js"></script>
    <!-- Final scripts -->
</body>

</html>