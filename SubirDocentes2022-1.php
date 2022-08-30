<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass);
$mysqli = new mysqli("localhost","root","","bdtutoria");
//mysqli_query($con,"DELETE FROM docente");
if (!$con)
    die("No se pudo establecer conexión a la base de datos");

if (!mysqli_select_db($con,$database))
    die("base de datos no existe");

    if(isset($_POST['submit']))
    {
        //importacion para docentes 2022-I
        $fname2 = $_FILES['sel_file']['name'];
        echo 'Archivo Cargado: '.$fname2.' ';
        
        $Docentes = $_FILES['sel_file']['tmp_name'];
        $archivo2 = fopen($Docentes, "r");
			 
        while (($data2 = fgetcsv($archivo2, 1000, ",")) == true)
        {
            $sql = "INSERT INTO Docente values('$data2[0]', '$data2[1]','$data2[2]')";
            mysqli_query($con,$sql) or die(mysqli_error());
        }
            
        fclose($archivo2);
        echo "<br>Importación exitosa!";
       
             
    }
    ?>  