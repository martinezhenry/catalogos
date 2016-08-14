<?php
    include 'flyer/initNew.php';

    if (isset($_GET['r'])){
        if(!$mysqli->connect_error){
            $id = $_GET['r'];
            $datosFlyer = $obj_bdmysql->select("`flyer`", "*", "idflyer=" . $id, "", "",$mysqli);

            if (is_array($datosFlyer)){
                $tittleFlyer = $datosFlyer[0]['tittle'];
                $descFlyer = $datosFlyer[0]['description'];
                $createdFlyer = $datosFlyer[0]['created'];
                $modificatedFlyer = $datosFlyer[0]['modificated'];
                $backgroundFlyer = $datosFlyer[0]['background_img'];
                $typeFlyer = $datosFlyer[0]['type'];

                $datosProductFlyer = $obj_bdmysql->select("`productflyer`", "*", "flayer_idflyer=" . $id, "", "",$mysqli,false);

                //var_dump($datosProductFlyer);
                if ($backgroundFlyer !== ''){
                    $data = $backgroundFlyer;
                    $type = $typeFlyer;
                    require_once 'flyer/createImg.php';
                    $portada = 'flyer/finalPortada.' . $type;
                }


            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <link type="text/css" rel="stylesheet" href="../../assets/bootstrap-fileinput-master/css/fileinput.css" />
    <link type="text/css" rel="stylesheet" media="all" href="../../assets/bootstrap-colorpickersliders-master/bootstrap.colorpickersliders.css">
    <link type="text/css" rel="stylesheet" media="all" href="../../assets/css/jquery-ui-1.9.2.custom.min.css">
    

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
                <section class="wrapper">
                    
                    
                    <h3><i class="fa fa-angle-right"></i> <a href="catalogoIndex.php">Flyers</a> <i class="fa fa-angle-right"></i> Nuevo</h3>
                    <!-- BASIC FORM ELELEMNTS -->
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4 class="mb"><i class="fa fa-angle-right"></i> Datos del Flayer</h4>
                                <form class="form-horizontal style-form" method="get" id="catalogo_form">
                                    <!--ACORDION-->
                                    <div class="panel-group" id="accordion">
                                        <!--ACORDION 1-->
                                        <div class="panel panel-default">
                                            <input type="hidden" id="flyer_id" value="<?php echo $id; ?>"/>
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                            <div class="panel-heading" style="background:#F5F5F5;">
                                              <h4 class="panel-title"><i class="fa fa-database"></i> DATOS</h4>
                                            </div>
                                            </a>
                                            <div id="collapse1" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Title</label>
                                                            <input type="text" id="flyer_tittle" class="form-control" value="<?php echo (isset($tittleFlyer)) ? $tittleFlyer:''; ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="col-sm-2 col-sm-2 control-label">Fecha</label>
                                                            <input type="text" readonly id="flyer_created" class="form-control" value="<?php echo (isset($createdFlyer)) ? $createdFlyer:date('d/m/Y');?>" placeholder="Example: 01/01/1960" onkeyup="mascara(this,'/',patron,true);" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <label class="control-label">Descripcion</label>
                                                            <input type="text" id="flyer_description" class="form-control" value="<?php echo (isset($descFlyer)) ? $descFlyer:''; ?>">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-12" id="flyer_img_fondo">
                                                        <label class="control-label">Fondo</label>
                                                            <input type="file" id="flyer_fondoEdit" name="flyer_fondo" multiple=false class="file-loading">
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                        </div>
                                        <!--FIN ACORDION 1-->
                                                                                
                                        <!--ACORDION 3-->
                                        <!--ACORDION 3-->
                                        <div class="panel panel-default">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                            <div class="panel-heading" style="background:#F5F5F5;">
                                                <h4 class="panel-title"><i class="fa fa-cube"></i> ARTICULOS</h4>
                                            </div>
                                            </a>
                                            <div id="collapse3" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div id="catalogo_filtro" class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Categoria</label>
                                                            <select class="form-control" id="catalogo_categoria"><?php echo $list_categoria;?></select>
                                                            <div class="col-sm-6">
                                                                <label class=" control-label">Sub-Categoria</label>
                                                                <div id="catalogo_subcategoria" class="form-control" style="overflow:auto;height:150px;"><?php echo $list_sub_categoria;?></div>
                                                            </div>
                                                            <!--<label class="control-label">Sub-Categoria</label>-->
                                                            <!--<select class="form-control" id="catalogo_subcategoria"><?php echo $list_sub_categoria;?></select>-->

                                                            <label class="input-group control-label">Invetario</label>
                                                            <div class="col-sm-6">
                                                            <select class="form-control" id="catalogo_sel_tipo_inv">
                                                                <option value="0">TEX y DTS</option>
                                                                <option value="1">TEX</option>
                                                                <option value="2">DTS</option>
                                                            </select>
                                                            <br>
                                                            </div>



                                                            <label class="control-label">Stock</label>
                                                            <!--<input type="text" id="catalogo_stock" class="form-control col-sm-6" value="" placeholder="" onkeyup="mascara(this,'/',patron,true);">-->
                                                            <div class="input-group">
                                                                <input type="text" id="catalogo_stock" class="form-control" aria-label="..." onkeyup="mascara(this,'',patron7,true);">
                                                                <div class="input-group-btn">
                                                                    <select id="catalogo_stock_cond" class="btn btn-default dropdown-toggle">
                                                                        <option value="="> = </option>
                                                                        <option value="<"> < </option>
                                                                        <option value=">"> > </option>
                                                                        <option value="<="> <= </option>
                                                                        <option value=">="> >= </option>
                                                                    </select>
                                                                </div><!-- /btn-group -->
                                                              </div>

                                                              <div class="col-sm-12">
                                                            <br>
                                                            <div class="switch switch-square"
                                                                 data-on-label="<i class=' fa fa-check'></i>"
                                                                 data-off-label="<i class='fa fa-times'></i>">
                                                                <input type="checkbox" id="checkSubCategories"/>
                                                            </div>
                                                            <label style="font-size:20px;padding:4px;">Marcar Todas</label>
                                                        </div>





                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class=" control-label">Flag</label>
                                                            <div id="catalogo_flags" class="form-control" style="overflow:auto;height:150px;"><?php echo $list_flag;?></div>
                                                        </div>


                                                        <div class="col-sm-3">
                                                        <label class="control-label">Vendido Desde</label>
                                                            <div class="input-group">
                                                                <input style="z-index: 999;" readonly type="text" id="cat_vendido_desde" class="form-control" aria-label="..." onkeyup="">
                                                          
                                                            </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                        <label class="control-label">Vendido Hasta</label>
                                                            <div class="input-group">
                                                                <input style="z-index: 999;" readonly type="text" id="cat_vendido_hasta" class="form-control" aria-label="..." onkeyup="">
                                                          
                                                            </div>
                                                            </div>

                                                            <div class="col-sm-3">
                                                            <br>
                                                            <div class="switch switch-square"
                                                                 data-on-label="<i class=' fa fa-check'></i>"
                                                                 data-off-label="<i class='fa fa-times'></i>">
                                                                <input type="checkbox" id="catalogo_descontinuado"/>
                                                            </div>
                                                            <label style="font-size:20px;padding:4px;">Descontinuado</label>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <br>
                                                            <div class="switch switch-square"
                                                                 data-on-label="<i class=' fa fa-check'></i>"
                                                                 data-off-label="<i class='fa fa-times'></i>">
                                                                <input type="checkbox" id="catalogo_con_img" value="true"/>
                                                            </div>
                                                            <label style="font-size:20px;padding:4px;">Con Imagen</label>
                                                        </div>




                                                        <div class="col-sm-12">
                                                            <label class="control-label">Articulo</label>
                                                            <div class="input-group">
                                                                <input type="text" id="catalogo_articulo" class="form-control" placeholder="Indique codigo o nombre del Articulo">
                                                                <span class="input-group-btn"><button class="btn btn-default" type="button" onclick="buscar_articulo();">Buscar</button></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <h4><i class="fa fa-angle-right"></i> Resultado de Busqueda. <b id="catalogo_articulo_list_total_busqeuda"></b></h4>
                                                            <div class="form-control" style="height:310px;position:relative;">
                                                                <!--<div class="modal-loading" id="modal_busqueda">Realice una busqueda para mostrar articulos.</div>-->
                                                                <div style="height:300px;overflow:auto;">
                                                                    <section id="no-more-tables">
                                                                        <table class="table table-bordered table-striped table-condensed cf">
                                                                            <thead class="cf" id="catalogo_articulo_list_busca"></thead>
                                                                        </table>
                                                                    </section>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--<div class="col-sm-1"><br><button type="button" class="btn btn-default" onclick="pagina_articulo();"> 50 + </button></div>-->
                                                        <div class="col-sm-8">
                                                            <br>
                                                            <div class="switch switch-square"
                                                                 data-on-label="<i class=' fa fa-check'></i>"
                                                                 data-off-label="<i class='fa fa-times'></i>">
                                                                <input type="checkbox" id="catalogo_sel_all"/>
                                                            </div>
                                                            <label style="font-size:20px;padding:4px;">MARCAR TODO</label>
                                                        </div>
<!--                                                        <div class="col-sm-4 text-right"><br><h4>Total Articulos Busqueda: <b id="catalogo_articulo_list_total_busqeuda">0</b></h4></div>-->
                                                        <div class="col-sm-4 text-right"><br><button type="button" class="btn btn-default" onclick="cargar_articuloFlyer();">Cargar</button></div>
                                                        <div id="resul"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--ACORDION 3-->
  
                                    </div>
                                    <!--FIN ACORDION-->
                                    <!--TABLA DE ARTICULOS CARGADOS-->
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="col-lg-9"><h4><i class="fa fa-angle-right"></i> Articulos cargados. <b id="catalogo_articulo_list_total_cargado"></b></h4></div>
                                            
                                            <div class="form-control" style="height: 300px;overflow:auto;position:relative;">
                                                <div class="modal-loading" id="modal_carga" style="display:none;">Cargue articulos.</div>
                                                <section id="no-more-tables">
                                                    <table class="table table-bordered table-striped table-condensed cf" id="catalogo_articulo_list_carga_table">
                                                        <thead class="cf" id="catalogo_articulo_list_carga">
                                                        <tr>
                                                            <th>Borrar</th>
                                                            <th width="10%">SkuNo</th>
                                                            <th width="10%">PartNo</th>
                                                            <th>Application</th>
                                                            <th>Application Label</th>
                                                            <th>TOMCO</th>
                                                            <th>SMP</th>
                                                            <th>OEM</th>
                                                            <th>WELLS</th>
                                                            <th class="numeric">Precio Name 1</th>
                                                            <th class="numeric">Precio Name 2</th>
                                                            <th class="numeric">Precio Name 3</th>
                                                            <th class="numeric">Precio 1</th>
                                                            <th class="numeric">Precio 2</th>
                                                            <th class="numeric">Precio 3</th>
                                                          
                                                        </tr>
                                                       

                                                        <?php 

                                                        if (isset($datosProductFlyer) && is_array($datosProductFlyer)){

                                                            ?><?php
                                                            $html = "";
                                                            $count=0;
                                                            foreach ($datosProductFlyer as $key => $value) {
                                                                   $count=$count+1;
                                                                   $SkuNo = $value['skuno'];
                                                                   $PartNo = $value['no_part'];
                                                                   $ProdDesc = $value['application'];
                                                                   $applicationLabel = $value['applicationLabel'];
                                                                   $tomco = $value['tomco'];
                                                                   $smp = $value['smp'];
                                                                   $oem = $value['oem'];
                                                                   $wells = $value['alias'];
                                                                   $precioN = $value['price_name_one'];
                                                                   $precioN2 = $value['price_name_two'];
                                                                   $precioN3 = $value['price_name_three'];
                                                                   $precio = $value['price_one'];
                                                                   $precio2 = $value['price_two'];
                                                                   $precio3 = $value['price_three'];

                                                                $html =  $html.
                                                                        '<tr class="catalogo_articulo_fila_carga" id="catalogo_articulo_fila_carga_'.$SkuNo.'">'.
                                                                        '    <td data-title="remove" id="catalogo_articulo_list_remove_'.$SkuNo.'" style="text-align:center;" onclick="remover_articulo(this.id);"><i class="fa fa-trash-o" style="font-size:18px; cursor: pointer;"></i></td>'.
                                                                        '    <td data-title="CODIGO" class="catalogo_articulo_list_cod" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="'.$SkuNo.'">'.$SkuNo.'</td>'.
                                                                        '    <td data-title="PARTNO" class="catalogo_articulo_list_partNo"><input type="hidden" id="catalogo_articulo_list_partno" value="'.$PartNo.'">'.$PartNo.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_prodDesc"><input type="hidden" id="catalogo_articulo_list_proddesc" value="'.$ProdDesc.'">'.$ProdDesc.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_applicationLabel"><input type="hidden" id="catalogo_articulo_list_applicationLabel" value="'.$applicationLabel.'">'.$applicationLabel.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_tomco"><input type="hidden" id="catalogo_articulo_list_tomco" value="'.$tomco.'">'.$tomco.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_smp"><input type="hidden" id="catalogo_articulo_list_smp" value="'.$smp.'">'.$smp.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_oem"><input type="hidden" id="catalogo_articulo_list_oem" value="'.$oem.'">'.$oem.'</td>'.
                                                                        '    <td data-title="ARTICULO" class="catalogo_articulo_list_wells"><input type="hidden" id="catalogo_articulo_list_wells" value="'.$wells.'">'.$wells.'</td>'.
                                                                       // '    <td data-title="CATEGORIA">'+CatDesc+'</td>'+
                                                                       // '    <td data-title="SUB CATEGORIA">'+PrdDesc+'</td>'+
                                                                       '    <td class="numeric" data-title="PRECION"><input type="hidden" id="catalogo_articulo_list_priceN" class="form-control" placeholder="Price Name" value="'.$precioN.'">'.$precioN.'</td>'.
                                                                        '    <td class="numeric" data-title="PRECION2"><input type="hidden" id="catalogo_articulo_list_priceN2" class="form-control" placeholder="Price Name 2" value="'.$precioN2.'">'.$precioN2.'</td>'.
                                                                        '    <td class="numeric" data-title="PRECION3"><input type="hidden" id="catalogo_articulo_list_priceN3" class="form-control" placeholder="Price Name 3" value="'.$precioN3.'">'.$precioN3.'</td>'.
                                                                        '    <td class="numeric" data-title="PRECIO"><input type="hidden" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="'.$precio.'">'.$precio.'</td>'.
                                                                        '    <td class="numeric" data-title="PRECIO2"><input type="hidden" id="catalogo_articulo_list_price2" class="form-control" placeholder="Price 2" value="'.$precio2.'">'.$precio2.'</td>'.
                                                                        '    <td class="numeric" data-title="PRECIO3"><input type="hidden" id="catalogo_articulo_list_price3" class="form-control" placeholder="Price 3" value="'.$precio3.'">'.$precio3.'</td>'.
                                                                        //'    <td class="numeric" data-title="STOCK"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="'+OnHand+'"></td>'+
                                                                        //'    <td class="numeric" data-title="OFERTA"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="'+oferta+'"></td> '+
                                                                        //'    <td data-title="INI. OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_to_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                                                                        //'    <td data-title="FIN OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_from_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                                                                        //'    <td data-title="FLAG">'+flag+'</td>'+
                                                                        //'    <td data-title="image"></td>'+
                                                                        '</tr>';
                                                            }
                                                            echo $html;
                                                            ?><?php
                                                        }

                                                        ?>
                                                         </thead>
                                                    </table>
                                                </section>
                                            </div><!-- /content-panel -->
                                        </div><!-- /col-lg-12 -->
                                        <div class="col-lg-12">
                                            <br>
                                            <button type="button" class="btn btn-default" onclick="remover_articulo_todos();"><i class="fa fa-trash-o"></i> Borrar Todos</button>
                                        </div>
<!--                                        <div class="col-lg-6 text-right">
                                            <br>
                                            <h4>Total Articulos Cargados: <b id="catalogo_articulo_list_total_cargado"></b></h4></div>
                                        </div>-->
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                            <button type="button" class="btn btn-default" onclick="ir_a('catalogoIndex.php','')">Cancelar</button>
                                            <button type="button" class="btn btn-success" onclick="editar_flyer();">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- col-lg-12-->      	
                    </div><!-- /row -->
                    
                    
                </section>
            </section>

            <!--FOOTER-->
            <?php $obj_common->footer();?>
        
        </section>
        <!--JAVASCRIPT GENERAL-->
        <?php $obj_common->script();?>
        <!--JAVACRIPT LOCAL-->
        <!--ESTILO DE INPUT FILE-->
        <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
        <script src="../../assets/js/bootstrap-switch.js"></script>
        <script src="../../assets/js/sortTable.js"></script>
        <script src="../../assets/js/funcionesCat.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/tinycolor/0.11.1/tinycolor.min.js"></script>
        <script src="../../assets/bootstrap-colorpickersliders-master/bootstrap.colorpickersliders.js" type="text/javascript"></script>
        <script src="../../assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        
        <!--INICIALIZACION-->
        <script src="../js/flyer.js"></script>

        <script>
            $(document).ready(function(){


            $("#flyer_fondoEdit").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/flyerUpload.php",
                uploadAsync: false,
                maxFileCount: 1,
                
                 <?php if(isset($portada)){?>
                initialPreview: '<img src="<?php echo $portada;?>" class="file-preview-image" alt="Portada" title="Portada">'     
                <?php } ?>
            });


            });

        </script>
     
        <!--END SCRIPT-->
    </body>
</html>
