<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Border Radius</title>
    <style>
        .caja {
            width: 200px;
            height: 100px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            
            border-radius: 10px;
        }

        .caja-especifica {
            width: 200px;
            height: 100px;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 20px;
            
            /* Aplica esquinas redondeadas solo a la esquina superior izquierda */
            border-top-left-radius: 20px;
        }
    </style>
</head>

<body>

    <div class="caja">Esquinas redondeadas en todos los lados</div>

    <div class="caja-especifica">Esquina superior izquierda redondeada</div>

</body>

</html>
