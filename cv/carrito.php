<?php 
//print_r($_REQUEST); 

session_start();

error_reporting(E_ALL);

@ini_set('display_errors', '1');

if(isset($_SESSION['carro']))

$carro=$_SESSION['carro'];else $carro=false;
?><!--A Design by W3layouts
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
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
<script src="js/jquery1.min.js"></script>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script>
<!-- start details -->
<script src="js/slides.min.jquery.js"></script>
   <script>
		$(function(){
			$('#products').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				effect: 'slide, fade',
				crossfade: true,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});
		});
	</script>
	<!-- start zoom -->
	<link rel="stylesheet" href="css/zoome-min.css" />
	<script type="text/javascript" src="js/zoome-e.js"></script>
	<script type="text/javascript">
		$(function(){
		$('#img1,#img2,#img3,#img4').zoome({showZoomState:true,magnifierSize:[250,250]});
	});
	</script>		
</head>
<body>
   <? 
include('header.php');
include('funciones.php'); 
  ?>
        <?php
   $contador=0;
   $suma=0;
   $total=0;
   $totales=0;
   $todo=0;

   if ($carro!=''){
   
   foreach($carro as $k => $vc){

   $subto=$vc['cantidad']*$vc['precio'];

   $suma=$suma+$contador;

   $contador++;
 
$id = $vc['id']; 
$q = mysqli_query($link, "SELECT * FROM g_inventory WHERE SkuNo = $id");
$p = mysqli_fetch_array($q);
$id_cat=$p['CatCode']; 
$id_scat=$p['PrdCode'];

   
  /*CATEGORIA DEL PRODUCTO*/
  $sqc = mysqli_query($link, "SELECT * FROM `codes cat` WHERE CatCode =$id_cat");
  $catego= mysqli_fetch_array($sqc);
  $categoria=$catego['CatCode'];
  $desc_cat=$catego['CatDesc'];
    ?>
<div class="mens">    
  <div class="main">
     <div class="wrap">
     	<ul class="breadcrumb breadcrumb__t"><a class="home" href="index2.php">Home</a> / <a href="#"><? echo $desc_cat;?></a> / Carrito de Compras</ul>
		<div class="cont span_2_of_3">
        <div> <!--CARRITO-->
     
        <table width="753" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr align="center" bgcolor="#FFFFFF">
            <th width="11" >&nbsp;</th>
            <th colspan="2" >Producto</th>
            <th width="106">CANTIDAD</th>
            <th width="160">PRECIO</th>
            <th width="115"><div align="right">Subtotal</div></th>
          </tr>    

          <form name="" method="post" action="agregacar.php?<?php echo SID ?>&id=<?php echo $id ?>" id="">
            <tr class="CSSTableGenerator">
              <td width="30" height="30"><label>
               <a href="borracar.php?<?php echo SID ?>&id=<?php echo $id ?>"><img src="images/eliminar.gif" width="30" height="30" align="middle"  alt="ELIMINAR" /></a> 
              </label></td> <? //if(trim($v['imagen']) == ''){ $v['imagen'] =  'default.jpg'; }?>
              <td width="83"><div align="center"><img src="images/imagen_no_disponible_p.png" width="70px" height="70px" align="middle" ></div></td>
              <td width="278" class="textos"><?php echo $vc['nombre'];?></td>
              <td><div align="center">
                <input name="cantidad" type="text" id="cantidad" value="<?php echo $vc['cantidad'] ?>" size="2" maxlength="3" />
                <input name="id" type="hidden" id="id" value="<?php $vc['id']?>" />
              </div></td>
              <td><div align="center"><?php echo $vc['precio'];?><br>
              <? if ($vc['precio_su']!=NULL){
			  		echo "Precio Sugerido\n"; 
					echo $vc['precio_su'] ;
			  }?>
              </div></td>
              <td ><div align="right"><?php echo $subto;?></div></td>
           
                <?php //$total= $total+ $v['cantidad'];
		        $totales= $subto+ $totales;
		  ?> 
                </tr> </form>
            <tr >
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td> </td>
              <td colspan="3"><div align="right"></div></td>
            </tr>
            <tr >
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
              <td colspan="3"><div align="right">SUBTOTAL: <?php echo $totales; ?> </div></td>
            </tr>
            <tr >
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr >
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td></td>
              <td colspan="3"><div class="submit">
                <div align="right"><a href="pedido.php">
                  <input type="submit" name="Button" class="button" value="Continuar pedido"/>
                  
                </a></div>
              </div></td>
            </tr>
        </table>
        </div>
        <? } }?>
        
		        
		  <div class="clear"></div>	
          <br>
          <br>
          
          
         
	    <div class="clients">
        
        
       
	    <h3 class="m_3">&nbsp;</h3>
		
	<script type="text/javascript">
		$(window).load(function() {
			$("#flexiselDemo1").flexisel();
			$("#flexiselDemo2").flexisel({
				enableResponsiveBreakpoints: true,
		    	responsiveBreakpoints: { 
		    		portrait: { 
		    			changePoint:480,
		    			visibleItems: 1
		    		}, 
		    		landscape: { 
		    			changePoint:640,
		    			visibleItems: 2
		    		},
		    		tablet: { 
		    			changePoint:768,
		    			visibleItems: 3
		    		}
		    	}
		    });
		
			$("#flexiselDemo3").flexisel({
				visibleItems: 5,
				animationSpeed: 1000,
				autoPlay: true,
				autoPlaySpeed: 3000,    		
				pauseOnHover: true,
				enableResponsiveBreakpoints: true,
		    	responsiveBreakpoints: { 
		    		portrait: { 
		    			changePoint:480,
		    			visibleItems: 1
		    		}, 
		    		landscape: { 
		    			changePoint:640,
		    			visibleItems: 2
		    		},
		    		tablet: { 
		    			changePoint:768,
		    			visibleItems: 3
		    		}
		    	}
		    });
		    
		});
	</script>
	<script type="text/javascript" src="js/jquery.flexisel.js"></script>
     </div>
     </div>
			<div class="clear"></div>
           </div>
			 <div class="clear"></div>
		   
           </div>
		
        </div>
	<? include('footer.php');?>
</body>
</html>