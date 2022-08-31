<?php 
	function ConvertirArreglos($Data,$n) 
    {
        $ArregloData =array();
        while($Fila1 = mysqli_fetch_array($Data)){
            array_push($ArregloData,$Fila1[$n]);
        } 
        return $ArregloData;
    }
?>