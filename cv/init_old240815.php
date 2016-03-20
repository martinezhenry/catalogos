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
        if (!$mysqli->connect_error){
            //VERIFICA SI EXISTE EL CATALOGO
            if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
                
                //EXTRAE LOS DATOS DEL CATALOGO
                $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul;
                }else{
                    $codigo = $resul[0]['codigo'];
                    $fecha = $resul[0]['fe_us_in_dmy'];
                    $titulo = $resul[0]['titulo'];

                    //EXTRAE LOS ARTICULOS
                    $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","10",$mysqli);
                }
            }else{ $valido = '0'; }
        }else{ $valido = '0'; }
    }else{ $valido = '0'; }
}else{ $valido = '0'; }
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
     <div class="header-top">
	   <div class="wrap"> 
                <div class="header-top-left">
                    <div class="info_catalog">
                        CATALOG: <?php echo $codigo;?>. <span>TITLE: <?php echo $titulo;?>. DATE: <?php echo $fecha;?></span>
                    </div>
                </div>
                <div class="cssmenu">
                    <ul>
                        <li class="active"><a href="http://www.textronic.us/">www.textronic.us</a></li> |
                        <li><a href="http://textronic.info/landingtex/">Contact Us</a></li>
                        <li><a href="stop_sesion.php"><div style="border-radius:4px;border: 1px #5f5f5f solid;padding:3px 5px">LOGOUT</div></a></li>
                    </ul>
                </div>
                <div class="clear"></div>
 		</div>
	</div>
	<div class="header-bottom">
	    <div class="wrap">
                <div class="header-bottom-left">
                    <div class="logo">
                        <a href="index.html"><img src="images/catalog_header.png" alt="TEXTRONIC"/></a>
                    </div>
                    <div class="menu">
	            <ul class="megamenu skyblue">
			<li class="active grid"><a href="index.html">Home</a></li>
                        <li><a class="color4" href="#">Categorías</a>
                            <div class="megapanel">
                                <div class="row">
                                    <div class="col1">
                                        <div class="h_nav">
                                            <ul>
                                                <li><a href="womens.html">Air and Fuel Delivery</a></li>
                                                <li><a href="womens.html">Electrical Charging and Starting</a></li>
                                                <li><a href="womens.html">Electrical Lighting and Body</a></li>
                                                <li><a href="womens.html">Emission Control</a></li>
                                                <li><a href="womens.html">Ignition</a></li>
                                                <li><a href="womens.html">Miscellaneous</a></li>
                                                <li><a href="womens.html">Tools and Equipment</a></li>
                                                <li><a href="womens.html">Wiper and Washer</a></li>
                                            </ul>
                                        </div>							
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    </div>
		</div>
	   <div class="header-bottom-right">
         <div class="search">	  
				<input type="text" name="s" class="textbox" value="Search" onFocus="this.value = '';" onBlur="if (this.value == '') {this.value = 'Search';}">
				<input type="submit" value="Subscribe" id="submit" name="submit">
				<div id="response"> </div>
		 </div>
	  <div class="tag-list">
	    <ul class="icon1 sub-icon1 profile_img">
			<li><a class="active-icon c1" href="#"> </a>
				<ul class="sub-icon1 list">
					<li><h3>sed diam nonummy</h3><a href=""></a></li>
					<li><p>Lorem ipsum dolor sit amet, consectetuer  <a href="">adipiscing elit, sed diam</a></p></li>
				</ul>
			</li>
		</ul>
	    <ul class="last"><li><a href="#">Order</a></li></ul>
	  </div>
    </div>
     <div class="clear"></div>
     </div>
	</div>
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
		  	<h2 class="head">Featured Products</h2>
			<div class="top-box">
                        <?php 
                            if(!is_array($resul_art)){ $mss_art = 'NO SE ENCONTRARON ARTICULOS EN EL CATALOGO. ';?>
                            <div>NO SE ENCONTRARON ARTICULOS</div>
                        <?php    
                            }else{
                                foreach ($resul_art as $r_art){
                                    $SkuNo = trim($r_art['cod_art']);
                                    $precio = trim($r_art['precio']);
                                    $OnHand = trim($r_art['stock_ini']);
                                    $oferta = trim($r_art['oferta']);
                                    
                                    $mysqli2 = new mysqli(DBHOST2,DBUSER2,DBPASS2,DBNOM2);
                                    if (!$mysqli2->connect_error){
                                        $where ="SkuNo = '".$SkuNo."'";
                                        $campos = "*,'00/00/0000' as fe_oferta_dmy,(SELECT CatDesc FROM `codes cat` WHERE `codes cat`.CatCode = g_inventory.CatCode) as CatDesc, (SELECT PrdDesc FROM `codes catsub` WHERE `codes catsub`.PrdCode = g_inventory.PrdCode) as PrdDesc";
                                        $resul = $obj_bdmysql->select("g_inventory", $campos, $where, "ProdDesc", "",$mysqli2);
                                        if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$SkuNo; 
                                        }else{
                                            foreach ($resul as $r_art2){
                                                $PartNo = $r_art2['PartNo'];
                                                $ProdDesc = $r_art2['ProdDesc'];
                                                $CatDesc = $r_art2['CatDesc'];
                                                $PrdDesc = $r_art2['PrdDesc'];

                                                //DEFINE FLAG
                                                $flag = '';
                                                if($r_art2['Flag01'] == '1'){ $flag.= 'Flag01, '; }
                                                if($r_art2['Flag02'] == '1'){ $flag.= 'Flag02, '; }
                                                if($r_art2['Flag03'] == '1'){ $flag.= 'Flag03, '; }
                                                if($r_art2['Flag04'] == '1'){ $flag.= 'Flag04, '; }
                                                if($r_art2['Flag05'] == '1'){ $flag.= 'Flag05, '; }
                                                if($r_art2['Flag06'] == '1'){ $flag.= 'Flag06, '; }
                                                if($r_art2['Flag07'] == '1'){ $flag.= 'Flag07, '; }
                                                if($r_art2['Flag08'] == '1'){ $flag.= 'Flag08, '; }
                                                if($r_art2['Flag09'] == '1'){ $flag.= 'Flag09, '; }
                                                if($r_art2['Flag10'] == '1'){ $flag.= 'Flag10, '; }
                                                if(trim($flag) != ''){ $flag = str_replace(', _', '', $flag.'_'); }else{ $flag = 'No Aplica'; }

                                                //DEFINE OFERTAS
                                                $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$SkuNo."'", "ID", "1",$mysqli2);
                                                if(!is_array($resul_oferta)){ $oferta = '0'; $fecha_to_oferta = '00/00/0000'; $fecha_from_oferta = '00/00/0000'; 
                                                }else{    $oferta = $resul_oferta[0]['Precio']; $fecha_to_oferta = $resul_oferta[0]['Date_To_dma']; $fecha_from_oferta = $resul_oferta[0]['Date_From_dma'];   }
                                                
                                                //IMAGEN ARTICULO
                                                $image_art= "../assets/img/art/".$SkuNo.".jpg";
                                                if(!file_exists($image_art)){ $image_art= "../assets/img/art/def.jpg"; }
                                                

                                            }
                                        }
                                    }?>
                                    <div class="col_1_of_3 span_1_of_3"> 
                                        <a href="single.html">
                                            <div class="inner_content clearfix">
                                                <div class="product_image">
                                                    <!--<img src="images/pic.jpg" alt=""/>-->					
                                                    <img src="<?php echo $image_art;?>" alt="<?php echo $PartNo;?>" style="min-width:210px;min-height:220px;"/>					
                                                </div>
                                                <div class="sale-box"><span class="on_sale title_shop">New</span></div>	
                                                <div class="price">
                                                    <div class="cart-left">
                                                        <p class="title_cod"><?php echo $PartNo;?></p>
                                                        <p class="title"><?php echo $ProdDesc;?></p>
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
                                <?php
                                }
                            }
                            ?>
                            <!--<div class="col_1_of_3 span_1_of_3"> 
                                <a href="single.html">
                                    <div class="inner_content clearfix">
                                        <div class="product_image">
                                            <img src="images/pic.jpg" alt=""/>					
                                        </div>
                                    <div class="sale-box"><span class="on_sale title_shop">New</span></div>	
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
                            </div>-->
                            <div class="clear"></div>
                        </div>	
                    </div>
                    <div class="clear"></div>
                </div>
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
        <div class="footer">
            <div class="footer-top">
                <div class="wrap">
                    <div class="section group example">
                        <div class="col_1_of_2 span_1_of_2">
                            <ul class="f-list">
                                <li class="f-text" style="font-size:20px;font-weight:bold;color:#5f5f5f;"><i class="fa fa-map-marker" style="color:#00c5de;font-size:25px;border-radius:50%;padding:2% 3%;background:#FFF;"></i> Textronic Inc 4079 NW 79th Ave Doral FL 33166</li>
                            </ul>
                        </div>
                        <div class="col_1_of_2 span_1_of_2">
                            <ul class="f-list">
                                <li class="f-text" style="font-size:20px;font-weight:bold;color:#5f5f5f;"><i class="fa fa-phone" style="color:#00c5de;font-size:25px;border-radius:50%;padding:2.5% 3%;background:#FFF;"></i> Phone: (305) 597-5740 Fax: (305) 597-5741</li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
		<div class="footer-bottom">
                    <div class="wrap">
                        <div class="copy">
                            <p>© 2015 Textronic, Template by <a href="http://w3layouts.com" target="_blank">w3layouts</a></p>
                        </div>
                        <div class="f-list2">
                            <ul>
                                <li class="active"><a href="http://www.textronic.us/">www.textronic.us</a></li> |
                                <li><a href="delivery.html">Terms & Conditions</a></li> |
                                <li><a href="http://textronic.info/landingtex/">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
	     </div>
	</div>
</body>
</html>