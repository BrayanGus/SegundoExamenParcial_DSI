<?php
include("Conexiondb.php");
$con=conectar();
$database = 'bdtutoria';

 ?>
<!DOCTYPE html>
	<html lang="es-MX">
	<head>
		<meta charset="UTF-8" />
        
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
        <style>
            div { 
                width: 50%;
                height: 200px;
               
            }
       
            h1.concss {
                font-size: 18px;
                font-weight: bold;
                font-style: italic;
                font-variant: small-caps;
                font-family: monospace;
                text-transform: capitalize;
                letter-spacing: 4px;
                color: #0000CD;
                text-align:center;
                word-spacing: 8px
            }
            
            h3.concss {
                text-align: center; 
                font-size: 40px;
                font-family: italic;
                font-weight: bold;
                font-style: italic;
                text-transform: uppercase;
                text-decoration: underline;
                letter-spacing: 12px;
                color: 	#800080;
                
            }

            button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            }
       
            #foto{
            max-width: 30%;
            margin: 20px;
            padding: 10px;
            display: inline-block;
            margin: auto;
            transform: translate(-10%, -3%);
            -webkit-transform: translate(-10%, -3%);
            }
            #foto2{
            max-width: 30%;
            margin: 10px;
            padding: 10px;
            display: inline-block;
            margin: auto;
            transform: translate(20%, 15%);
            -webkit-transform: translate(20%, 15%);}

            </style>
                
	</head>
    <header >
        <h3 class="concss">  Bienvenidos al portal tutoria  </h3>
        <img id ="foto" src="info.png" width="450" height="350" align="right" /> 
    
        <img id ="foto2"  src="unsaac.png" width="300" height="300" align="left"/>

    </header>
    
        <body style="background-color:#E6E6FA;">
            <div class="container" align='center'>
                <div class="row">           
                    <div class="col-md-12">
                    
                        
       
                            <form action='SubirArchivo.php' method='post' enctype="multipart/form-data">
                                
                                <h1 class="concss">Importar Archivo de Alumnos Matriculados en el presente semestre: </h1>
                                <input type='file' name="sel_file"size='20'><br>
                                <input type='submit' name='submit_Alumno' class="btn btn-danger" value='Cargar Alumnos Matriculados'><br><br>

                            </form>

                            <form action='SubirArchivo.php' method='post' enctype="multipart/form-data">
                            
                                <h1 class="concss">Importar Archivo de Lista de docentes para el presente semestre:</h1>
                                <input type='file' name="sel_file"size='20'><br>
                                <input type='submit' name='submit_Docente' class="btn btn-danger" value='Cargar docentes'><br><br>

                            </form>

                            <form action='SubirArchivo.php' method='post' enctype="multipart/form-data">
                                <h1 class="concss">Importar Archivo de Distribución de tutorías del anterior semestre : </h1>
                                <input type='file' name='sel_file' size='20'><br>
                                <input type='submit' name='submit_Tutorados' class="btn btn-danger" value='Cargar tutorías del anterior semestre'><br><br>
                            </form>


                            <form action='NoSeranTutorados.php' method='post' enctype="multipart/form-data">
                                <input type='submit' name='submit' class="btn btn-info" value='Mostrar Alumnos que no seran tutorados en 2022-I'><br><br>
                            </form>
                            <form action='DistribucionBalanceadaAlumnos.php' method='post' enctype="multipart/form-data">
                                <input type='submit' name='submit' class="btn btn-info"  value= 'Mostrar Distribución Balanceada para Tutoria'>

                            </form>
                           
                    </div>
                </div>
            </body> 
</html>