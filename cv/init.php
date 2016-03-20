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
        $mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DBNOM);
//        $mysqli = new mysqli('localhost','root','admin','textronic_y');
        if (!$mysqli->connect_error){
            //VERIFICA SI EXISTE EL CATALOGO
            if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
                
                //EXTRAE LOS DATOS DEL CATALOGO
                $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy,(SELECT order_art FROM catalogo_order WHERE id = order_id) order_art","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul; }
                $codigo = $resul[0]['codigo'];
                $fecha = $resul[0]['fe_us_in_dmy'];
                $titulo = $resul[0]['titulo'];
                $order_art = $resul[0]['order_art'];
                
                //EXTRAE LOS ARTICULOS
                $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'",$order_art,"",$mysqli);
                if(!is_array($resul_art)){ $mss_art = 'NO SE ENCONTRARON ARTICULOS EN EL CATALOGO. '; }                
            }else{ $valido = '0'; }
        }else{ $valido = '0'; }
    }else{ $valido = '0'; }
}else{ $valido = '0'; }
?>
<?php include('conex_1.php');
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
    <?php include('header.php');?>
    <!-- start slider -->
    <div id="fwslider">
        <div class="slider_container">
            <div class="slide">
                <img src="images/banner/1.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <img src="images/banner/2.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <img src="images/banner/3.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <img src="images/banner/4.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <img src="images/banner/5.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
                    </div>
                </div>
            </div>
            <div class="slide">
                <img src="images/banner/6.jpg" alt=""/>
                <div class="slide_content">
                    <div class="slide_content_wrap">
                        <h4 class="title">Lorem Ipsum simply Club</h4>
                        <p class="description">Experiance </p>
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
		  	<h2 class="head"><?php echo  $titulo;?></h2>
			<div class="top-box">
                <?php

 $url = "init.php";

 $co=consulta_articulo($id_catalogo);
 $id_ca=$id_catalogo;
 $contar_cat=count($co); //total de registros
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

   $link1=Conectarse();
   $sqlarti= mysql_query("SELECT cod_art FROM catalogo_reng where id_catalogo ='$id_ca' LIMIT ".$inicio."," . $TAMANO_PAGINA, $link1); 
   
   while($rown1= mysql_fetch_array($sqlarti)){
        $cod_arti=$rown1['cod_art'];	
        $q = mysqli_query($link, "SELECT * FROM `g_inventory` WHERE SkuNo='$cod_arti'");

        $i=0;
	$h=0;
	if($q){
	$r = mysqli_fetch_array($q);
	$codigo=$r['SkuNo'];
	$eti='';
        
        //IMAGEN ARTICULO
        $image_art= "../assets/img/art/".$codigo.".jpg";
        if(!file_exists($image_art)){ $image_art= "../assets/img/art/def.jpg"; }
        
        //BUSCAR EL PRECIO POR CLIENTE
	
//	$pre = mysqli_query($link, "SELECT 	Inv.SkuNo,Inv.PartNo as PartNo,Inv.ProdName, InvPri.CurPrice 
//        FROM 	autodatasystem.`Inventory` AS Inv INNER JOIN 
//		autodatasystem.`Inventory Pricing`  AS InvPri ON InvPri.Skuno = Inv.Skuno INNER JOIN
//        autodatasystem.`Customers BillPrCol` AS BillPrCol ON BillPrCol.PriceColumn = InvPri.PriceColumn
//        WHERE 	(inv.Discontinued = false) AND (BillPrCol.CustID ='001') AND (Inv.SkuNo = '$codigo')");
        $where ="WHERE SkuNo = '".$codigo."'";
        $campos = "*,'00/00/0000' as fe_oferta_dmy,(SELECT CatDesc FROM `codes cat` WHERE `codes cat`.CatCode = g_inventory.CatCode) as CatDesc, (SELECT PrdDesc FROM `codes catsub` WHERE `codes catsub`.PrdCode = g_inventory.PrdCode) as PrdDesc";
//        $resul = $obj_bdmysql->select("g_inventory", $campos, $where, "ProdDesc"
        $pre = mysqli_query($link,"SELECT ".$campos." FROM g_inventory ".$where." ORDER BY ProdDesc");
        $p_cliente= mysqli_fetch_array($pre);
//        $precio=$p_cliente[''];
        $precio = '';
        $PartNo = $p_cliente['PartNo'];
	?>        
                         
                            <div class="col_1_of_3 span_1_of_3"> 
                                    <?php echo'<a href="single.php?id='.$r['SkuNo'].'">' ?>
                                    <div class="inner_content clearfix">
                                        <div class="product_image">
                                            <!--<img src="images/pic.jpg" alt=""/>-->					
                                            <img src="<?php echo $image_art;?>" alt="<?php echo $PartNo;?>" style="width:250px;height:230px;"/>					
                                        </div>
                                    <div class="sale-box"></div>	
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title_cod"><?php echo $PartNo;?></p>
                                            <p class="title" style="height:50px;"><?php echo substr($r['ProdDesc'],0,28);?></p>
                                            <div class="price1">
                                            <span class="actual"> <?php echo' <span class="actual">Bs. '. $precio.'</span>' ?></span>
                                            <div style="margin-top:10px;">
    <?php /*echo $r['Flag01']; echo	$r['Flag02']; echo	$r['Flag03']; echo	$r['Flag04'];  echo	$r['Flag05']; echo $r['Flag06']; echo $r['Flag07']; echo $r['Flag08'];
	echo $r['Flag09'];
	echo $r['Flag10']; */?>
    <!--<span>-->
    <?php 
									//  echo $fl1;
									  if ($r['Flag01']==1){ 
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
                                                <img src="images/Universal Binary.png" alt="<?php echo "$eti";?>"><?php 									 										}
									 }
									
 									 if ($r['Flag02']=='1'){$fl='Flag02';// echo "entro al 2do if ";
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
                                                <img src="images/Blue Ball.png" alt="<?php echo "$eti2";?>"><?php 									 										}
									 }
									if ($r['Flag03']=='1'){$fl='Flag03';// echo "entro al 2do if ";
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
                                                <img src="images/Green Ball.png" alt="<?php echo "$eti3";?>"><?php 									 										}
									 }
									
									if ($r['Flag04']=='1'){$fl='Flag04';// echo "entro al 2do if ";
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
                                                <img src="images/Grey Ball.png" alt="<?php echo "$eti4";?>"><?php 									 										}
									 }
									 
									 if ($r['Flag05']=='1'){$fl='Flag05';// echo "entro al 2do if ";
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
                                                <img src="images/Orange Ball.png" alt="<?php echo "$eti5";?>"><?php 									 										}
									 }
									 
									 if ($r['Flag06']=='1'){$fl='Flag06';// echo "entro al 2do if ";
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
                                                <img src="images/Purple Ball.png" alt="<?php echo "$eti6";?>"><?php 									 										}
									 }
									 
									 if ($r['Flag07']=='1'){$fl='Flag07';// echo "entro al 2do if ";
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
                                                <img src="images/Red Ball.png" alt="<?php echo "$eti7";?>"><?php 									 										}
									 }
									 
									 if ($r['Flag08']=='1'){$fl='Flag08';// echo "entro al 2do if ";
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
                                                <img src="images/Yellow Ball.png" alt="<?php echo "$eti8";?>"><?php 									 										}
									 }	
										
									if ($r['Flag09']=='1'){$fl='Flag09';// echo "entro al 2do if ";
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
                                                <img src="images/Brown Ball.png" alt="<?php echo "$eti9";?>"><?php 									 										}
									 }	
										if ($r['Flag10']=='1'){$fl='Flag10';// echo "entro al 2do if ";
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
                                                <img src="images/Black Ball.png" alt="<?php echo "$eti10";?>"><?php 									 										}
									 }	
									 ?>
                                            <!--</span>-->
                                            </div>
                                        </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>				
                                </div>
                                </a>
                            </div>
                            
      <?php $i=$i+1;
//while ($h>$cu){
if ($i==4){?>				
<div class="clear"></div>	
  <?php $i=0;} 
  $h++; ?>
 
 <?php
  }
 } //FIN DEL while ;

?>                       
                            
       </div>	
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="wrap">
                <div class="pagination">
                   <?php
                    if ($total_paginas > 1) {
                        if ($pagina != 1)
                            echo '<a href="'.$url.'?pagina='.($pagina-1).'"><<</a>';
                        for ($i=1;$i<=$total_paginas;$i++) {
                            if ($pagina == $i)
                                echo '  <span>'.$pagina.'</span>';
                            else
                                echo '  <a href="'.$url.'?pagina='.$i.'">'.$i.'</a>  ';
                        }	
                        if ($pagina != $total_paginas)
                            echo '<a href="'.$url.'?pagina='.($pagina+1).'">>></a>';
                    }
                    ?>
                </div><!--paginación-->
            </div>
<?php
}
?>		
            <!--IIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII
            IIIIIIIIIIIIIIIIIIIIIIIIIIII  SALES  IIIIIIIIIIIIIIIIIIIIIIIIIIIIII
            IIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII-->
            <div style="width:100%;background:#FFF09E;padding:2% 0%;border-top: 1px solid #9f9f9f;display:none;">
                <div class="wrap">
                    <h2 class="head">TOP SALES</h2>
                    <div class="top-box1">
                       <?php
                        $link1=Conectarse();
                        $sqltop= mysql_query("SELECT cod_art FROM catalogo_reng where id_catalogo ='$id_ca' LIMIT 0,4", $link1);
                        while($rownt= mysql_fetch_array($sqltop)){
                        $cod_ar=$rownt['cod_art'];	
                         $q2 = mysqli_query($link, "SELECT * FROM `g_inventory` WHERE SkuNo='$cod_ar'");
                         if($q2){
                             $r2 = mysqli_fetch_array($q2);
                             $codigo=$r2['SkuNo'];
                        ?>
                        <div class="col_1_of_3 span_1_of_3"> 
                        <a href="single.php?id=<?php echo $codigo;?>">
                            <div class="inner_content clearfix">
                                <div class="product_image">
                                    <img src="images/pic.jpg" alt=""/>					
                                </div>
                                <div class="sale-box"></div>	
                                <div class="price">
                                    <div class="cart-left">
                                        <p class="title"><?php echo substr($r2['ProdDesc'],0,30);?></p>
                                        <div class="price1">    
                                            <?php //BUSCAR EL PRECIO POR CLIENTE
                                            $pre = mysqli_query($link1, "
                                                SELECT  Inv.SkuNo,Inv.PartNo,Inv.ProdName, InvPri.CurPrice 
                                                FROM    autodatasystem.`Inventory` AS Inv INNER JOIN 
                                                        autodatasystem.`Inventory Pricing`  AS InvPri ON InvPri.Skuno = Inv.Skuno INNER JOIN
                                                        autodatasystem.`Customers BillPrCol` AS BillPrCol ON BillPrCol.PriceColumn = InvPri.PriceColumn
                                                WHERE   (inv.Discontinued = false) AND (BillPrCol.CustID ='001') AND (Inv.SkuNo = '$codigo')");
                                              $p_cliente= mysqli_fetch_array($pre);
                                              $precio=$p_cliente[0]; ?>
                                            <span class="actual"> <?php echo' <span class="actual">Bs. '. $precio.'</span>' ?></span>
                                        </div>
                                    </div>   
                                    <div class="clear"></div>
                                </div>				
                            </div>
                        </a>
                        </div>
                          
 <?php
 }
 } //FIN DEL while ;

?>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div><!--FIN DIV FONDO-->
	</div>
   <?php include('footer.php');?>
</body>
</html>