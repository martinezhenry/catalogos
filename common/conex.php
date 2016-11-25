<?php
/* AUTOR: YORDIN DA ROCHA
 * FECHA: SEPTIEMBRE 2013
 */
global $usuario,$clave,$nom_bd,$link;
//SERVIDOR VACATIONS
//$usuario = "vacation_root";
//$clave = "Clave123";

//LOCAL
$usuario = "root";
$clave = "";
$nom_bd = "catalogo";
//$link=mysql_connect("localhost",$usuario,$clave) or die("No se pudo conectar con la base de datos en el servidor. ".mysql_error());
//$bd = mysql_select_db($nom_bd,$link) or die("No se pudo abri la Base de Datos. ".mysql_error());
$link=mysqli_connect("localhost",$usuario,$clave,$nom_bd) or die("No se pudo conectar con la base de datos. ".mysql_error());
//$bd = mysql_select_db($nom_bd,$link) or die("No se pudo abri la Base de Datos. ".mysql_error());