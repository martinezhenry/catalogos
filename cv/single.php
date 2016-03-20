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
<?php include('header.php');?>
<?php 

include('funciones.php'); 

$id = $_REQUEST['id'];
$id_ca = $_REQUEST['id_ca'];
$q = mysqli_query($link, "SELECT * FROM g_inventory WHERE SkuNo = $id");
$p = mysqli_fetch_array($q);
$id_cat=$p['CatCode']; 
$id_scat=$p['PrdCode'];
$stock=$p['OnHand'];
$codigo=$p['SkuNo'];
$des_articulo=$p['ProdDesc'];
$nro_articulo=$p['PartNo'];
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
     	<ul class="breadcrumb breadcrumb__t"><a class="home" href="init.php">Home</a> / <a href="#"><?php echo $desc_cat;?></a> / <?php echo $p['ProdDesc'];?>
   	   </ul>
		<div class="cont span_2_of_3">
        
		  	<div class="grid images_3_of_2">
            
						<div id="container">
                        
							<div id="products_example">

								<div id="products">
                                
                               
 
   <div class="slides_container" align="center">
   <?php 
   	$image_art= "../assets/img/art/".$codigo.".jpg";
	if(!file_exists($image_art)){
	$image_art= "../assets/img/art/def.jpg";
	$mensaje="El artículo no tiene imagen";
	 }
   ?>
		<a href="#"><img class="a" id="img1" src="<?php echo " $image_art";?>" alt="" rel="<?php echo " $image_art";?>" /></a>

    </div>
 	<ul class="pagination">
		<li><a href="#"><img src="<?php echo " $image_art";?>" width="<?php echo " $image_art";?>" alt="2x"> </a></li>
		<div class="clear"></div>	
       </ul>
								</div>
							</div>
						</div>
	            </div>
		         <div class="desc1 span_3_of_2">
		         	<h3 class="m_3"><?php echo $p['ProdDesc'];?></h3>
                    
                      <?php 
									//  echo $fl1;
									  if ($p['Flag01']==1){ 
									    $fl='Flag01';
										//echo "entro al primero if ";
										 $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti=$flr[1];
 										 }
									    if ($eti!=NULL){?> 
                                        <img src="images/Universal Binary.png" alt="<?php echo "$eti";?>"><?php 									 										echo "$eti";
										}
									 }
									
 									 if ($p['Flag02']=='1'){$fl='Flag02';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti2= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti2=$flr[1];
 										 }  
										 if ($eti2!=NULL){?> 
                                        <img src="images/Blue Ball.png" alt="<?php echo "$eti2";?>"><?php 									 										echo "$eti2";
										}
									 }
									if ($p['Flag03']=='1'){$fl='Flag03';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti3= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti3=$flr[1];
 										 }  
										 if ($eti3!=NULL){?> 
                                        <img src="images/Green Ball.png" alt="<?php echo "$eti3";?>"><?php 									 										echo "$eti3";
										}
									 }
									
									if ($p['Flag04']=='1'){$fl='Flag04';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti4= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti4=$flr[1];
 										 }  
										 if ($eti4!=NULL){?> 
                                        <img src="images/Grey Ball.png" alt="<?php echo "$eti4";?>"><?php 									 										echo "$eti4";
										}
									 }
									 
									 if ($p['Flag05']=='1'){$fl='Flag05';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti5= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti5=$flr[1];
 										 }  
										 if ($eti5!=NULL){?> 
                                        <img src="images/Orange Ball.png" alt="<?php echo "$eti5";?>"><?php 									 										echo "$eti5";
										}
									 }
									 
									 if ($p['Flag06']=='1'){$fl='Flag06';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti6= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti6=$flr[1];
 										 }  
										 if ($eti6!=NULL){?> 
                                        <img src="images/Purple Ball.png" alt="<?php echo "$eti6";?>"><?php 									 										echo "$eti6";
										}
									 }
									 
									 if ($p['Flag07']=='1'){$fl='Flag07';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti7= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti7=$flr[1];
 										 }  
										 if ($eti7!=NULL){?> 
                                        <img src="images/Red Ball.png" alt="<?php echo "$eti7";?>"><?php 									 										echo "$eti7";
										}
									 }
									 
									 if ($p['Flag08']=='1'){$fl='Flag08';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti8= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti8=$flr[1];
 										 }  
										 if ($eti8!=NULL){?> 
                                        <img src="images/Yellow Ball.png" alt="<?php echo "$eti8";?>"><?php 									 										echo "$eti8";
										}
									 }	
										
									if ($p['Flag09']=='1'){$fl='Flag09';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti9= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti9=$flr[1];
 										 }  
										 if ($eti9!=NULL){?> 
                                        <img src="images/Brown Ball.png" alt="<?php echo "$eti9";?>"><?php 									 										echo "$eti9";
										}
									 }	
										if ($p['Flag10']=='1'){$fl='Flag10';// echo "entro al 2do if ";
									     $sqfl = mysqli_query($link, "SELECT * FROM `codes flag` WHERE Flag ='$fl'");
 										 $flag= mysqli_fetch_array($sqfl);
  										$flr=array();
 										 $flr[0]=$flag['Flag'];
 										 $flr[1]=$flag['FlagDesc'];
										 $flr[2]=$flag['FlagActive'];
  										if ($flr[2]==0){
 										  $eti10= '';
  										}
 										 elseif($flr[2]==1){
 										 $eti10=$flr[1];
 										 }  
										 if ($eti10!=NULL){?> 
                                        <img src="images/Black Ball.png" alt="<?php echo "$eti10";?>"><?php 									 										echo "$eti10";
										}
									 }	
									 ?>
                    
		             <p class="m_5">  <?php 
					   $ofe = mysqli_query($link, "SELECT precio,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma
FROM `ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId
WHERE SkuNo = '$id'
ORDER BY b.Date_To DESC");
  $oferta= mysqli_fetch_array($ofe);
  $promo=$oferta[0];
   if ($promo!=NULL)
{ ?> OFERTA: <?php echo round($promo, 2);?> <span class="reducedfrom"><?php echo $precio;?></span><?php }else{?>
 <p class="m_5">PRECIO: <?php echo $precio;?>
<?php } ?>
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
                          <?php if ($stock!=0){?>
                          <input type="submit" value="Cargar" title="">
                           <?php }else {?> <p class="disponibilidad"> <?php echo "Seleccione un artículo que tenga existencia";} ?></p>
					   </form>
				   </div>
					<!--<span class="m_link"><a href="#">login to save in wishlist</a> </span>
				     <p class="m_text2">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit </p>-->
			     </div>
			   <div class="clear"></div>	
	    <div class="clients">
	    <h3 class="m_3">Other Products in the  category <?php echo " $desc_cat ";?></h3>
		 <ul id="flexiselDemo3">
			<?php 
$catego = mysqli_query($link, "SELECT *FROM g_inventory WHERE CatCode= $id_cat LIMIT 0,10");
WHILE ($ct = mysqli_fetch_array($catego)) {
$codigo=$ct['SkuNo'];
$PartNo=$ct['PartNo'];
//$d_articulo=$ct['PrdCode'];
$d_articulo=substr($ct['ProdDesc'],0,28);




?>
  <?php 
   	$image_art2= "../assets/img/art/".$codigo.".jpg";
	if(!file_exists($image_art2)){
	$image_art2= "../assets/img/art/def.jpg";
	$mensaje="El artículo no tiene imagen";
	 }
   ?>
            
            <li><a href="single.php?id=<?php echo $codigo;?>">
                <img src="<?php echo " $image_art2";?>" style="width:130px;height:120px;"/>
                <!--<p><?php echo $PartNo;?></p>-->
                <div style="height:150px;"><?php echo $d_articulo;?></div>
            </a></li>
	<?php }?>		
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
     	<p class="m_text"><?php echo "$des_articulo";?></p>
     </div>
     <div class="toogle">
     	<h3 class="m_3">Number Part</h3>
     	<p class="m_text"><?php echo "$nro_articulo";?></p>
     </div>
      </div>
			<div class="clear"></div>
           </div>
			 
		   
           </div>
		<?php include('footer.php');?>	
        </div>

</body>
</html>