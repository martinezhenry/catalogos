<?php
    session_start();
    session_destroy();
    if(isset($_GET['salida'])){
        $salida=$_GET['salida'];
        if($salida=='valida'){ $salida = 'Ha Salido Correctamente del Sistema.';}
        else if($salida=='fallida'){ $salida = 'Usuario y/o Clave Invalida';}
        else if($salida=='invalida'){ $salida = 'Por Medidas de Seguridad <br>Ha Salido del Sistema.'; }
        else if($salida=='inactivo'){ $salida = 'Su Usuario Se Encuentra Inactivo.'; }
        else if($salida=='no_registrado'){ $salida = 'Su Usuario No Se Encuentra Registrado.'; }
        else if($salida=='error_emp'){ $salida = 'Empresa No Encontrada.'; }
    }else{ $salida='Bienvenidos...'; }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Textronic">
    <meta name="keyword" content="Textronic">

    <title>TEXTRONIC</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
                    <form class="form-login" action="common/start_sesion.php" method="POST">
		        <h2 class="form-login-heading">iniciar sesión</h2>
		        <div class="login-wrap">
                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="User ID" autofocus>
		            <br>
                            <input type="password" id="clave" name="clave" class="form-control" placeholder="Password">
		            
                            <br>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> ENVIAR</button>
		            <hr>
		            <div>
                                <?php 
                                if($salida == 'Bienvenidos...'){
                                echo $salida;
                                }elseif(trim($salida) == 'valida'){
                                ?>
                                <div class="alert alert-success"><?php echo $salida;?></div>
                                <?php
                                }else{
                                ?>
                                <div class="alert alert-danger"><?php echo $salida;?></div>
                                <?php   
                                } 
                                ?>
		            </div>
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Forgot Password ?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Enter your e-mail address below to reset your password.</p>
                                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                                    </div>
                                    <div class="modal-footer">
                                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                                        <button class="btn btn-theme" type="button">Submit</button>
                                    </div>
                                </div>
                            </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	  </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>
  </body>
</html>