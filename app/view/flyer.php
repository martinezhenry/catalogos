<?php  
    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $obj_bdmysql = new coBdmysql();
    $controller = 'ctCatalogo.php';
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
    $mss = 'No Existen Registros';    
    $resul = NULL;
    $r[] = NULL;
?>


<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <body>
        <div id="modal" style="width:100%; height:100%; position:fixed; top:0; left:0; right:0; bottom:0; margin:auto; padding:10px;background:rgba(0,0,0,0.6); z-index:9000; text-align:center;display:none;">&nbsp;</div>
        <div id="preloader" style="display:none;width:100%; height:100%; position:fixed; top:0; left:0; right:0; bottom:0; margin:auto; background: rgba(255,255,255,0.9); z-index:10000; text-align:center;">
            <div style="position:absolute; top:50%; left:50%; margin:-50px 0 0 -50px;font-size:38px;color:#00AEFF;font-style:italic;">Cargando...</div>
            <!--<div id="loader" style="width:128px; height:128px; position:absolute; top:50%; left:50%; margin:-50px 0 0 -50px;background:url(../../assets/img/loader.gif) center no-repeat;">&nbsp;</div>-->
        </div>
        <section id="container" >
            <!-- TOP BAR CONTENT & NOTIFICATIONS -->
            <?php $obj_common->header();?>

            <!-- MAIN SIDEBAR MENU -->
            <?php $obj_common->left_sidebar($_SERVER['PHP_SELF']);?></aside>

            <!-- MAIN CONTENT -->
            <section id="main-content">
                <section class="wrapper site-min-height">
                    <h3><i class="fa fa-angle-right"></i> Flayers</h3>
                    <div style="margin-bottom:100px;">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" placeholder="Buscar">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-default">Enviar</button>
                            </div>
                            <div class="col-sm-7" align="right">
                                <button type="button" class="btn btn-info btn-lg" onclick="ir_a('flyerNuevo.php','');">Crear Nuevo</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="content-panel">
                                        <table class="table table-striped table-advance table-hover" border="0">
                                                    <h4><i class="fa fa-angle-right"></i> REGISTROS</h4>
                                                    <hr>
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center"><i class="fa fa-barcode"></i> Codigo</th>
                                                        <th class="text-center"><i class="fa fa-file-text"></i> Titulo</th>
                                                        <th class="text-center"><i class="fa fa-image"></i> Fondo</th>
                                                        <th class="text-center"><i class="fa fa-calendar"></i> Creado</th>
                                                        <th class="text-center"><i class="fa fa-calendar"></i> Modificado</th>
                                                    </tr>
                                                    </thead>
                                        <?php 
                                            if($mss != ''){
                                                echo '<tr><td colspan="5">'.$mss.'</td></tr>';
                                            }else{
                                                foreach ($resul as $r){
                                                //ID CATALOGO
                                                $id_catalogo = $r['id_catalogo'];
                                                //VISTA DE CATALOGO
                                                $vista = "catalogoVista.php?id=".$obj_function->code_url($id_catalogo,'code');
                                                //CATALOGO PDF
                                                $pdf = "../../assets/tcpdf/report/catalogo.php?id=".$obj_function->code_url($id_catalogo,'code');
                                                //CATALOGO VIRTUAL
                                                $link = 'http://textronic.info/cat/cv?cd='.$id_catalogo;
                                                //CANTIDAD DE ARTICULOS.
                                                $n_art = $obj_bdmysql->num_row("catalogo_reng", "id_catalogo = '".$id_catalogo."'", $mysqli);
                                                //CODIGO QR
                                                $codigo_qr = '../../common/codeqr/'.$id_catalogo.'.png';
                                                if(file_exists($codigo_qr)){  $img_cod_qr = '<img src="'.$codigo_qr.'" alt="QR" style="width:80px;height:80px;">';
                                                }else{ $img_cod_qr = 'QR NO ENCONTRADO.'; }
                                        ?>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center"><a href="<?php echo $vista;?>"><?php echo $r['codigo'];?></a></td>
                                                        <td><a href="<?php echo $vista;?>"><?php echo $r['titulo'];?></a></td>
                                                        <td class="text-center"><a href="<?php echo $pdf;?>" target="_blank">Download</a></td>
                                                        <td><a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a></td>
                                                        <td><a href="<?php echo $vista;?>"><?php echo $r['fe_us_in_dmy'];?></a></td>
                                                        <td><?php echo $img_cod_qr;?></td>
                                                        <td class="text-center" width="100px">
                                                            <!--<button class="btn btn-success btn-xs" onclick="activa_beneficiario('<?php echo $r['id'];?>');" title="ACTIVA / INACTIVA NOTICIA"><i class="fa fa-refresh"></i></button>-->
                                                            <button class="btn btn-primary btn-xs" onclick="ir_a('<?php echo $vista;?>','')" title="EDITA"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-danger btn-xs" onclick="elimina_catalogo('<?php echo $id_catalogo;?>');" title="ELIMINA"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                        <?php 
                                                }

                                            }
                                        ?>
                                        </table>
                                    </div>
                                </div>
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
          <!--END SCRIPT-->
    </body>
</html>