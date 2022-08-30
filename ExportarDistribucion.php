<?php
$host = 'localhost';
$db_user = 'root';
$db_pass = '';

$database = 'bdtutoria';
$con=mysqli_connect($host, $db_user, $db_pass);
$mysqli = new mysqli("localhost","root","","bdtutoria");
if (!$con)
    die("No se pudo establecer conexión a la base de datos");

if (!mysqli_select_db($con,$database))
    die("base de datos no existe");



	header('Content-Type: text/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename=DistribuciónBalanceadaDeTutoria_2022-1.csv');
	
	$output = fopen("php://output", "w");
	fputcsv($output, array('Codigo', 'Nombre','NombreDocente'));
	$query = $con->query("SELECT * FROM tutorados UNION SELECT * FROM distribucion order by NombreDocente asc ");
	
	while($fetch = $query->fetch_assoc()){
		fputcsv($output, $fetch);
	}
	
	fclose($output);
?>
