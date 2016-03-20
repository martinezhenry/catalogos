<?
/*function Conectarse() 
{ 
   if (!($link1=mysql_connect("localhost","gibbleco_textron","3S$r&}RWE)kT"))) { 
      echo "Error conectando a la base de datos."; 
      exit(); } 
  if (!mysql_select_db("gibbleco_textronic",$link1)) { 
      echo "Error seleccionando la base de datos."; 
      exit(); } 
   return $link1; 
}*/

function Conectarse() 
{ 
   if (!($link1=mysql_connect("localhost","v1131055_cat_us","Clave123"))) { 
      echo "Error conectando a la base de datos."; 
      exit(); } 
  if (!mysql_select_db("v1131055_cat",$link1)) { 
      echo "Error seleccionando la base de datos."; 
      exit(); } 
   return $link1; 
}

function desconectar()
{
	mysql_close($link1);
}


function consulta_catalogo($id_ca){
  $link1=Conectarse();
  $sqlt= mysql_query("SELECT * FROM catalogo where id_catalogo ='$id_ca'",$link1); 
  $rown= mysql_fetch_array($sqlt);
  $v=array();
  $v[0]=$rown['titulo'];
  $v[1]=$rown['descripcion'];
  $v[2]=$rown['codigo'];
  return $v;
}

function consulta_articulo($id_ca){
  $link1=Conectarse();
  $sql_art= mysql_query("SELECT cod_art FROM catalogo_reng where id_catalogo ='$id_ca'",$link1); 
   $co=array();
   $i=0;
   while($rown1= mysql_fetch_array($sql_art)){
   $co[$i]=$rown1['cod_art'];
 $i++;
  } 
  return $co;  
}

function fLeeImg ($RUTA)
  {
   $workDir=opendir('.');
	// recogemos las imagenes y armamos un vector
         while ($fichero = readdir($workDir))
           {
              if (($fichero != ".") && ($fichero != ".."))
              $imagenes[]=$fichero;   
           }
    // cerramos el directorio
         closedir($workDir);
         return($imagenes);
  }

function consulta_flag($fl){
  $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
  $flag= mysqli_fetch_array($sqfl);
  $flr=array();
  $flr[0]=$flag['Flag'];
  $flr[1]=$flag['FlagDesc'];
  $flr[2]=$flag['FlagActive'];
  if ($flr[2]==0){
   $eti='';
  }
  elseif($flr[2]==1){
  $eti=$flr[1];
  }
  return $eti; 
}

/*
function consulta_categoria($id_cat){
  $sqc = mysqli_query($link, "SELECT * FROM `codes cat` WHERE CatCode =$id_cat");
  $catego= mysqli_fetch_array($sqc);
  $ca=array();
  $ca[0]=$catego['CatCode'];
  $ca[1]=$catego['CatDesc'];
  return $ca;
}

function consulta_por_cliente($id){
  $link1=Conectarse();
  $sqlt= mysql_query("SELECT * FROM catalogo_reng where cod_art ='$id'",$link1); 
  $rown= mysql_fetch_array($sqlt);
  $v=array();
  $v[0]=$rown['precio'];
  $v[1]=$rown['oferta'];
  $v[2]=$rown['stock_ini'];
  return $v;
}*/

?>