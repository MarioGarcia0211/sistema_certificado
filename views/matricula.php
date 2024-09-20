<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar matricula</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_matricula.php">Lista de matricula</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="matricula.php">Registrar matricula</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Registrar de matricula</h1>
            </div>
        </nav>

        <form action="" name="form_new_estudiante_matricula" id="form_new_estudiante_matricula">
            <div class="card">
                <div class="card-header">
                    Datos del estudiante
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Numero documento -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Número del documento</label>
                            <input class="form-control" type="number" name="nit_estudiante" id="nit_estudiante">
                        </div>
                        <!-- Final numero documento -->

                        <!-- Nombre -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Nombre completo</label>
                            <input class="form-control" type="text" disabled name="nombre" id="nombre">
                        </div>
                        <!-- Final nombre -->


                        <!-- Email -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Correo electronico</label>
                            <input class="form-control" type="text" disabled name="email" id="email">
                        </div>
                        <!-- Final email -->

                        <!-- Tipo documento -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Tipo documento</label>
                            <input class="form-control" type="text" disabled name="tipoDocumento" id="tipoDocumento">
                        </div>
                        <!-- Final Tipo documento -->

                        <input type="hidden" name="idEstudiante" id="idEstudiante" disabled>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Datos del curso
                </div>
                <div class="card-body">
                    <div class="row">

                        <!-- ID del curso -->
                        <div class="form-group col-md-3">
                            <label class="form-label">Codigo del curso</label>
                            <input class="form-control" type="number" name="idCurso" id="idCurso">
                        </div>
                        <!-- Final ID del curso -->

                        <!-- Nombre -->
                        <div class="form-group col-md-5">
                            <label class="form-label">Nombre del curso</label>
                            <input class="form-control" type="text" disabled name="curso" id="curso">
                        </div>
                        <!-- Final nombre -->

                        <!-- Nombre -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Nombre completo del profesor</label>
                            <input class="form-control" type="text" disabled name="nombreProfesor" id="nombreProfesor">
                        </div>
                        <!-- Final nombre -->

                        <!-- Apellido -->
                        <!-- <div class="form-group col-md-3">
                        <label class="form-label">Apellido del profesor</label>
                        <input class="form-control" type="text" disabled name="apellidoProfesor" id="apellidoProfesor" >
                    </div> -->
                        <!-- Final apellido -->

                        <!-- Email -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Correo electronico</label>
                            <input class="form-control" type="text" disabled name="emailProfesor" id="emailProfesor">
                        </div>
                        <!-- Final email -->

                        <!-- Hora inicio -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Hora de inicio</label>
                            <input class="form-control" type="time" disabled name="inicio" id="inicio">
                        </div>
                        <!-- Fin hora inicio  -->


                        <!-- Hora final -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Hora final</label>
                            <input class="form-control" type="time" disabled name="final" id="final">
                        </div>
                        <!-- Fin hora final -->

                        <!-- Precio -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Precio</label>
                            <input class="form-control" type="text" disabled name="precio" id="precio">
                        </div>
                        <!-- Fin precio -->

                        <!-- Descuento -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Descuento</label>
                            <input class="form-control" type="text" disabled name="descuento" id="descuento">
                        </div>
                        <!-- Fin descuento -->

                        <!-- Total -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Total</label>
                            <input class="form-control" type="text" disabled name="total" id="total">
                        </div>
                        <!-- Fin total -->


                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group col-12 d-flex">

                <div class="d-grid gap-2 d-md-block mx-auto">

                    <a href="" id="btn_facturar_matricula" class="btn btn-primary " type="button" title="">Procesar</a>

                </div>
            </div>
        </form>


    </div>

    <?php include "includes/footer.php"; ?>
    <script src="js/main.js"></script>
</body>

</html>