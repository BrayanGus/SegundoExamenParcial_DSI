<?php 
include("Conexiondb.php");
$con=conectar();
mysqli_query($con,"DELETE FROM matriculadoscontutor");
mysqli_query($con,"DELETE FROM distribucion");
require 'Arreglo.php';
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
                                            // ================================= Consultas ======================================
                                            /*  Alumnos nuevos para tutoria Matriculados en el semestre actual
                                                que no fueron tutorados en el semestre anterior*/
											$alumnos_nuevos_tutoria = mysqli_query($con,"SELECT  M.Codigo, M.Nombre 
                                                                                FROM Matriculados2022I M left Join Tutorados T
                                                                                ON M.Codigo=T.Codigo 
                                                                                WHERE T.Codigo is NULL;");
                                            /*  Alumnos nuevos para tutoria solo nombres */
                                            $alumnos_nuevos_tutoria_nombres = mysqli_query($con,"SELECT  M.Nombre 
                                                                                FROM Matriculados2022I M left Join Tutorados T
                                                                                ON M.Codigo=T.Codigo Where T.Codigo is NULL;");
                                            
                                            /*  Alumnos antiguos que fueron tutorados en el semestre anterior 
                                                y que se matricularon en el semestre actual */
                                            $alumnos_antiguos_tutorados = mysqli_query($con,"SELECT * 
                                                                                FROM tutorados T inner join Matriculados2022I M 
                                                                                ON T.Codigo = M.Codigo");
                                            // Creamos una nueva tabla de Alumnos Matriculados con Tutor
                                            while($alumnos_matriculados_tutor = mysqli_fetch_array($alumnos_antiguos_tutorados)){
                                                mysqli_query($con,"INSERT INTO matriculadoscontutor
                                                VALUES ('$alumnos_matriculados_tutor[Codigo]','$alumnos_matriculados_tutor[Nombre]','$alumnos_matriculados_tutor[NombreDocente]')");
                                            }
                                            /*  docentes tutorandos en el semestre anterior */
                                            $docentes = mysqli_query($con,"SELECT NombreDocente 
                                                                        FROM tutorados GROUP BY NombreDocente");
                                            // ==================================================================================
                                             
                                            // Hallar la cantidad de tutorados por cada docente
                                             $cantidad_tutorados_docente = mysqli_query($con,"SELECT COUNT(*) AS CantidadTutorados FROM matriculadoscontutor
                                             GROUP BY NombreDocente");

                                            // Determinamos cantidades de datos en tablas
                                            $cantidad_alumnos_nuevos = mysqli_num_rows($alumnos_nuevos_tutoria);
                                            $cantidad_alumnos_antiguos = mysqli_num_rows($alumnos_antiguos_tutorados);
                                            $cantidad_docentes = mysqli_num_rows($docentes);  
                                            // Cantidad de alumnos promedio de cada docente 
                                            $cantidad_alumnos_promedio = 0;
                                            if ($cantidad_docentes != 0){      
                                                $cantidad_alumnos_promedio = ceil(($cantidad_alumnos_nuevos + $cantidad_alumnos_antiguos)/$cantidad_docentes);//21
                                            }

                                            // Convetimos las Consultas en Arreglos
                                            $arreglo_alumnos_nuevos = ConvertirArreglos($alumnos_nuevos_tutoria,0);
                                            $arreglo_alumnos_nuevos_nombre = ConvertirArreglos($alumnos_nuevos_tutoria_nombres,0);
                                            $arreglo_docentes =ConvertirArreglos($docentes,0);
                                            $arreglo_cantidad_tutorados_docente = ConvertirArreglos($cantidad_tutorados_docente,0);
                                            
                                            // Inicializamos variables Auxiliares
                                            $cantidad_docentes_aux = $cantidad_docentes;                                           
                                            $docente_aux = 0; // Docente Auxiliar i
                                            $contador_alumnos = 0; // Contador de alumnos j

                                            // Metodo que permite el  Valanceo de los alumnos nuevos a los tutores
                                            while($docente_aux < $cantidad_docentes_aux){
                                                $cantidad_tutorados = intval($arreglo_cantidad_tutorados_docente[$docente_aux]);
                                                while($cantidad_tutorados < $cantidad_alumnos_promedio){
                                                    if ($contador_alumnos >= $cantidad_alumnos_nuevos){
                                                        break;
                                                    }
                                                    mysqli_query($con,"INSERT INTO distribucion 
                                                    VALUES ('$arreglo_alumnos_nuevos[$contador_alumnos]',
                                                    '$arreglo_alumnos_nuevos_nombre[$contador_alumnos]',
                                                    '$arreglo_docentes[$docente_aux]')");

                                                    $cantidad_tutorados++;
                                                    $contador_alumnos++;
                                                    
                                                }
                                                $docente_aux++;
                                                
                                            }
                                            // ====================================================================
                                             /*  Dsitribucion Completa alumnos matriculados con tutor distribuidos a cada tutor
                                                ordenados de forma ascendente*/
                                            $Distribución_Completa= mysqli_query($con,"SELECT * FROM matriculadoscontutor UNION SELECT * FROM distribucion order by NombreDocente asc ");
                                            
											// Mostrar Resultados en una tabla
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