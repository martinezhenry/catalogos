<?php 

$directorio = opendir("../../assets/img/fondoFlyer"); //ruta actual
			while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
			{
			    var_dump($archivo);

			    if (strpos($archivo, 'fondoTemp.') !== false){
			    	$arr = explode('.', $archivo);
			    	echo "La extension es: " . $arr[1];
			    }
			    
			}
