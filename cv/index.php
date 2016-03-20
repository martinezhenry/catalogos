<?php
//error_reporting(E_ALL);
//ini_set('display_errors','1');
$valido = '1';
if(isset($_REQUEST['cd'])){
    if(is_numeric($_REQUEST['cd'])){
        $id_catalogo = $_REQUEST['cd'];
        include '../common/function.php';
        include '../common/bdMysql.php';
        $obj_function = new coFunction();
        $obj_bdmysql = new coBdmysql();
        $mysqli = new mysqli('localhost','v1131055_cat_us','Clave123','v1131055_cat');
        if (!$mysqli->connect_error){
            if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
                $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul; }
                $codigo = $resul[0]['codigo'];
                $fecha = $resul[0]['fe_us_in_dmy'];
                $titulo = $resul[0]['titulo'];
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
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery1.min.js"></script>
<!-- start menu -->
<link href="css/megamenu.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<!-- dropdown -->
<script src="js/jquery.easydropdown.js"></script>
</head>
<body>
    <div class="header-top">
        <div class="wrap"> 
            <div class="header-top-left">
                     <div class="box">
                       <!-- <select tabindex="4" class="dropdown">
                                          <option value="" class="label" value="">Language :</option>
                                          <option value="1">English</option>
                                          <option value="2">French</option>
                                          <option value="3">German</option>
                            </select>-->
                      </div>
                      <div class="box1">
                         <!-- <select tabindex="4" class="dropdown">
                                          <option value="" class="label" value="">Currency :</option>
                                          <option value="1">$ Dollar</option>
                                          <option value="2">€ Euro</option>
                                  </select>-->
                      </div>
                      <div class="clear"></div>
            </div>
            <div class="cssmenu">
                  <ul>
                      <li class="active"><a href="http://www.textronic.us/">www.textronic.us</a></li> |
                      <li><a href="http://textronic.info/landingtex/">Contact Us</a></li>
                  </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="wrap">
            <div class="header-bottom-left">
                <div class="logo">
                    <a href="index.php"><img src="images/catalog_header.png" alt=""/></a>                </div>		
          </div>
        <div class="header-bottom-right"></div>
     <div class="clear"></div>
     </div>
	</div>
        <div class="login">
            <div class="wrap">
                <?php if($valido == '1'){?>
                <div class="col_1_of_login span_1_of_login">
                    <h4 class="title">
                        CATALOG TEXTRONIC: <?php echo $codigo;?>
                    <br>TITLE: <?php echo $titulo;?>
                    <br>DATE: <?php echo $fecha;?>
                    </h4>
                    <p>Welcome to textronic Catalog. On this site can view products and place orders so quick and easy.
                        <br>If user has no contact our landing page by clicking on the button "Contact Us"
                        <br>Thank You
                    </p>
                    <div class="button1">
                        <a href="http://textronic.info/landingtex"><input type="submit" name="Submit" value="Contact Us"></a>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="col_1_of_login span_1_of_login">
                    <div class="login-title">
                        <h4 class="title">Registered Customers</h4>
                        <div id="loginbox" class="loginbox">
                            <form action="start_sesion.php" method="post" name="login" id="login-form">
                                <input id="cod" type="hidden" name="cod" value="<?php echo $id_catalogo;?>">
                                <fieldset class="input">
                                    <p id="login-form-username">
                                        <label for="modlgn_username">Email</label>
                                        <input id="usuario" type="text" name="usuario" class="inputbox" size="18" autocomplete="off">
                                    </p>
                                    <p id="login-form-password">
                                        <label for="modlgn_passwd">Password</label>
                                        <input id="clave" type="password" name="clave" class="inputbox" size="18" autocomplete="off">
                                    </p>
                                    <div class="remember">
                                        <p id="login-form-remember">
                                            <label for="modlgn_remember"><a href="#">Forget Your Password ? </a></label>
                                        </p>
                                        <input type="submit" name="Submit" class="button" value="Login"><div class="clear"></div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div style="text-align:center;font-size:38px;color:#9f9f9f;padding:100px 0px;">SORRY INVALID ACCESS</div>
                <?php } ?>
                <div class="clear"></div>
            </div>
        </div>
        <? include('footer.php');?>
</body>
</html>