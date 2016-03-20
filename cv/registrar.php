<?
session_start();

error_reporting(E_ALL);

@ini_set('display_errors', '1');

    
$nombre_ape=$_POST['nombre_ape'];
$tlf=$_POST['tlf'];
$comentario=$_POST['comentario'];
$email=$_POST['correo'];

if(isset($_SESSION['carro']))
$carro=$_SESSION['carro'];else $carro=false;

if(isset($_SESSION['formulario']))
$formulario=$_SESSION['formulario'];
$formulario=array('nombre_ape'=>$nombre_ape,'tlf'=>$tlf,'comentario'=>$comentario, 'correo'=>$email);

$_SESSION['formulario']=$formulario;

$encabezado = "\nX-Mailer: PHP/" . phpversion();
$encabezado = "MIME-Version: 1.0\n"; 
$encabezado .= "Content-type: text/html; charset=iso-8859-1\n"; 
$encabezado .= "From: $email"; //encabezado con el correo de quien lo envia 
$para = "lauramendez12@gmail.com";
$sujeto = utf8_decode("Contacto - Pedido en Línea (Envio de prueba)"); //sujeto del correo//sujeto del correo

$mensaje = 
       ' <div style="position: relative; padding-left: 70px; padding-right:10px; font: .90em arial, sans-serif;color:#000000;" >'
	   .'<div style="width:auto; height:auto;float:left;-moz-border-radius:10px; -webkit-border-radius:10px;
	border-radius:10px; position:relative; -webkit-backface-visibility:hidden; border:solid 2px #999999;
	margin-right: 3px; line-height: 1.2; padding:10px; background:#ffffff;">'
	   .'<img src="images/catalog_header.png" width="400" height="87" /><br><br>'
       .'A continuación el resumen del pedido <br><br>'
      
	    .'<table style="font: 100% arial, sans-serif;color:#000000"; width="350" border="1" cellpadding="1" cellspacing="0" bordercolor="#ECEBEB">'
 		.'<tr>'
  			.'<td width="350" height="35" bgcolor="#ECEBEB" > <b>Dirección de envío</b></td>'
  		.'</tr>'
		 .'<tr>'
  			.'<td width="350">'
			.$formulario['nombre_ape'].'<br>'
	   		.$formulario['tlf'].'<br>'
			.'<b>Comentarios:</b>'.$formulario['comentario'].'<br>'
		.'</td>'
  		.'</tr>'
		.'</table>'
		.'<br><br>'
		.'<table style="font: 100% arial, sans-serif;color:#000000"; width="768" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#999999">'
 		.'<tr>'
  			.'<td width="83"><div align="center">Producto</div></td>'
   			.'<td width="292" ><div align="center">Detalle</div></td>'
			.'<td width="107" ><div align="center">CANTIDAD </div></td>'  
			.'<td width="160"><div align="center">Precio</div></td>'
            .'<td width="115"><div align="center">Subtotal</div></td>'
  		.'</tr>';

  $total=0;
  $total_c=0;
  $total_t=0;
 	foreach($carro as $k => $v){
 		  	if(trim($v['imagen']) == ''){ $v['imagen']=  'default.jpg'; }
			$mensaje .= '<tr>'
			.'<td><div align="center"><img src="http://gibble.com.ve/curios/productos/'.$v['imagen'].'" width="70px" height="70px"></img></div></td>'
			.'<td>'.$v['nombre'].'</td>'
			.'<td ><div align="center">'.$v['cantidad'].'</div></td>';	
			if ($v['oferta']!=0){
   			$descu=$v['oferta'];
			 }else{$descu=$v['precio'];}
			$mensaje .='<td><div align="center">'.$descu.'</div></td>'
            .'<td width="169"><div align="center">'.$sub=$v['cantidad']*$descu.'</div></td>'
  		.'</tr>';
	
		$total_c= $total_c+ $v['cantidad'];
		$total= $total+$sub;
	} 
	$mensaje .= '<tr>'
		   .'<td colspan="3"></td>'
		   .'<td ><div align="right">Subtotal</div></td>'
		   .'<td ><div align="center">'.$total.'</div></td>'
		 .'</tr>';
	
	//$total_t= $total+$costo_envio;

    $mensaje .= '</table>'
.'</div>'
		.'</div>';
		
		


		
if(!mail($para, $sujeto, $mensaje, $encabezado))
{
   echo "<h1>No se pudo enviar el Mensaje</h1>";
   exit();
}
session_unset();

session_destroy();
echo utf8_decode("$mensaje");
header ("Location:gracias.php?sol=si");
?>
