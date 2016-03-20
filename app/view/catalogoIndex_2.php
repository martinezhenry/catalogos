<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $obj_bdmysql = new coBdmysql();
    $link = 'http://www.gibble.com.ve/textronic/web/index.php';
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
    if (!$mysqli->connect_error){
        //DATOS DEL CATALOGO
        $mss = '';
        if($obj_bdmysql->num_row("catalogo", "", $mysqli) > 0){
            $resul = $obj_bdmysql->select("catalogo", "*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy", "", "", "",$mysqli);
            if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS.'; }
        }else{
            $mss = "NO SE ENCONTRARON CATALOGOS REGISTRADOS.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <body>

        <section id="container" >
            <!-- TOP BAR CONTENT & NOTIFICATIONS -->
            <?php $obj_common->header();?>

            <!-- MAIN SIDEBAR MENU -->
            <?php $obj_common->left_sidebar($_SERVER['PHP_SELF']);?></aside>

            <!-- MAIN CONTENT -->
            <section id="main-content">
                <section class="wrapper site-min-height">
                    <h3><i class="fa fa-angle-right"></i> Catalogos</h3>
                    <div style="margin-bottom:100px;">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" placeholder="Buscar">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default">Enviar</button>
                            </div>
                            <div class="col-sm-7" align="right">
                                <button type="button" class="btn btn-info btn-lg" onclick="ir_a('catalogoNuevo.php','');">Crear Nuevo</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <!-- /1TH ROW OF PANELS -->
                            <div class="row">
                                <table class="table table-striped table-advance table-hover" border="0">
                                            <h4><i class="fa fa-angle-right"></i> BENEFICIARIOS</h4>
                                            <hr>
                                            <thead>
                                            <tr>
                                                <th class="text-center"><i class="fa fa-barcode"></i> Codigo</th>
                                                <th class="text-center"><i class="fa fa-file-text"></i> Cedula</th>
                                                <th class="text-center"><i class="fa fa-file-text-o"></i> Apellidos y Nombres</th>
                                                <th class="text-center"><i class="fa fa-calendar"></i> Fecha</th>
                                                <th class="text-center"><i class=" fa fa-edit"></i> Estatus</th>
                                                <th class="text-center"><i class="fa fa-cog"></i> Accion</th>
                                            </tr>
                                            </thead>
                                <?php 
                                    if($mss != ''){
                                        echo '<div class="col-lg-12 col-md-12 col-sm-4 mb"><h3>'.$mss.'</h3></div>';
                                    }else{
                                        foreach ($resul as $r){
                                        //ID CATALOGO
                                        $id_catalogo = $r['id_catalogo'];
                                        //CANTIDAD DE ARTICULOS.
                                        $n_art = $obj_bdmysql->num_row("catalogo_reng", "id_catalogo = '".$id_catalogo."'", $mysqli);
                                        //CODIGO QR
                                        $codigo_qr = '../../common/codeqr/'.$id_catalogo.'.png';
                                        if(file_exists($codigo_qr)){  $img_cod_qr = '<img src="'.$codigo_qr.'" alt="QR" style="width:120px;height:120px;">';
                                        }else{ $img_cod_qr = 'QR NO ENCONTRADO.'; }
                                ?>
                                <div class="col-lg-4 col-md-4 col-sm-4 mb">
                                    <div class="weather-2 pn">
                                        <div class="weather-2-header">
                                            <div class="row" onclick="ir_a('catalogoVista.php?id=<?php echo $obj_function->code_url($id_catalogo,'code');?>','');">
                                                <div class="col-sm-9">
                                                    <p><?php echo $r['titulo'];?></p>
                                                </div>
                                                <div class="col-sm-3 goright">
                                                    <p><i class="fa fa-pencil"></i>&nbsp;Editar</p>
                                                </div>
                                            </div>
                                        </div><!-- /weather-2 header -->
                                        <div class="row centered">
                                            <!--<img src="../../assets/img/ny.jpg" class="img-circle" width="120">-->
                                            <?php echo $img_cod_qr;?>
                                        </div>
                                        <div class="row data">
                                            <div class="col-lg-9 goleft">
                                                <h4><i class="fa fa-barcode"></i><b> Code: </b><?php echo $r['codigo'];?></h4>
                                            </div>
                                            <div class="col-lg-3 goright"><h5><?php echo $r['fe_us_in_dmy'];?></h5></div>
                                        </div>
                                        <div class="row data">
                                            <div class="col-lg-12 goleft">
                                                <h5><i class="fa fa-link"></i><b> Link: </b><input type="text" value="<?php echo $link;?>"></h5>
                                                <h5><i class="fa fa-book"></i><b> PDF: </b><a href="../../assets/tcpdf/report/catalogo.php?id=<?php echo $obj_function->code_url($id_catalogo,'code');?>" target="_blank">Download</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /col-md-4 -->
                                <?php 
                                        }
                                    
                                    }
                                ?>
                            </div><!-- /END 1TH ROW OF PANELS -->
                            
                        </div>
                    </div>
		</section><! --/wrapper -->
            </section><!-- /MAIN CONTENT -->

            <!--FOOTER-->
            <?php $obj_common->footer();?>
        
        </section>
        <!--JAVASCRIPT GENERAL-->
        <?php $obj_common->script();?>
          <script>
//            function ira(url){
//                window.open (url,"_self","status=1");
//            }
        </script>
          <!--END SCRIPT-->
    </body>
</html>
<?php
    