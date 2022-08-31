<?php
// Conexion a la BD
include("Conexiondb.php");
$con=conectar();
$database = 'bdtutoria';
# -- Comprobar la conexión a la BD
if (!$con)
    die("No se pudo establecer conexión a la base de datos");
# -- Compruba si existe la BD
if (!mysqli_select_db($con,$database))
    die("base de datos no existe");

	$output = fopen("php://output", "w");
    /*============ Exportacion de los alumnos que no seran tutorados en 2022-I =========== */
	if(isset($_POST['NoMatriculados']))
    {  
		header('Content-Type: text/csv; charset=UTF-8');
		header('Content-Disposition: attachment; filename= AlumnosNoMatriculados_2022-1.csv');
		
		fputcsv($output, array('Codigo', 'Nombre'));
		$query = $con->query("SELECT T.Codigo, T.Nombre FROM Tutorados T left Join Matriculados2022I M on M.Codigo=T.Codigo Where M.Codigo is NULL");
		while($fetch = $query->fetch_assoc()){
			fputcsv($output, $fetch);
		}
	}
    /*============ Exportacion de la distribucion balanceada de alumnos tutorados en 2022-I =========== */
    if(isset($_POST['DistribucionBalanceada']))
    {
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=DistribuciónBalanceadaDeTutoria_2022-1.csv');
        
        fputcsv($output, array('Codigo', 'Nombre','NombreDocente'));
        $Distribución_Completa= mysqli_query($con,"SELECT * FROM matriculadoscontutor UNION SELECT * FROM distribucion order by NombreDocente asc ");
        while($fetch = $Distribución_Completa->fetch_assoc()){
            fputcsv($output, $fetch);
        }
    }
	
	fclose($output);
?>