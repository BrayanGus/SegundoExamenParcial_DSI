<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass);
$mysqli = new mysqli("localhost","root","","bdtutoria");
//mysqli_query($con,"DELETE FROM tutorados");

if (!$con)
    die("No se pudo establecer conexión a la base de datos");

if (!mysqli_select_db($con,$database))
    die("base de datos no existe");


    if(isset($_POST['submit']))
    {   //importacion para alumnos antiguos
        $fname3 = $_FILES['sel_file']['name'];
        echo 'Archivo Cargado: '.$fname3.' ';
        
        $Tutorados = $_FILES['sel_file']['tmp_name'];
        $archivo3 = fopen($Tutorados, "r");
			 
        while (($data3 = fgetcsv($archivo3, 1000, ",")) == true)
        {
            $sql1 = "INSERT INTO Tutorados values('$data3[0]', '$data3[1]','$data3[2]')";
            mysqli_query($con,$sql1) or die(mysqli_error());
            
        }
            
        fclose($archivo3);
        echo "<br>Importación exitosa!<br><br>";
    }
    ?>