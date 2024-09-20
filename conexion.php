<?php 
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'sistema_certificado';

    try {
        $con = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
    }catch (PDOException $exception) {
        echo "Hola Connection error: " . $exception->getMessage();
    }

    $conection = @mysqli_connect($host, $user, $password, $db);

    //mysqli_close($conection);

    if($conection){
        //echo "Conexion exitosa";
    }else {
        echo "Error en la conexión a la bd";
    }
?>