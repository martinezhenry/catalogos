<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php include('conex_1.php');
//    $codigo=NULL;
?>

     <div class="header-top">
	   <div class="wrap"> 
 <div class="header-top-left">
                    <div class="info_catalog">
                       <?php if ($codigo!=NULL){ ?>
                            <b>CATALOG:</b> <?php echo $codigo;?>. <span>TITLE: <?php echo $titulo;?>. DATE: <?php echo $fecha;?></span>
                        <?php }?>
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
                                    <a href="init.php"><img src="images/logo.jpg" alt="" style="height:70px;"/></a>				</div>
			  <div class="menu">
	            <ul class="megamenu skyblue">
			<li class="active grid"><a href="init.php">Home</a></li>
			<li><a class="color4" href="#">Categorías</a>
				<div class="megapanel">
					<div class="row">
						<div class="col1">
							<div class="h_nav">
								<ul>
                                
      <?php
	 $cat = mysqli_query($link, "SELECT * FROM `codes cat` LIMIT 0,10");
	if($cat){
	while($c = mysqli_fetch_array($cat)){?>
       <li><a href="categoria.php?cate=<? echo $c['CatCode'];?>"><?php echo ''.$c['CatDesc'].'<br>';?></a></li>
	<?php	} }else{ echo mysqli_error(); }?>
								</ul>
							</div>							
						</div>
						
						
					  </div>
					</div>
				</li>				
				
			<!--	<li><a class="color6" href="other.html">Other</a></li>
				<li><a class="color7" href="other.html">Order</a></li>-->
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
					<li><h3>Carrito de compras</h3><a href=""></a></li>
					<li><p>Lorem ipsum dolor sit amet, consectetuer  <a href="">adipiscing elit, sed diam</a></p></li>
				</ul>
			</li>
		</ul>
		<!--<ul class="icon1 sub-icon1 profile_img">
			<li><a class="active-icon c2" href="#"> </a>
				<ul class="sub-icon1 list">
					<li><h3>No Products</h3><a href=""></a></li>
					<li><p>Lorem ipsum dolor sit amet, consectetuer  <a href="">adipiscing elit, sed diam</a></p></li>
				</ul>
			</li>
		</ul>-->
	    <ul class="last"><li><a href="carrito.php">Order</a></li></ul>
	  </div>
    </div>
     <div class="clear"></div>
     </div>
	</div>
