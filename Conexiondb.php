<?php
/* Metodo para conectar a la Base de Datos */
function conectar(){
    $host="localhost";
    $user="root";
    $pass="";

    $bd="bdtutoria";

    $con=mysqli_connect($host,$user,$pass);

    mysqli_select_db($con,$bd);

    return $con;
}
?>