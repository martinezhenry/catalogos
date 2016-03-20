<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
include 'general.php';
$valido = '1';
$id_catalogo = $_SESSION["cod_cat"];
if(isset($id_catalogo)){
    if(is_numeric($id_catalogo)){
        $obj_function = new coFunction();
        $obj_bdmysql = new coBdmysql();
        $mysqli = new mysqli('localhost','root','admin','textronic_y');
        if (!$mysqli->connect_error){
            //VERIFICA SI EXISTE EL CATALOGO
            if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
                
                //EXTRAE LOS DATOS DEL CATALOGO
                $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul; }
                $codigo = $resul[0]['codigo'];
                $fecha = $resul[0]['fe_us_in_dmy'];
                $titulo = $resul[0]['titulo'];
                
                //EXTRAE LOS ARTICULOS
                $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul_art)){ $mss_art = 'NO SE ENCONTRARON ARTICULOS EN EL CATALOGO. '; }                
            }else{ $valido = '0'; }
        }else{ $valido = '0'; }
    }else{ $valido = '0'; }
}else{ $valido = '0'; }
?><? include('conex_1.php');
include('funciones.php');
 ?>
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
<script type="text/javascript" src="js/jquery1.min.js"></script>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!--start slider -->
    <link rel="stylesheet" href="css/fwslider.css" media="all">
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/css3-mediaqueries.js"></script>
    <script src="js/fwslider.js"></script>
<!--end slider -->
<script src="js/jquery.easydropdown.js"></script>
</head>
<body>
    <? include('header.php');?>
  <!-- start slider -->
    <div id="fwslider">
        <div class="slider_container">
            <div class="slide"> 
                <!-- Slide image -->
                    <img src="images/banner_01.jpg" alt=""/>
                <!-- /Slide image -->
                <!-- Texts container -->
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <!-- Text title -->
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <!-- /Text title -->
                        
                        <!-- Text description -->
                        <p class="description">Experiance </p>
                        <!-- /Text description -->
                    </div>
                </div>
                 <!-- /Texts container -->
            </div>
            <!-- /Duplicate to create more slides -->
            <div class="slide">
                <img src="images/banner_02.jpg" alt="" />
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply </h4>
                        <p class="description">diam nonummy nibh euismod</p>
                    </div>
                </div>
            </div>
            <!--/slide -->
        </div>
        <div class="timers"></div>
        <div class="slidePrev"><span></span></div>
        <div class="slideNext"><span></span></div>
    </div>
    <!--/slider -->
<div class="main">
	<div class="wrap">
		<div class="section group">
		  <div class="cont span_2_of_3">
		  	<h2 class="head"><? ECHO  $titulo;?></h2>
<?php

$url = "init.php";

   $co=consulta_articulo($id_catalogo);
// print_r($co);
 $contar_cat=count($co); //total de registros
// echo $contar_cat;


  $j=0;
 // $cu=variant_fix($contar_cat/4);
  $num_total_registros= $contar_cat;
	
	
	//Si hay registros
if ($num_total_registros > 0) {
	//Limito la busqueda
	$TAMANO_PAGINA = 12;
        $pagina = false;

	//examino la pagina a mostrar y el inicio del registro a mostrar
        if (isset($_GET["pagina"]))
            $pagina = $_GET["pagina"];
        
	if (!$pagina) {
		$inicio = 0;
		$pagina = 1;
	}
	else {
		$inicio = ($pagina - 1) * $TAMANO_PAGINA;
	}
	//calculo el total de paginas
	$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);

	
   // while ($j<$contar_cat){ //inicio del while
//	$q = mysqli_query($link, "SELECT * FROM `g_inventory` where SkuNo='$co[$j]' LIMIT ".$inicio."," . $TAMANO_PAGINA);
	$q = mysqli_query($link, "SELECT * FROM `g_inventory` LIMIT ".$inicio."," . $TAMANO_PAGINA);

    $i=0;
	$h=0;
	if($q){
		while($r = mysqli_fetch_array($q)){ // INICIO DEL WHILE
	//	while($r = mysql_fetch_assoc($q)){
		$codigo=$r['SkuNo'];?>
            
            
			<div class="top-box">
                            <!--FILA 1-->
                            <div class="col_1_of_3 span_1_of_3"> 
                                 <? echo'<a href="single.php?id='.$r['SkuNo'].'">' ?>
                                    <div class="inner_content clearfix">
                                        <div class="product_image">
                                            <img src="images/pic.jpg" alt=""/>					
                                        </div>
                                    <div class="sale-box"></div>	
                                    <div class="price">
                                        <div class="cart-left">
                                        <p class="title"><? echo substr($r['ProdDesc'],0,30);?></p>

                                            <div class="price1">
                                            
                                            <? //BUSCAR EL PRECIO POR CLIENTE
	
	$pre = mysqli_query($link, "SELECT 	Inv.SkuNo,Inv.PartNo,Inv.ProdName, InvPri.CurPrice 
FROM 	autodatasystem.`Inventory` AS Inv INNER JOIN 
		autodatasystem.`Inventory Pricing`  AS InvPri ON InvPri.Skuno = Inv.Skuno INNER JOIN
        autodatasystem.`Customers BillPrCol` AS BillPrCol ON BillPrCol.PriceColumn = InvPri.PriceColumn
WHERE 	(inv.Discontinued = false) AND (BillPrCol.CustID ='001') AND (Inv.SkuNo = '$codigo')");
  $p_cliente= mysqli_fetch_array($pre);
  $precio=$p_cliente[0];


			   /**/
			    ?><span class="actual"> <? echo' <span class="actual">Bs. '. $precio.'</span>' ?></span>
                                            </div>
                                        </div>
                                        <div class="cart-right"> </div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                                </a>
                            </div>
                           <? $i=$i+1;
//while ($h>$cu){
if ($i==4){?>				
<div class="clear"></div>	
  <? $i=0;}?> 
  <? //}
  $h++;?>
  <? // } //FIN DEL WHILE?>
 <? // }else{ echo mysqli_error();
  }
 
 ?>
  
 <?
$j++;} //FIN DEL while ;

?>
                       </div>	
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="pagination">
                
               <?php
       	
		 if ($total_paginas > 1) {
		if ($pagina != 1)
			echo '<a href="'.$url.'?pagina='.($pagina-1).'"><<</a>';
		for ($i=1;$i<=$total_paginas;$i++) {
			if ($pagina == $i)
				//si muestro el ï¿½ndice de la pï¿½gina actual, no coloco enlace
				echo $pagina;
			else
				//si el ï¿½ndice no corresponde con la pï¿½gina mostrada actualmente,
				//coloco el enlace para ir a esa pï¿½gina
				echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
		}
			
		if ($pagina != $total_paginas)
			echo '<a href="'.$url.'?pagina='.($pagina+1).'">
			>></a>';
	}
      /*   $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
         $links = array();
         for( $i=1; $i<=  $total_paginas ; $i++)
         {
            $links[] = "<a href=\"?pag=$i\">$i</a>"; 
         }
         echo implode(" - ", $links);*/
   
	
}
      ?>
               
							
                    </div><!--paginación-->
            </div>
            <!--IIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII
            IIIIIIIIIIIIIIIIIIIIIIIIIIII  SALES  IIIIIIIIIIIIIIIIIIIIIIIIIIIIII
            IIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII-->
            <div style="width:100%;background:#FFF09E;padding:2% 0%;border-top: 1px solid #9f9f9f;">
                <div class="wrap">
                    <h2 class="head">TOP SALES</h2>
                    <div class="top-box1">
                        <div class="col_1_of_3 span_1_of_3"> 
                            <a href="single.html">
                                <div class="inner_content clearfix">
                                    <div class="product_image">
                                        <img src="images/pic.jpg" alt=""/>					
                                    </div>
                                    <div class="sale-box1"><span class="on_sale title_shop">Sale</span></div>
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title">Lorem Ipsum simply</p>
                                            <div class="price1">
                                                <span class="actual">$12.00</span>
                                            </div>
                                        </div>
                                        <div class="cart-right"> </div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                            </a>
                        </div>
                        <div class="col_1_of_3 span_1_of_3">
                            <a href="single.html">
                                <div class="inner_content clearfix">
                                    <div class="product_image">
                                        <img src="images/pic1.jpg" alt=""/>
                                    </div>
                                    <div class="sale-box1"><span class="on_sale title_shop">Sale</span></div>
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title">Lorem Ipsum simply</p>
                                            <div class="price1">
                                                <span class="actual">$12.00</span>
                                            </div>
                                        </div>
                                        <div class="cart-right"></div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                            </a>
                        </div>
                        <div class="col_1_of_3 span_1_of_3">
                            <a href="single.html">
                                <div class="inner_content clearfix">
                                    <div class="product_image">
                                        <img src="images/pic2.jpg" alt=""/>
                                    </div>
                                    <div class="sale-box1"><span class="on_sale title_shop">Sale</span></div>	
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title">Lorem Ipsum simply</p>
                                            <div class="price1">
                                                <span class="reducedfrom">$66.00</span>
                                                <span class="actual">$12.00</span>
                                            </div>
                                        </div>
                                        <div class="cart-right"> </div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                            </a>
                        </div>
                        <div class="col_1_of_3 span_1_of_3">
                            <a href="single.html">
                                <div class="inner_content clearfix">
                                    <div class="product_image">
                                        <img src="images/pic2.jpg" alt=""/>
                                    </div>
                                    <div class="sale-box1"><span class="on_sale title_shop">Sale</span></div>
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title">Lorem Ipsum simply</p>
                                            <div class="price1">
                                                <span class="reducedfrom">$66.00</span>
                                                <span class="actual">$12.00</span>
                                            </div>
                                        </div>
                                        <div class="cart-right"> </div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                            </a>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
	</div>
                <? include('footer.php');?>

</body>
</html>
