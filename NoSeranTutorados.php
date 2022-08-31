<?php 
// Conectar con la BD
include("Conexiondb.php");
$con=conectar();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> PAGINA TUTORIA</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        
    </head>
    <body>
            <div class="container mt-8">
                    <div class="row"> 
                        <div class="col-md-12">
						<h1>ALUMNOS SIN TUTORIA PARA EL SEMESTRE 2022-I</h1>
                            <hr style="border-top:1px dotted #ccc;"/>
                            <form action='ExportarCSV.php' method='post' enctype="multipart/form-data">
                                <input type="submit"name="NoMatriculados" class="btn btn-success pull-right" value="Exportar Tabla como CSV"><br><br>
                            </form> 
                            <br /><br />  
                            <center>
                            <button><a href="index.php?id=" class="btn btn-secondary"><b>Regresar</a></button></center>
                            <table class="table" >
                                <thead class="table-success table-striped" >
                                    <tr>
                                        <th>Nro</th>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                        <?php 
											/*  Alumnos que no se matricularon y no seran tutorados
                                                Selecciona a los alumnos Tutorados en el semestre 2022 - I
                                                que son matriculados en el presente semestre    */
                                            $alumnos_sin_tutoria = mysqli_query($con,"SELECT T.Codigo, T.Nombre 
                                                                        FROM Tutorados T left Join Matriculados2022I M 
																		on M.Codigo=T.Codigo 
                                                                        Where M.Codigo is NULL");
                                                                        
											//Mostrar Alumnos sin tutoria en el semestre 2022 - I
											$n=0;
											while($alumno_sin_tutor = mysqli_fetch_array($alumnos_sin_tutoria)){
												$n++;
												?>
													<tr><td><?php  echo $n?></td>    
													<td><?php  echo $alumno_sin_tutor['Codigo']?></td>
													<td><?php  echo $alumno_sin_tutor['Nombre']?></td>                                     
													</tr>
												
                                        		<?php 
                                            }	
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
            </div>
    </body>
</html>
