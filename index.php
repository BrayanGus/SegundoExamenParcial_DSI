<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass,$database);
$mysqli = new mysqli("localhost","root","","bdtutoria");
mysqli_query($con,"DELETE FROM docente");
mysqli_query($con,"DELETE FROM matriculados2022i");
mysqli_query($con,"DELETE FROM tutorados");
mysqli_query($con,"DELETE FROM distribucion");

 ?>
<!DOCTYPE html>
	<html lang="es-MX">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	</head>
	<body>
    <div class="container">
        <div class="row"> 
                        
            <div class="col-md-12">
                <h1>Subiendo los archivo CSV</h1>
                    
                    <form action='SubirMatriculados2022-1.php' method='post' enctype="multipart/form-data">
                        Importar Archivo de Alumnos Matriculados en el presente semestre: 
                        <input type='file' name="sel_file"size='20'><br>
                        <input type='submit' name='submit' class="btn btn-danger" value='Cargar Alumnos Matriculados'><br><br>

                    </form>

                    <form action='SubirDocentes2022-1.php' method='post' enctype="multipart/form-data">
                        Importar Archivo de Lista de docentes para el presente semestre.: 
                        <input type='file' name="sel_file"size='20'><br>
                        <input type='submit' name='submit' class="btn btn-danger" value='Cargar docentes'><br><br>

                    </form>

                    <form action='SubirTutorados2021-2.php' method='post' enctype="multipart/form-data">
                        Importar Archivo de Distribución de tutorías del anterior semestre : 
                        <input type='file' name='sel_file' size='20'><br>
                        <input type='submit' name='submit' class="btn btn-danger" value='Cargar tutorías del anterior semestre'><br><br>
                    </form>
                    

                    <form action='NoSeranTutorados.php' method='post' enctype="multipart/form-data">
                        <input type='submit' name='submit' class="btn btn-info" value='Mostrar Alumnos que no seran tutorados en 2022-I'><br><br>
                    </form>
                    <form action='DistribucionBalanceadaAlumnos.php' method='post' enctype="multipart/form-data">
                        <input type='submit' name='submit' class="btn btn-info" value='Mostrar Distribución Balanceada para Tutoria'>

                    </form>
            </div>
        </div>
	</body>
</html>
