<?php

    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $obj_bdmysql = new coBdmysql();
    $controller = 'ctReport.php';
    $_SESSION['cod_img'] = 'def.jpg';
    $_SESSION['cod_img_fd'] = 'def.jpg';
    $id_catalogo = "";
    $catalogo_order = '';
    $catalogo_order_id = '1';
    $catalogo_order_selected = '';
    $catalogo_order_columna = 2;
    $catalogo_order_orden = false;
    $catalogo_order_tipo = "both";
    $catalogo_order_art = 'cod_art';
    $titulo_fuente = 'helvetica';
    $titulo_estilo = '';
    $titulo_tamano = 36;
    $titulo_color = 'rgb(0,0,0)';
    $titulo_hor = 'C';
    $titulo_ver = 'C';
    $link = 'http://textronic.info/cat/cv?cd='.$id_catalogo;
    $link_pdf = '../../assets/tcpdf/report/catalogo.php?id='.$obj_function->code_url($id_catalogo,'code');
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
    if (!$mysqli->connect_error){
        $mysqli2 = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli2->connect_error) {
            //FILTROS
            //INVENTARIO
            $list_inventario = '<option value="">Seleccione...</option>';
            //CATAGORIAS
            $list_categoria = '<option value="">Seleccione...</option>';
            $n_vehiculos = $obj_bdmysql->num_row("`codes cat`", "", $mysqli2);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes cat`", "*", "CatCode", "", "0,100",$mysqli2);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                foreach ($resul as $r){
                    $list_categoria.= '<option value="'.$r['CatCode'].'">'.$r['CatDesc'].'</option>';
                }
            }else{
                $list_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
            }

            //SUB-CATAGORIAS
            $list_sub_categoria = '<option value="">Seleccione...</option>';
            /*
            $list_sub_categoria = '<option value="">Seleccione...</option>';
            $n_vehiculos = $obj_bdmysql->num_row("`codes catsub`", "", $mysqli);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes catsub`", "*", "", "PrdCode", "0,100",$mysqli);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                foreach ($resul as $r){
                    $list_sub_categoria.= '<option value="'.$r['PrdCode'].'">'.$r['PrdCode'].' - '.$r['PrdDesc'].'</option>';
                }
            }else{
                $list_sub_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
            }
            */
            //FLAG        
            $list_flag = '';
            $n_vehiculos = $obj_bdmysql->num_row("`codes flag`", "FlagActive = '1'", $mysqli2);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes flag`", "*", "FlagActive = '1'", "Flag", "0,100",$mysqli2);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                $n_flag = 1;
                foreach ($resul as $r){
                    $list_flag.= $n_flag.') <input type="checkbox" id="catalogo_ch_'.$r['Flag'].'" value="'.$r['Flag'].'"> '.$r['Flag'].': '.$r['FlagDesc'].'<br>';
                    $n_flag = $n_flag + 1;
                }
            }else{
                $list_flag = 'NO SE ENCONTRARON DATOS';
            }
            //FIN FILTROS
            //DATOS DEL CATALOGO
            $mss = '';
            $mss_art = '';
            $n_cat = 1;
           // $n_cat= $obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli);
            if($n_cat > 0){
                $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul; }
                //CODIGO QR
                $codigo_qr = '../../common/codeqr/'.$id_catalogo.'.png';
                if(file_exists($codigo_qr)){  $img_cod_qr = '<img src="'.$codigo_qr.'" alt="QR" style="width:200px;height:200px;">';
                }else{ $img_cod_qr = 'QR NO ENCONTRADO.'; }
                //PORTADA
                if(trim($resul[0]['portada']) != ''){
                    $portada = '../../assets/bootstrap-fileinput-master/portadas/'.$resul[0]['portada'];
                }else{ $portada = '';}
                //FONDO
                if(trim($resul[0]['fondo']) != ''){
                    $fondo = '../../assets/bootstrap-fileinput-master/fondo/'.$resul[0]['fondo'];
                }else{ $fondo = '';}
                //MOSTRAR PRECIO EN EL PDF
                if($resul[0]['precio_pdf'] == '1'){
                    $ch_precio_pdf = 'checked';
                }else{ $ch_precio_pdf = ''; }
                
                //ESTILO DE TITULO
                if(trim($resul[0]['titulo_fuente']) != ''){ $titulo_fuente = $resul[0]['titulo_fuente']; }
                if(trim($resul[0]['titulo_tamano']) != ''){ $titulo_tamano = $resul[0]['titulo_tamano']; }
                if(trim($resul[0]['titulo_estilo']) != ''){ $titulo_estilo = $resul[0]['titulo_estilo']; }
                if(trim($resul[0]['titulo_color']) != ''){ if(preg_match(EXP_REG_RGB, $resul[0]['titulo_color'])){ $titulo_color = $resul[0]['titulo_color']; } }
//                if(trim($resul[0]['titulo_color']) != ''){ $titulo_color = $resul[0]['titulo_color']; }
                if(trim($resul[0]['titulo_ali_hor']) != ''){ $titulo_hor = $resul[0]['titulo_ali_hor']; }
                if(trim($resul[0]['titulo_ali_ver']) != ''){ $titulo_ver = $resul[0]['titulo_ali_ver']; }

                $selectedPlantilla5x3 = '';
                $selectedPlantilla5x4 = ''; 
                $selectedPlantilla4x4 = '';
                if(trim($resul[0]['presentacion'] == '5x3')){
                    $selectedPlantilla5x3 = 'selected';
                } else if(trim($resul[0]['presentacion'] == '4x4')){
                    $selectedPlantilla4x4 = 'selected';
                } else {
                    $selectedPlantilla5x4 = 'selected';
                }
                //ORDEN DE LOS ARTICULOS
                if ($resul[0]['order_id'] != ''){ $catalogo_order_id = $resul[0]['order_id']; }
                //LISTA DE ORDENAMIENTO DE ARTICULO
                $resul_order = $obj_bdmysql->select("catalogo_order","*","","id","",$mysqli);
                if(!is_array($resul_order)){ 
                    $catalogo_order = '<option value=""></option>'; 
                }else{
                    foreach ($resul_order as $r_order){
//                        echo $resul['order_id'].', '.$catalogo_order_id.' == '.$r_order['id'].'<br>';
                        //if($catalogo_order_id == $r_order['id']){
                        if(3 == $r_order['id']){
                            $catalogo_order_columna = $r_order['columna_tabla'];
                            $catalogo_order_orden = $r_order['reverse'];
                            $catalogo_order_tipo = $r_order['tipo_tabla'];
                            $catalogo_order_art = $r_order['order_art'];
                            $catalogo_order_selected = 'selected';
                        }
                        $valor = $r_order['id'].'_'.$r_order['columna_tabla'].'_'.$r_order['tipo_tabla'].'_'.$r_order['reverse'];
                        $catalogo_order.= '<option value="'.$valor.'" '.$catalogo_order_selected.'>'.$r_order['descripcion'].'</option>';
                        $catalogo_order_selected = '';
                    }
                }
                //LISTADO DE ARTICULOS
                $num_art = $obj_bdmysql->num_row("catalogo_reng","id_catalogo = '".$id_catalogo."'",$mysqli);
                $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'",$catalogo_order_art,"",$mysqli, false);  // PENDIETNE QUITAR LIMIT
                //PDFS
               // echo $resul_art;
//                echo $num_art.' '.CANT_ART_PDF;
               // if($num_art < CANT_ART_PDF){
                    $download_pdf='<h3><i class="fa fa-file-pdf-o"></i> <a href="'.$link_pdf.'&ind=0" target="_blank">Download</a></h3><br>';
               // }else{
                 /*   $ind_pdf = intval(($num_art/CANT_ART_PDF)+0.5);
                    $i_pdf = 0;
                    $download_pdf = '';
                    while ($i_pdf < $ind_pdf){
                        $pag_art = $i_pdf + 1;
                        $ver_pdf = 2;
                        if($i_pdf == 1){ $ver_pdf = 1; }
                        $download_pdf.='<h3><i class="fa fa-file-pdf-o"></i> <a href="'.$link_pdf.'&ind='.$i_pdf.'" target="_blank">Download '.$pag_art.'/'.$ind_pdf.'</a></h3>';
                        $i_pdf = $i_pdf + 1;
                    }
                }*/
                if(!is_array($resul_art)){ $mss_art = 'NO SE ENCONTRARON ARTICULOS EN EL CATALOGO. '; }
            }else{
                $mss = "NO SE ENCONTRO EL CATALOGO.";
            }
            //FIN DATOS DEL CATALOGO
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-fileinput-master/css/fileinput.css" />
    <link type="text/css" rel="stylesheet" media="all" href="../../assets/bootstrap-colorpickersliders-master/bootstrap.colorpickersliders.css">
    <link type="text/css" rel="stylesheet" media="all" href="../../assets/css/jquery-ui-1.9.2.custom.min.css">
    <head>
        <style type="text/css" media="screen">
            .resaltarTexto{
                color: #000000;
                background-color: #d5d5d5;
                font-weight: 600;
            }
        </style>    
    </head>
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
                    <h3><i class="fa fa-angle-right"></i> Reportes</h3>
                    <!-- BASIC FORM ELELEMNTS -->
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                            <h4 class="mb"><i class="fa fa-angle-right"></i> Reportes</h4>
                            <form class="form-horizontal style-form" method="get" id="catalogo_form">
                                <input type="hidden" id="catalogo_id" value="<?php echo $id_catalogo?>">
                                <!--CONTENIDO-->
                                <div class="panel-body">
                                    <div id="catalogo_filtro" class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">Categoria</label>
                                            <select class="form-control" id="catalogo_categoria"><?php echo $list_categoria;?></select>
                                            <div class="col-sm-6">
                                                <label class=" control-label">Sub-Categoria</label>
                                                <div id="catalogo_subcategoria" class="form-control" style="overflow:auto;height:150px;"><?php echo $list_sub_categoria;?></div>
                                            </div>															
                                            <!--<label class="control-label">Sub-Categoria</label>
                                            <select class="form-control" id="catalogo_subcategoria"><?php echo $list_sub_categoria;?></select>-->
                                            
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
                                            <div class="input-group col-sm-6">
                                                <input type="text" id="catalogo_stock" class="form-control" aria-label="..." onkeyup="mascara(this,'',patron7,true);">
                                                <div class="input-group-btn">
                                                    <select id="catalogo_stock_cond" class="btn btn-default dropdown-toggle">
                                                        <option value="="> = </option>
                                                        <option value="<"> < </option>
                                                        <option value=">"> > </option>
                                                        <option value="<="> <= </option>
                                                        <option value=">="> >= </option>
                                                    </select>
                                                </div>
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
                                                <input type="checkbox" id="catalogo_con_img" value="true" />
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
                                        <div class="col-sm-12">
                                            <label class="control-label">Referencia xref</label>
                                            <div class="input-group">
                                                <input type="text" id="busqueda_xref" class="form-control" placeholder="Indique Xref">
                                                <span class="input-group-btn"><button class="btn btn-default" type="button" onclick="buscar_xref();">Buscar</button></span>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                            <br>
                                                <div class="switch switch-square"
                                                    data-on-label="<i class=' fa fa-check'></i>"
                                                    data-off-label="<i class='fa fa-times'></i>">
                                                    <input type="checkbox" id="reporte_inicio"/>
                                                </div>
                                                <label style="font-size:20px;padding:4px;">inicio</label>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                            <br>
                                                <div class="switch switch-square"
                                                    data-on-label="<i class=' fa fa-check'></i>"
                                                    data-off-label="<i class='fa fa-times'></i>">
                                                    <input type="checkbox" id="reporte_contenga"/>
                                                </div>
                                                <label style="font-size:20px;padding:4px;">contenga</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon1">Ordenar Por:</span>
                                            <div class="input-group-btn">
                                                <select id="catalogo_orden_list2" class="btn btn-default dropdown-toggle" onchange="ordenar_catalogo(this.value)">
                                                    <?php echo $catalogo_order;?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="col-sm-4 text-right"><br>

                                       
                                            <button type="button" class="btn btn-default" onclick="Exportar_reporte();">Exportar Excel</button>
                                       

                                        </div>
                                        <div class="col-sm-4 text-right"><br><button type="button" class="btn btn-default" onclick="cargar_articulo();">Cargar</button></div>
                                        <div id="resul"></div>
                                    </div>
                                </div>
                                        <!--CONTENIDO-->
                                <br>
                                <div class="form-group">
                                    <div class="col-sm-12" align="right">
                                        <button type="button" class="btn btn-default" onclick="ir_a('catalogoIndex.php','')">Cancelar</button>
                                        <button type="button" class="btn btn-warning" onclick="editar_catalogo();">Guardar</button>
                                    </div>
                                </div>
                            </form>
                            <form id="exportExcel" action="../controllers/exportarExcel.php"  method="post" target="_blank" >
                                <input type="hidden" id="exportExcelData" name="lines" value="">
                                
                            </form>
                        </div>
                    </div><!-- col-lg-12-->      	
          	</div><!-- /row -->
                    
                    
                </section>
            </section>

            <!--FOOTER-->
            <?php $obj_common->footer();?>
        
        </section>


        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              ...
            </div>
          </div>
        </div>
        
        <!--JAVASCRIPT GENERAL-->
        <?php $obj_common->script();?>
        <!--JAVACRIPT LOCAL-->
        <!--ESTILO DE INPUT FILE-->
        <!--<script src="../../assets/tablesorter/jquery-latest.js"></script>-->
        <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
        <script src="../../assets/js/bootstrap-switch.js"></script>
        <script src="../../assets/js/sortTable.js"></script>
        <script src="../../assets/js/funcionesCat.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/tinycolor/0.11.1/tinycolor.min.js"></script>
        <script src="../../assets/bootstrap-colorpickersliders-master/bootstrap.colorpickersliders.js" type="text/javascript"></script>
        <!--<script src="../../assets/tablesorter/jquery.tablesorter.js"></script>-->
        <script src="../../assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <!--VARIABLES INICIALES-->


        <!-- FUNCION PARA RESALTAR -->

        <script type="text/javascript">
        jQuery.fn.extend({
            resaltar: function(busqueda, claseCSSbusqueda){
                var regex = new RegExp("(<[^>]*>)|("+ busqueda.replace(/([-.*+?^${}()|[\]\/\\])/g,"\\$1") +')', 'ig');
                var nuevoHtml=this.html(this.html().replace(regex, function(a, b, c){
                    return (a.charAt(0) == "<") ? a : "<span class=\""+ claseCSSbusqueda +"\">" + c + "</span>";
                }));
                return nuevoHtml;
            }
        });

        </script>


        <script>
            var order_id = '<?php echo $catalogo_order_id;?>';
            var order_columna = <?php echo $catalogo_order_columna;?>;
            var order_tipo = '<?php echo $catalogo_order_tipo;?>';
            if('<?php echo $catalogo_order_orden;?>' === 'false'){ var order_orden = false; }else{ var order_orden = true;}
            
            $("#catalogo_portada").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/upload.php",
                uploadAsync: false,
                maxFileCount: 1,
                <?php if(file_exists($portada)){?>
                initialPreview: '<img src="<?php echo $portada;?>" class="file-preview-image" alt="Portada" title="Portada">'     
                <?php } ?>
            });
            
            $("#catalogo_fondo").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/upload_bg.php",
                uploadAsync: false,
                maxFileCount: 1,
                <?php if(file_exists($fondo)){?>
                initialPreview: '<img src="<?php echo $fondo;?>" class="file-preview-image" alt="Portada" title="Portada">'     
                <?php } ?>
            });
            
            $("input#catalogo_titulo_color").ColorPickerSliders({
                size: 'sm',
                placement: 'right',
                swatches: false,
                sliders: false,
                hsvpanel: true
            });
        </script>
                
        <!--ACCIONES DEL FORMULARIO-->
        <script>
            $(document).ready(function(){


                            $( "#cat_vendido_desde" ).datepicker({
                      defaultDate: "+1w",
                      changeMonth: true,
                      dateFormat: 'yy-mm-dd',
                      //numberOfMonths: 3,
                      onClose: function( selectedDate ) {
                        $( "#cat_vendido_hasta" ).datepicker( "option", "minDate", selectedDate );
                      }
                    });
                    $( "#cat_vendido_hasta" ).datepicker({
                      defaultDate: "+1w",
                      changeMonth: true,
                      dateFormat: 'yy-mm-dd',
                      //numberOfMonths: 3,
                      onClose: function( selectedDate ) {
                        $( "#cat_vendido_desde" ).datepicker( "option", "maxDate", selectedDate );
                      }
                    });


                     $("#cat_vendido_hasta, #cat_vendido_desde").keyup(function(e) {
                        if(e.keyCode == 8 || e.keyCode == 46) {
                            $.datepicker._clearDate(this);
                        }
                    });


                // Selecciona todoas las subcategorias
                $('body').on('change', '#checkSubCategories', function(){
                    
                    $('#catalogo_subcategoria input[type=checkbox]').prop('checked', $(this).prop('checked'));
                });



                //CARGA SELECT SUBCATEGORIA DE A PARTIR DE LA CATEGORIA
                $("#catalogo_categoria").change(function() {
                    cat_val = this.value;
                    if(cat_val !== ''){
                        activa_preloader();
                        opc = "carga_subcategoria";
                        sub_cat_id = "catalogo_subcategoria";
                        $.post("../controllers/<?php echo $controller;?>",{
                             "opc":opc
                            ,"cat_val":cat_val
                        },function(data){
                            if(data.mss === '1'){
                                $("#"+sub_cat_id).html(data.salida);
                            }else{ alert(data.mss); }
                            desactiva_preloader();
                        },"json");
                    }else{
                        $("#"+sub_cat_id).html('<?php echo $list_sub_categoria;?>');
                    }
                });
                
                //MARCA O DESMARCA TODOS LOS CH DELARTICULO               
                $("#catalogo_sel_all").change(function () {
                    sel_all($(this).is(':checked'));
                });
                
                //INDICA CUANTOS ARTICULOS ESTAN CARGADOS;
                cantidad_articulos_catalogo();
                
                //VALORES SELECT
                document.getElementById('catalogo_titulo_fuente').value = '<?php echo $titulo_fuente;?>';
                document.getElementById('catalogo_titulo_estilo').value = '<?php echo $titulo_estilo;?>';
                document.getElementById('catalogo_titulo_ali_hor').value = '<?php echo $titulo_hor;?>';
                document.getElementById('catalogo_titulo_ali_ver').value = '<?php echo $titulo_ver;?>';
            });
            
            //BUSCA ARTICULO
            var filtro = '';
            var n_pag = 0;
            var n_elem_pag = 10;
            var catalogo_categoria = '';
            var catalogo_subcategoria = '';
            var catalogo_subcategoria_desc = '';
            var catalogo_stock = '';
            var catalogo_stock_cond = '';
            var catalogo_flags = '';
            function buscar_articulo(){

                catalogo_subcategoria_desc='';

				$('#catalogo_subcategoria').children('input').each(function(){
					if(this.checked == true){
						if(catalogo_subcategoria != ''){
							//catalogo_subcategoria_desc += ",";
							//catalogo_subcategoria_desc += "'" + $(this).next('label').text() + "'";
							catalogo_subcategoria += ",";
							catalogo_subcategoria += this.value;
						}else{
							//catalogo_subcategoria_desc += "'" + $(this).next('label').text() + "'";
							catalogo_subcategoria += this.value;
						}
					}					
				});

                console.log(catalogo_subcategoria_desc);
                filtro = '';
                n_pag = 0;
                n_pag = n_pag;
                resul_n = 0;
                opc = "catalogoArtBusca";
                catalogo_categoria = forma_cad(document.getElementById('catalogo_categoria').value);
                //catalogo_subcategoria = forma_cad(document.getElementById('catalogo_subcategoria').value);
                //catalogo_subcategoria_desc = $("#catalogo_subcategoria option:selected").text();
                catalogo_stock = forma_cad(document.getElementById('catalogo_stock').value);
                catalogo_stock_cond = forma_cad(document.getElementById('catalogo_stock_cond').value);
//                catalogo_stock_dts = forma_cad(document.getElementById('catalogo_stock_dts').value);
//                catalogo_stock_cond_dts = forma_cad(document.getElementById('catalogo_stock_cond_dts').value);
                catalogo_flags = captura_valor_ch('catalogo_flags');
                catalogo_con_img = $('#catalogo_con_img').val();
                catalogo_tipo_inventario = $('#catalogo_sel_tipo_inv').val();
                catalogo_descontinuado = $('#catalogo_descontinuado').prop('checked');
                catalogo_ventaFrom = $('#cat_vendido_desde').val();
                catalogo_ventaTo = $('#cat_vendido_hasta').val();
                catalogo_articulo = $('#catalogo_articulo').val();
           
//                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                activa_preloader();
                console.log(catalogo_subcategoria_desc);
              /// console.log("cargando articulos: <?php echo $controller;?>");
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
                    ,"art_val":""
                    ,"catalogo_categoria":catalogo_categoria
                    ,"catalogo_subcategoria":catalogo_subcategoria
                    ,"catalogo_subcategoria_desc":catalogo_subcategoria_desc
                    ,"catalogo_stock":catalogo_stock
                    ,"catalogo_stock_cond":catalogo_stock_cond
//                    ,"catalogo_stock_dts":catalogo_stock_dts
//                    ,"catalogo_stock_cond_dts":catalogo_stock_cond_dts
                    ,"catalogo_flags":catalogo_flags
                    ,"n_pag":n_pag
                    , "catalogo_tipo_inventario":catalogo_tipo_inventario
                    , "catalogo_descontinuado":catalogo_descontinuado
                    , "catalogo_ventaFrom" : catalogo_ventaFrom
                    , "catalogo_ventaTo" : catalogo_ventaTo
                    , "catalogo_articulo" : catalogo_articulo
                },function(data){
                   // alert(data);
                    if(data.mss === '1'){
                        $('#catalogo_articulo_list_busca').html(contruirArticulos(data.salida));
                        n_pag = 1;
                        modal_busqueda_sal = '';
                        //CUENTA ARTICULOS BUSQUEDA
                        cantidad_articulos_catalogo_busqueda();
                        //MARCA O DESMARCA
                        sel_all($("#catalogo_sel_all").is(':checked'));
                        //DASACTIVA LOS ARTICULOS QUE YA SE ENCUENTREN EN EL CATALOGO
                        desactiva_cargados('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
                    }else{ 
                        alert(data.mss);
                        console.log(data.mss);
                        modal_busqueda_sal = 'Realice una busqueda para mostrar articulos. ';
//                        $('#modal_busqueda').html(modal_busqueda_sal);
                        $('#catalogo_articulo_list_busca').html();
                    }


                    $('.resultInput').resaltar($('#catalogo_articulo').val(), 'resaltarTexto');

                    desactiva_preloader();
                },"json").fail(function(error, errorText){
                  
                    console.log('ERROR: ' + errorText);
                });
                    
            }



            function buscar_xref(){
                // alert("Bus");

                xref = $("#busqueda_xref").val();
                valorInicial = $('#reporte_inicio').is(':checked');
                valorContenido = $('#reporte_contenga').is(':checked');
                filtro = '';
                n_pag = 0;
                n_pag = n_pag;
                resul_n = 0;
                opc = "busquedaXref";
                
                catalogo_categoria = forma_cad(document.getElementById('catalogo_categoria').value);
                //catalogo_subcategoria = forma_cad(document.getElementById('catalogo_subcategoria').value);
                //catalogo_subcategoria_desc = $("#catalogo_subcategoria option:selected").text();
                catalogo_stock = forma_cad(document.getElementById('catalogo_stock').value);
                catalogo_stock_cond = forma_cad(document.getElementById('catalogo_stock_cond').value);
//                catalogo_stock_dts = forma_cad(document.getElementById('catalogo_stock_dts').value);
//                catalogo_stock_cond_dts = forma_cad(document.getElementById('catalogo_stock_cond_dts').value);
                catalogo_flags = captura_valor_ch('catalogo_flags');
                catalogo_con_img = $('#catalogo_con_img').val();
                catalogo_tipo_inventario = $('#catalogo_sel_tipo_inv').val();
                catalogo_descontinuado = $('#catalogo_descontinuado').prop('checked');
                catalogo_ventaFrom = $('#cat_vendido_desde').val();
                catalogo_ventaTo = $('#cat_vendido_hasta').val();
                catalogo_articulo = $('#catalogo_articulo').val();
           
//                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                activa_preloader();
                console.log(catalogo_subcategoria_desc);

                $.post("../controllers/<?php echo $controller;?>", {
                    "xref":xref
                    ,"inicial": valorInicial
                    ,"contenga": valorContenido
                    ,"opc":opc
                    ,"art_val":""
                    ,"catalogo_categoria":catalogo_categoria
                    ,"catalogo_subcategoria":catalogo_subcategoria
                    ,"catalogo_subcategoria_desc":catalogo_subcategoria_desc
                    ,"catalogo_stock":catalogo_stock
                    ,"catalogo_stock_cond":catalogo_stock_cond
                    ,"catalogo_flags":catalogo_flags
                    ,"n_pag":n_pag
                    , "catalogo_tipo_inventario":catalogo_tipo_inventario
                    , "catalogo_descontinuado":catalogo_descontinuado
                    , "catalogo_ventaFrom" : catalogo_ventaFrom
                    , "catalogo_ventaTo" : catalogo_ventaTo
                    , "catalogo_articulo" : catalogo_articulo
                },function(data){
                   // alert(data);
                    if(data.mss === '1'){
                        $('#catalogo_articulo_list_busca').html(contruirReporte(data.salida));
                        n_pag = 1;
                        modal_busqueda_sal = '';
                        //CUENTA ARTICULOS BUSQUEDA
                        cantidad_articulos_catalogo_busqueda();
                        //MARCA O DESMARCA
                        sel_all($("#catalogo_sel_all").is(':checked'));
                        //DASACTIVA LOS ARTICULOS QUE YA SE ENCUENTREN EN EL CATALOGO
                        desactiva_cargados('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
                    }else{ 
                        alert(data.mss);
                        console.log(data.mss);
                        modal_busqueda_sal = 'Realice una busqueda para mostrar articulos. ';
//                        $('#modal_busqueda').html(modal_busqueda_sal);
                        $('#catalogo_articulo_list_busca').html();
                    }
                    $('.resultInput').resaltar($('#busqueda_xref').val(), 'resaltarTexto');
                    desactiva_preloader();
                },"json").fail(function(error, errorText){
                  
                    console.log('ERROR: ' + errorText);
                });
            }
            
            //BUSCA ARTICULO PAGINADO
            function pagina_articulo(){
                opc = "catalogoArtBusca";
                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
                    ,"art_val":""
                    ,"catalogo_categoria":catalogo_categoria
                    ,"catalogo_subcategoria":catalogo_subcategoria
                    ,"catalogo_subcategoria_desc":catalogo_subcategoria_desc
                    ,"catalogo_stock":catalogo_stock
                    ,"catalogo_stock_cond":catalogo_stock_cond
                    ,"catalogo_flags":catalogo_flags
                    ,"n_pag":n_pag
                },function(data){
                    if(data.mss === '1'){
                        $('#catalogo_articulo_list_busca').append(data.salida);
                        //MARCA O DESMARCA
                        sel_all($("#catalogo_sel_all").is(':checked'));
                        //DASACTIVA LOS ARTICULOS QUE YA SE ENCUENTREN EN EL CATALOGO
                        desactiva_cargados('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
                        n_pag = n_pag+1;
                    }else{ 
                        alert(data.mss);
                    }
                    $('#modal_busqueda').html('').fadeOut('fast');
                },"json");
            }
            
            //GUARDA_CATALOGO
            function editar_catalogo(){
                
                if ($("#catalogo_img_portada .file-preview-image").length > 0){ catalogo_img_portada_del = 1;
                }else{ catalogo_img_portada_del = 0; }
                if ($("#catalogo_img_fondo .file-preview-image").length > 0){ catalogo_img_fondo_del = 1;
                }else{ catalogo_img_fondo_del = 0; }
                
                opc = "catalogoEditar";
                catalogo_id = forma_cad(document.getElementById('catalogo_id').value);
                catalogo_codigo = forma_cad(document.getElementById('catalogo_codigo').value);
                catalogo_titulo = forma_cad(document.getElementById('catalogo_titulo').value);
                catalogo_descripcion = forma_cad(document.getElementById('catalogo_descripcion').value);
                catalogo_titulo_fuente = forma_cad(document.getElementById('catalogo_titulo_fuente').value);
                catalogo_titulo_tamano = forma_cad(document.getElementById('catalogo_titulo_tamano').value);
                catalogo_titulo_color = forma_cad(document.getElementById('catalogo_titulo_color').value);
                catalogo_titulo_estilo = forma_cad(document.getElementById('catalogo_titulo_estilo').value);
                catalogo_titulo_ali_hor = forma_cad(document.getElementById('catalogo_titulo_ali_hor').value);
                catalogo_titulo_ali_ver = forma_cad(document.getElementById('catalogo_titulo_ali_ver').value);
                catalogo_sel_presentacion = $('#catalogo_sel_presentacion').val();
                if($("#catalogo_sel_precio_pdf").is(':checked')){ catalogo_sel_precio_pdf = 1;
                }else{ catalogo_sel_precio_pdf = 0; }
                articulos = captura_valor_class_hijos('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
                activa_preloader();
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
                    ,"catalogo_id":catalogo_id
                    ,"catalogo_codigo":catalogo_codigo
                    ,"catalogo_titulo":catalogo_titulo
                    ,"catalogo_descripcion":catalogo_descripcion
                    ,"catalogo_sel_precio_pdf":catalogo_sel_precio_pdf
                    ,"catalogo_img_portada_del":catalogo_img_portada_del
                    ,"catalogo_img_fondo_del":catalogo_img_fondo_del
                    ,"catalogo_order_id":order_id
                    ,"catalogo_titulo_fuente":catalogo_titulo_fuente
                    ,"catalogo_titulo_tamano":catalogo_titulo_tamano
                    ,"catalogo_titulo_color":catalogo_titulo_color
                    ,"catalogo_titulo_estilo":catalogo_titulo_estilo
                    ,"catalogo_titulo_ali_hor":catalogo_titulo_ali_hor
                    ,"catalogo_titulo_ali_ver":catalogo_titulo_ali_ver
                    ,"articulos":articulos
                    ,"catalogo_sel_presentacion":catalogo_sel_presentacion
                },function(data){
                   // alert(data);
                    if(data.mss === '1'){
                        alert(data.salida);
                    }else{ alert(data.mss); }
                    desactiva_preloader();
                },"json");
            }


        </script>
        <!--END SCRIPT-->
    </body>
</html>