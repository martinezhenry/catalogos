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
<link href="css/form.css" rel="stylesheet" type="text/css" media="all" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" />
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
      <? include('header.php');?>
 <? 

include('funciones.php'); 

$id = $_REQUEST['id'];
$id_ca = $_REQUEST['id_ca'];
$q = mysqli_query($link, "SELECT * FROM g_inventory WHERE SkuNo = $id");
$p = mysqli_fetch_array($q);
$id_cat=$p['CatCode']; 
$id_scat=$p['PrdCode'];
$stock=$p['OnHand'];
$precio=56;



  
  /*CATEGORIA DEL PRODUCTO*/
  $sqc = mysqli_query($link, "SELECT * FROM `codes cat` WHERE CatCode =$id_cat");
  $catego= mysqli_fetch_array($sqc);
  $categoria=$catego['CatCode'];
  $desc_cat=$catego['CatDesc'];
  
    /*SUB-CATEGORIA DEL PRODUCTO
  $sqsub = mysqli_query($link, "SELECT * FROM `codes catsub` WHERE PrdCode =$id_scat");
  $sub_cat= mysqli_fetch_array($sqsub);
  $subcate=$sub_cat['PrdCode'];
  $desc_subcat=$sub_cat['PrdDesc'];*/
  ?>

<div class="mens">    
  <div class="main">
     <div class="wrap">
     	<ul class="breadcrumb breadcrumb__t"><a class="home" href="index.php">Home</a> / <a href="#"><? echo $desc_cat;?></a> / <?php echo $p['ProdDesc'];?></ul>
		<div class="cont span_2_of_3">
        
		  	<div class="grid images_3_of_2">
            
						<div id="container">
                        
							<div id="products_example">

								<div id="products">
                                
	<? 
  $storage_dir="articulos/$id/peque/";
  $storage_dirt="articulos/$id/grande/";

  if (file_exists($storage_dir)) {?>								
                                    
  <div class="slides_container" align="center">
		<a href="#"><img class="a" id="img1" src="images/imagen_no_disponible.jpg" alt="" rel="images/imagen_no_disponible.jpg" /></a>
</div>
  
 <?
      chdir($storage_dir);
	 // echo "El fichero $nombre_fichero existe";

	  $imgs = fLeeImg($storage_dir); // definimos un vector de imagenes pequeñas
  $imga = fLeeImg($storage_dirt); // definimos un vector de imagenes grandes 
  $numero=count($imgs)-1;
 
	$mostrar=0; $i=0; $j=0;
    while($i<=$numero) //15 son las 15 imagenes (0...15) que se muestran por pagina
  	{
	$imagen = $imgs[$i]; 
	$imageG = $imga[$i]; 
    $dimag="$storage_dir$imageG";			
    $dimap="$storage_dirt$imagen";	
	?>
	<ul class="pagination">
		<li><a href="#"><img src="<?  echo "$dimap"?>" width="s-img" alt="2x"></a></li>
				
   <? $i++; 
   $j++;
  // echo " </td>";
	if ($j==3){?>
		<div class="clear"></div>	
       </ul>
		<? $j=0;
		}
	}//FIN WHILE
    //echo "El fichero $nombre_fichero no existe";

   /* if ($numero<0){*/
	
	
	  } else {?> 
   <div class="slides_container" align="center">
		<a href="#"><img class="a" id="img1" src="images/imagen_no_disponible.jpg" alt="" rel="images/imagen_no_disponible.jpg" /></a>
</div>
                                    <ul class="pagination">
		<li><?  echo "El artículo no tiene imagen";// si no esta la imagen?></li>
	    <div class="clear"></div>	
    </ul>
	
 <? }//FIN IF
  
?>
							
							
                           	</div>
                          </div>
                     </div>
                 </div>
		         <div class="desc1 span_3_of_2">
		         	<h3 class="m_3"><?php echo $p['ProdDesc'];?></h3>
		             <p class="m_5">  <? 
					   $ofe = mysqli_query($link, "SELECT precio,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma
FROM `ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId
WHERE SkuNo = '$id'
ORDER BY b.Date_To DESC");
  $oferta= mysqli_fetch_array($ofe);
  $promo=$oferta[0];
   if ($promo!=NULL)
{ ?> OFERTA: <? echo round($promo, 2);?> <span class="reducedfrom"><?php echo $precio;?></span><? }else{?>
 <p class="m_5">PRECIO: <?php echo $precio;?>
<? } ?>
 </p>
                      <p class="m_5">Disponibilidad: <?php echo $stock;?> <br>
                     
                      
                     
                      </p>
		         	 <div class="btn_form">
                   		<form name="Precio sugerido" id="Precio sugerido"  method="post" action="agregacar.php?<?php echo SID ?>&id=<?php echo $id ?>">
							<label> Precio Sugerido
							<input type="text" name="precio_su" id="precio_su">
							</label>
                            <br><br>
<label> Cantidad
							<input type="text" name="cantidad" id="cantidad">
							</label>
                            <br><br>
                          <? if ($stock!=0){?>
                          <input type="submit" value="Cargar" title="">
                           <? }else {?> <p class="disponibilidad"> <? echo "Seleccione un artículo que tenga existencia";} ?></p>
					   </form>
				   </div>
					<!--<span class="m_link"><a href="#">login to save in wishlist</a> </span>
				     <p class="m_text2">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit </p>-->
			     </div>
			   <div class="clear"></div>	
	    <div class="clients">
	    <h3 class="m_3">Other Products in the  category <? echo " $desc_cat ";?></h3>
		 <ul id="flexiselDemo3">
			<? 
$catego = mysqli_query($link, "SELECT *FROM g_inventory WHERE CatCode= $id_cat LIMIT 0,10");
WHILE ($ct = mysqli_fetch_array($catego)) {
  $codigo=$ct['SkuNo']; 
$d_articulo=$ct['PrdCode'];

$imagen="articulos/$codigo/peque/1.jpg";
?>
            
            <li><img src="<? echo $imagen;?>" /><a href="#"><? echo   $codigo;?></a><p><? echo $d_articulo;?></p></li>
	<? }?>		
		 </ul>
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
     <div class="toogle">
     	<h3 class="m_3">Product Details</h3>
     	<p class="m_text">Colocar detalles del producto</p>
     </div>
     <div class="toogle">
     	<h3 class="m_3">More Information</h3>
     	<p class="m_text">Alguna información adicional del producto</p>
     </div>
      </div>
			<div class="clear"></div>
           </div>
			 
		   
           </div>
		<? include('footer.php');?>	
        </div>

</body>
</html>