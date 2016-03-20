<?php
//    include '../../common/general.php';
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
                        <button type="button" class="btn btn-info btn-lg" onclick="ira('init.php?vw=catalogoNuevo_1.php');">Crear Nuevo</button>
                    </div>
                </div>
            </div>
            <div class="row mt">
                <div class="col-lg-12">

                    <!-- /1TH ROW OF PANELS -->
                    <div class="row">
                        <?php 
                            if($mss != ''){
                                echo '<div class="col-lg-12 col-md-12 col-sm-4 mb"><h3>'.$mss.'</h3></div>';
                            }else{
                                foreach ($resul as $r){ 
                                //CANTIDAD DE ARTICULOS.
                                $n_art = $obj_bdmysql->num_row("catalogo_reng", "id_catalogo = '".$r['id_catalogo']."'", $mysqli);
                        ?>
                        <a href="init.php?vw=catalogovista_1.php?id=<?php echo $obj_function->code_url($r['id_catalogo'],'code');?>">
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
                            <div class="weather-2 pn">
                                <div class="weather-2-header">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <p><?php echo $r['titulo'];?></p>
                                        </div>
                                        <div class="col-sm-6 col-xs-6 goright">
                                            <p class="small"><?php echo $r['fe_us_in_dmy'];?></p>
                                        </div>
                                    </div>
                                </div><!-- /weather-2 header -->
                                <div class="row centered">
                                    <img src="../../assets/img/ny.jpg" class="img-circle" width="120">			
                                </div>
                                <div class="row data">
                                    <div class="col-sm-6 col-xs-6 goleft">
                                        <h4><i class="fa fa-barcode"></i><b> Code: </b><?php echo $r['codigo'];?></h4>
                                    </div>
                                    <div class="col-sm-6 col-xs-6 goright">
                                        <h6><i class="fa fa-cube"></i><b> N Article: </b><?php echo $n_art;?></h6>
                                        <h5></h5>
                                    </div>
                                </div>
                                <div class="row data">
                                    <div class="col-sm-12 col-xs-6 goleft">
                                        <h5><i class="fa fa-link"></i><b> Link: </b><a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a></h5>
                                        <h5><i class="fa fa-book"></i><b> PDF: </b><a href="../../assets/tcpdf/report/catalogo.php" target="_blank">Download</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                        <!-- /col-md-4 -->
                        <?php 
                                }

                            } 
                        ?>
                    </div><!-- /END 1TH ROW OF PANELS -->

                </div>
            </div>
        </section><! --/wrapper -->
    </section><! --/MAIN -->
    <script>
        function ira(url){
            window.open (url,"_self","status=1");
        }
    </script>
    <!--END SCRIPT-->