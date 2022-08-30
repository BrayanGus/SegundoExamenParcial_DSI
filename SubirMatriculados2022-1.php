<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass);
$mysqli = new mysqli("localhost","root","","bdtutoria");
//mysqli_query($con,"DELETE FROM matriculados2022i");
if (!$con)
    die("No se pudo establecer conexión a la base de datos");

if (!mysqli_select_db($con,$database))
    die("base de datos no existe");

    if(isset($_POST['submit']))
    {
        //importacion para matriculados 2022-I
        $fname2 = $_FILES['sel_file']['name'];
        echo 'Archivo Cargado: '.$fname2.' ';
        
        $Matriculados = $_FILES['sel_file']['tmp_name'];
        $archivo2 = fopen($Matriculados, "r");
			 
        while (($data2 = fgetcsv($archivo2, 1000, ",")) == true)
        {
            $sql = "INSERT INTO Matriculados2022I values('$data2[0]', '$data2[1]')";
            mysqli_query($con,$sql) or die(mysqli_error());
        }
            
        fclose($archivo2);
        echo "<br>Importación exitosa!";
       
             
    }
    ?>  