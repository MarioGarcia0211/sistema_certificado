$(document).ready(function () {

    $('#nit_estudiante').keyup(function (e) {
        e.preventDefault();

        var est = $(this).val();
        var action = 'buscarEstudiante';
        var id = $('#idCurso').val();

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, estudiante: est },


            success: function (response) {


                if (response == 0) {
                    $('#idEstudiante').val('');
                    $('#nombre').val('');
                    $('#email').val('');
                    $('#tipoDocumento').val('');


                } else {
                    var data = $.parseJSON(response);

                    $('#idEstudiante').val(data.idUsuario);
                    $('#nombre').val(data.nombre + " " + data.apellido);
                    $('#email').val(data.email);
                    $('#tipoDocumento').val(data.tipoDocumento);
                    console.log(data);

                }
            },

            error: function (error) {
                console.log(error);
            }
        });

    });

    $('#idCurso').keyup(function (e) {
        e.preventDefault();

        var action = 'buscarCurso';
        var id = $('#idCurso').val();
        var nit = $('#nit_estudiante').val();

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, curso: id, estudiante: nit},


            success: function (response) {


                if (response == 0) {
                    $('#idCurso').val('');
                    $('#curso').val('');
                    $('#nombreProfesor').val('');
                    $('#emailProfesor').val('');
                    $('#inicio').val('');
                    $('#final').val('');
                    $('#precio').val('');
                    $('#descuento').val('');
                    $('#total').val('');

                } else {
                    var data = $.parseJSON(response);
                    var descuento = data.descuento;
                    var descontar = data.precio * (descuento / 100);
                    var total = data.precio - descontar;
                    $('#idCurso').val(data.idCurso);
                    $('#curso').val(data.curso);
                    $('#nombreProfesor').val(data.nombre + " " + data.apellido);
                    $('#emailProfesor').val(data.email);
                    $('#inicio').val(data.horaInicio);
                    $('#final').val(data.horaFin);
                    $('#precio').val(data.precio);
                    $('#descuento').val(descuento+"%");
                    $('#total').val(total);
                    console.log(data);

                }
            },

            error: function (error) {
                console.log(error);
            }
        });

    });

    $('#btn_facturar_matricula').on("click", function (e) {
        e.preventDefault();

        var action = 'procesarMatricula';
        var idEstudiante = $('#idEstudiante').val();
        var idCurso = $('#idCurso').val();

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: { action: action, estudiante: idEstudiante, curso: idCurso },

            success: function (response) {

                if(response != 'error'){

                    var info = JSON.parse(response);
                    console.log(info);

                    generarPDF(info.idMatricula);
                    location.reload();

                }else{
                    console.log("No data");
                }
            },

            error: function (error) {
                console.log(error);
            }
        });

    });

});

function generarPDF(factura){

    $url = 'mostrar_matricula.php?id='+factura;
    window.open($url);
}