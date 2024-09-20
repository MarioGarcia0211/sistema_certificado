<?php 
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'ventas';

    try {
        $con = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
    }catch (PDOException $exception) {
        echo "Hola Connection error: " . $exception->getMessage();
    }

    $c2 = @mysqli_connect($host, $user, $password, $db);

    //mysqli_close($conection);

    if($c2){
        //echo "Conexion exitosa";
    }else {
        echo "Error en la conexión a la bd";
    }
?>