<?php
/* AUTOR: YORDIN DA ROCHA
 * FECHA: SEPTIEMBRE 2013
 */

$host = "50.196.74.121";
$usuario = "vzla";
$clave = "vzla5740tex";
$nom_bd = "autodatasystem";
echo 'CONEXION A BD TEXTRONIC<br>';
$link=mysqli_connect($host,$usuario,$clave,$nom_bd) or die("No se pudo conectar con la base de datos. ".mysql_error());

$q = mysqli_query($link, "SELECT * FROM `codes cat` LIMIT 0,10");
if($q){
while($r = mysqli_fetch_array($q)){
    echo 'CODIGO CAT: '.$r['CatCode'].'<br>';
}
}else{ echo mysqli_error(); }

$q = mysqli_query($link, "SELECT * FROM `g_inventory` LIMIT 0,20");
if($q){
while($r = mysqli_fetch_array($q)){
    echo 'CODIGO ARTICULO: '.$r['SkuNo'].'<br>';
	echo 'DESCRIPCIÓN: '.$r['ProdDesc'].'<br>';
	 
  echo 'CODIGO CAT: '.$r[1].'<br>';
	echo 'CODIGO CAT: '.$r[2].'<br>';
	echo 'CODIGO CAT: '.$r[3].'<br>';
	echo 'CODIGO CAT: '.$r[4].'<br>';
	echo 'CODIGO CAT: '.$r[5].'<br>';
	echo 'CODIGO CAT: '.$r[6].'<br>';
	echo 'CODIGO CAT: '.$r[7].'<br>';
	
	echo 'otro codigo: <br>';
}

}else{ echo mysqli_error(); }

?>