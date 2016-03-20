<?php 

$link1=mysql_connect("localhost","root","admin") or die("No se pudo conectar con la base de datos en el servidor. ".mysql_error());
$bd = mysql_select_db('textronic_y',$link1) or die("No se pudo abrir la Base de Datos. ".mysql_error());
/*
function Conectarse() 
{ 
   if (!($link1=mysql_connect("localhost","root","admin"))) 
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mysql_select_db("textronic",$link1)) 
 { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
   return $link; 
} */
?>
