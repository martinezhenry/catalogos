<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Textronic</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery1.min.js"></script>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<script src="js/jquery.easydropdown.js"></script>
</head>
<body> 
	
	     <? include('header.php');?>

         <div class="wrap">
     <div class="toogle">
         <? if($_GET["sol"]=="si"){?>
        
        <div class="gra" align="center">
          <h3 class="m_3">¡GRACIAS POR TU PEDIDO!</h3>
          <p class="m_text">Hemos recibido tu solicitud. En breve recibirás un correo con la confirmación de tu pedido.</p>
          <p class="m_text">Si tienes alguna duda, <a href="http://textronic.info/landingtex/">contáctanos</a>.</p>
        </div>
        <? } else{?>
		   <div class="gra" align="center">
           <h3 class="m_3">DISCULPE</h3>
          <p class="m_text">No se pudo enviar su pedido</p>
          <p class="m_text">Si tienes alguna duda, <a href="http://textronic.info/landingtex/">contáctanos</a>.</p>
        </div>
		<?  ;}	  
		   ?>

     </div>
       </div>
       
    <? include('footer.php');?>
</body>
</html>