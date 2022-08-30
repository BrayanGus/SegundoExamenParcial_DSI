<?php 
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass,$database);
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
                            <a href="ExportarDistribucion.php" class="btn btn-success pull-right"><span class="glyphicon glyphicon-export"></span> Exportar Tabla como CSV</a>
                            <br /><br />  
                            <button><a href="index.php?id=" class="btn btn-secondary"><b>Regresar</a></button>
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
                                            $AlumnosNuevos = mysqli_query($con,"SELECT  M.Codigo, M.Nombre FROM Matriculados2022I M left Join Tutorados T
                                                                                on M.Codigo=T.Codigo Where T.Codigo is NULL;");
                                            
                                            $AlumnosAntiguos = mysqli_query($con,"SELECT Codigo FROM tutorados");

                                            $Docentes = mysqli_query($con,"SELECT NombreDocente FROM tutorados GROUP BY NombreDocente");

                                            $Cantidad_AlumnosNuevos = mysqli_num_rows($AlumnosNuevos);
                                            $Cantidad_AlumnosAntiguos = mysqli_num_rows($AlumnosAntiguos);
                                            $Cantidad_Docente = mysqli_num_rows($Docentes);

                                            //Operación
                                            $aux = floor(($Cantidad_AlumnosNuevos+$Cantidad_AlumnosAntiguos)/$Cantidad_Docente);//21

                                            //Hallar la cantidad de tutorados de cada docente
                                                $CantidadTutorados_x_DOcente = mysqli_query($con,"SELECT COUNT(*) AS CantidadTutorados FROM tutorados
                                                                                                    GROUP BY NombreDocente");

                                            //Cantidad en arreglo
                                            $aux2 = $Cantidad_Docente;
                                            
                                            //Auxiliares
                                            $i = 0;
                                            $j = 0;
                                            
                                            $ArregloAlumnoNuevos = array();
                                            $ArregloAlumnosNn = array();
                                            
                                            $ArregloDocentes =array();
                                            $ArregloCantidadTutorados = array();
                                            
                                            while($Arreglo_AlumnosNuevos = mysqli_fetch_array($AlumnosNuevos)){
                                                array_push($ArregloAlumnoNuevos,$Arreglo_AlumnosNuevos['Codigo']);
                                                array_push($ArregloAlumnosNn,$Arreglo_AlumnosNuevos['Nombre']);
                                            }
                                            
                                            while($Arreglo_Docentes = mysqli_fetch_array($Docentes)){
                                                array_push($ArregloDocentes,$Arreglo_Docentes['NombreDocente']);
                                            }
                                            
                                             while($CantidadTutoradoDocente = mysqli_fetch_array($CantidadTutorados_x_DOcente)){
                                                array_push($ArregloCantidadTutorados,$CantidadTutoradoDocente['CantidadTutorados']);
                                            }
                                           
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
                                            
                                            $Distribución_Completa= mysqli_query($con,"SELECT * FROM tutorados UNION SELECT * FROM distribucion order by NombreDocente asc ");
                                            
											//Listar en una tabla
                                            $Distribución = mysqli_query($con,"SELECT codigo, Nombre, NombreDocente FROM distribucion");
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