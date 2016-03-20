<? include('header.php');
include('funciones.php');
//include('conex.php');
?>  <!-- start slider -->
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
            <div class="section group"> <!--Inicio de catalogo de productos-->
		  <div class="cont span_2_of_3">
		  	<h2 class="head">Featured Products</h2>
		
<?php
 $q = mysqli_query($link, "SELECT * FROM `g_inventory` LIMIT 0,9");
$i=0;
if($q){
while($r = mysqli_fetch_array($q)){
$codigo=$r['SkuNo'];

 $v=consulta_articulo($codigo);
  $precio=$v[0];
  $oferta=$v[1];
  $stock=$v[2];
?>
   	    <div class="top-box">
       <div class="col_1_of_3 span_1_of_3"> 
            <? echo'<a href="single.php?id='.$r['SkuNo'].'">' ?>
		   
		   <div class="inner_content clearfix">
			<div class="product_image">
             <img  src="articulos/<? echo $codigo;?>/grande/1.jpg" alt="">
              </div>
                <div class="price">
				  <div class="cart-left">
                    <? echo' <p class="title">'.$r['ProdDesc'].'</p>' ?>
			      <div class="price1">
               <? echo' <span class="actual">Bs. '. $precio.'</span>' ?>
               <span>Ver detalle</span> 
			   </div>
			   </div>
			   <div class="cart-right"> </div>
						<div class="clear"></div>
					 </div>				
                   </div>
              </a> 
          </div>
<? $i=$i+1;
if ($i==3){?>	<div class="clear"></div>
  <? $i=0;}?> </div>
  <? }?>
 <? }else{ echo mysqli_error(); }
 ?>
		  <!--inicio de producto-->
<!--              <div class="col_1_of_3 span_1_of_3"> 
			   <a href="single.php">
				<div class="inner_content clearfix">
					<div class="product_image">
						<img src="images/pic.jpg" alt=""/>					</div>
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
				</div>--><!--fin producto-->
                
                           
                			
				<!--sale <div class="col_1_of_3 span_1_of_3">
				 <a href="single.php">
					<div class="inner_content clearfix">
					<div class="product_image">
						<img src="images/pic1.jpg" alt=""/>
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
				

		  <h2 class="head">Staff Pick</h2>
		  <div class="top-box1">
			  <div class="col_1_of_3 span_1_of_3">
			  	 <a href="single.php">
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
					 <a href="single.php">
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
						<div class="cart-right"> </div>
						<div class="clear"></div>
					 </div>				
                   </div>
                   </a>
				</div>
				<div class="col_1_of_3 span_1_of_3">
				 <a href="single.php">
				 <div class="inner_content clearfix">
					<div class="product_image">
						<img src="images/pic2.jpg" alt=""/>
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
				<div class="clear"></div>
			</div>	
	        <h2 class="head">New Products</h2>	
		    <div class="section group">
			  <div class="col_1_of_3 span_1_of_3">
			  	 <a href="single.php">
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
					<a href="single.php">
					<div class="inner_content clearfix">
					<div class="product_image">
						<img src="images/pic1.jpg" alt=""/>
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
				 <a href="single.php">
				 <div class="inner_content clearfix">
					<div class="product_image">
						<img src="images/pic2.jpg" alt=""/>
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
				</div> <!--fin-->
				<div class="clear"></div>
			</div>			 						 			    
		  </div>
			<div class="rsidebar span_1_of_left">
				<div class="top-border"> </div>
				 <div class="border">
	             <link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
	             <link href="css/nivo-slider.css" rel="stylesheet" type="text/css" media="all" />
				  <script src="js/jquery.nivo.slider.js"></script>
				    <script type="text/javascript">
				    $(window).load(function() {
				        $('#slider').nivoSlider();
				    });
				    </script>
		   <!-- <div class="slider-wrapper theme-default">
              <div id="slider" class="nivoSlider">
                <img src="images/t-img1.jpg"  alt="" />
               	<img src="images/t-img2.jpg"  alt="" />
                <img src="images/t-img3.jpg"  alt="" />
              </div>
             </div>-->
              <div class="btn">Lorem Ipsum simplyLorem Ipsum simplyLorem Ipsum simplyLorem Ipsum simply</div>
             </div>
          <!-- <div class="top-border"> </div>
			<div class="sidebar-bottom">
			    <h2 class="m_1">Newsletters<br> Signup</h2>
			    <p class="m_text">Lorem ipsum dolor sit amet, consectetuer</p>
			    <div class="subscribe">
					 <form>
					    <input name="userName" type="text" class="textbox">
					    <input type="submit" value="Subscribe">
					 </form>
	  			</div>
			</div>-->
	    </div>
	   <div class="clear"></div>
	</div>
	</div>
	</div>
  <? include('footer.php');?>
</body>
</html>