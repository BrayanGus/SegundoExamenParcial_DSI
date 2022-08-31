<?php
   include("conexion.php");
   $con=conectar();
   $database = 'bdtutoria';
    if (!$con)
        die("No se pudo establecer conexión a la base de datos");

    if (!mysqli_select_db($con,$database))
        die("base de datos no existe");
        //Abrir Archivo
        $fname = $_FILES['sel_file']['name'];
        echo 'Archivo Cargado: '.$fname.' ';
            
        $Archivo = $_FILES['sel_file']['tmp_name'];
        $ArchivoAbierto = fopen($Archivo, "r");
        //Agregar datos de Archivo Abierto a la tabla Matriculados2022I
        if(isset($_POST['submit_Alumno']))
        {     
            mysqli_query($con,"DELETE FROM matriculados2022i");
            while (($data = fgetcsv($ArchivoAbierto, 1000, ",")) == true)
            {
                $sql = "INSERT INTO Matriculados2022I values('$data[0]','$data[1]')";
                mysqli_query($con,$sql) or die(mysqli_error());
            }
            
        }
        //Agregar datos del Archivo a la tabla Docente
        if(isset($_POST['submit_Docente']))
        {     
            mysqli_query($con,"DELETE FROM docente");
            while (($data = fgetcsv($ArchivoAbierto, 1000, ",")) == true)
            {
                $sql = "INSERT INTO Docente values('$data[0]','$data[1]','$data[2]')";
                mysqli_query($con,$sql) or die(mysqli_error());
            }
            
        }
        //Agregar datos del Archivo a la tabla Tutorados
        if(isset($_POST['submit_Tutorados']))
        {     
            mysqli_query($con,"DELETE FROM tutorados");
            while (($data = fgetcsv($ArchivoAbierto, 1000, ",")) == true)
            {
                $sql = "INSERT INTO Tutorados values('$data[0]','$data[1]','$data[2]')";
                mysqli_query($con,$sql) or die(mysqli_error());
            }
            
        }
        //Cerrar Archivo
        fclose($ArchivoAbierto);
        echo "<br>Importación exitosa!<br><br>";
?>