<?php 
include("conexion.php");
$con=conectar();
$database = 'bdtutoria';
mysqli_query($con,"DELETE FROM matriculadoscontutor");
mysqli_query($con,"DELETE FROM distribucion");
require 'ConvertirArreglos.php'; 
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
						<h1>Distribución Balanceada de Tutoria del semestre 2022</h1>
                            <hr style="border-top:1px dotted #ccc;"/>
                            <form action='ExportarCSV.php' method='post' enctype="multipart/form-data">
                                <input type="submit"name="DistribucionBalanceada" class="btn btn-success pull-right" value="Exportar Tabla como CSV"><br><br>
                            </form> 
                            <br /><br />  
                            <center><form> <input type = "button" value = "Regresar" onclick = "history.back ()"> </form></center>

                            <table class="table" >
                                <thead class="table-success table-striped" >
                                    <tr>
                                        <th>Nro</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>NombreDocente</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>    

                                <tbody>
                                        <?php 
											
                                            $AlumnosNuevos = mysqli_query($con,"SELECT  M.Codigo FROM Matriculados2022I M left Join Tutorados T
                                                                                on M.Codigo=T.Codigo Where T.Codigo is NULL;");
                                            $AlumnosNuevosN = mysqli_query($con,"SELECT  M.Nombre FROM Matriculados2022I M left Join Tutorados T
                                            on M.Codigo=T.Codigo Where T.Codigo is NULL;");
                                            $AlumnosAntiguos = mysqli_query($con,"SELECT * FROM tutorados T INNER JOIN Matriculados2022I M on T.Codigo = M.Codigo");
                                            //$MatriculadosTutor =array();
                                            while($MatriculadosTutor = mysqli_fetch_array($AlumnosAntiguos)){
                                                mysqli_query($con,"INSERT INTO matriculadoscontutor VALUES ('$MatriculadosTutor[Codigo]','$MatriculadosTutor[Nombre]','$MatriculadosTutor[NombreDocente]')");
                                            }

                                            $Docentes = mysqli_query($con,"SELECT NombreDocente FROM tutorados GROUP BY NombreDocente");

                                            $Cantidad_AlumnosNuevos = mysqli_num_rows($AlumnosNuevos);
                                            $Cantidad_AlumnosAntiguos = mysqli_num_rows($AlumnosAntiguos);
                                            $Cantidad_Docente = mysqli_num_rows($Docentes);

                                            //Operación
                                            $aux = ceil(($Cantidad_AlumnosNuevos+$Cantidad_AlumnosAntiguos)/$Cantidad_Docente);//21

                                            //Hallar la cantidad de tutorados de cada docente
                                            $CantidadTutorados_x_DOcente = mysqli_query($con,"SELECT COUNT(*) AS CantidadTutorados FROM matriculadoscontutor
                                                                                                    GROUP BY NombreDocente");

                                            //Cantidad en arreglo
                                            $aux2 = $Cantidad_Docente;
                                            
                                            //Auxiliares
                                            $ArregloAlumnoNuevos = ConvertirArreglos($AlumnosNuevos,0);
                                            $ArregloAlumnosNn = ConvertirArreglos($AlumnosNuevosN,0);
                                            $ArregloDocentes =ConvertirArreglos($Docentes,0);
                                            $ArregloCantidadTutorados = ConvertirArreglos($CantidadTutorados_x_DOcente,0);
                                            
                                            $i = 0;
                                            $j = 0;
                                            while($i < $aux2){
                                                $Tutorados = intval($ArregloCantidadTutorados[$i]);
                                                while($Tutorados < $aux){
                                                    if ($j >= $Cantidad_AlumnosNuevos){
                                                        break;
                                                    }
                                                    mysqli_query($con,"INSERT INTO distribucion VALUES ('$ArregloAlumnoNuevos[$j]','$ArregloAlumnosNn[$j]','$ArregloDocentes[$i]')");
                                                    $Tutorados = $Tutorados+1;
                                                    $j = $j +1 ;
                                                    
                                                }
                                                $i=$i+1;
                                                
                                            }
                                            //*
                                            $Distribución_Completa= mysqli_query($con,"SELECT * FROM matriculadoscontutor UNION SELECT * FROM distribucion order by NombreDocente asc ");
                                            
											//Listar en una tabla
											$n=0;
											while($fila1 = mysqli_fetch_array($Distribución_Completa)){
												$n++;
												?>
													<tr><td><?php  echo $n?></td>    
                                                    <td><?php  echo $fila1['Codigo']?></td> 
													<td><?php  echo $fila1['Nombre']?></td> 
                                                    <td><?php  echo $fila1['NombreDocente']?></td>                                    
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
<?php 