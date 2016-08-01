<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_bdmysql = new coBdmysql();
    $controller = 'ctCatalogo.php';
    $_SESSION['cod_img'] = 'def.jpg';
    $_SESSION['cod_img_fd'] = 'def.jpg';

    //$link = 'http://textronic.info/cat/cv?cd='.$id_catalogo;
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);

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
                    
                    
                    <h3><i class="fa fa-angle-right"></i> <a href="catalogoIndex.php">Catalogos</a> <i class="fa fa-angle-right"></i> Nuevo</h3>
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
                                                            <input type="text" id="catalogo_codigo" class="form-control">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="col-sm-2 col-sm-2 control-label">Fecha</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" value="<?php echo date('d/m/Y');?>" placeholder="Example: 01/01/1960" onkeyup="mascara(this,'/',patron,true);" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <label class="control-label">Descripcion</label>
                                                            <input type="text" id="catalogo_descripcion" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-sm-12" id="catalogo_img_fondo">
                                                        <label class="control-label">Fondo</label>
                                                            <input type="file" id="catalogo_fondo" name="catalogo_fondo" multiple=true class="file-loading">
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--FIN ACORDION 1-->
                                        
                                        <!--ACORDION 2-->
                                        <div class="panel panel-default">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                            <div class="panel-heading" style="background:#F5F5F5;">
                                                <h4 class="panel-title"><i class="fa fa-picture-o"></i> Producto</h4>
                                            </div>
                                            </a>
                                            <div id="collapse2" class="panel-collapse collapse">
                                                <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Nombre</label>
                                                            <input type="text" id="catalogo_codigo" class="form-control">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Part No.</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">

                                                        <div class="col-sm-6">
                                                            <label class=" control-label">Alias</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">XRef.</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">SMP</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">TOMCO</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">OEM</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price Name One</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price One</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price Name Two</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price Two</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price Name Three</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Price Three</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12" id="catalogo_img_fondo">
                                                        <label class="control-label">Imagen</label>
                                                            <input type="file" id="catalogo_fondo" name="catalogo_fondo" multiple=true class="file-loading">
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>                                                
                                        <!--FIN ACORDION 2-->
                                        
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
                                                        <div class="col-sm-4 text-right"><br><button type="button" class="btn btn-default" onclick="cargar_articulo();">Cargar</button></div>
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
                                            <div class="col-lg-3">
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1">Ordenar Por:</span>
                                                    <div class="input-group-btn">
                                                        <select id="catalogo_stock_cond" class="btn btn-default dropdown-toggle" onchange="ordenar_catalogo(this.value)">
                                                            <?php echo $catalogo_order;?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-control" style="height: 300px;overflow:auto;position:relative;">
                                                <div class="modal-loading" id="modal_carga" style="display:none;">Cargue articulos.</div>
                                                <section id="no-more-tables">
                                                    <table class="table table-bordered table-striped table-condensed cf" id="catalogo_articulo_list_carga_table">
                                                        <thead class="cf" id="catalogo_articulo_list_carga">
                                                        <tr>
                                                            <th>Borrar</th>
                                                            <th width="10%">SkuNo</th>
                                                            <th width="10%">PartNo</th>
                                                            <th>Articulo</th>
                                                            <th>Cat.</th>
                                                            <th>Sub Cat.</th>
                                                            <th class="numeric">Precio</th>
                                                            <th class="numeric">Stock</th>
                                                            <th class="numeric">Oferta</th>
                                                            <th>Ini. Oferta</th>
                                                            <th>Fin. Oferta</th>
                                                            <th>Flag</th>
                                                        </tr>
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
                                            <button type="button" class="btn btn-success" onclick="guardar_catalogo();">Guardar</button>
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
        <script>
            var order_id = '<?php echo $catalogo_order_id;?>';
            var order_columna = <?php echo $catalogo_order_columna;?>;
            var order_tipo = '<?php echo $catalogo_order_tipo;?>';
            if('<?php echo $catalogo_order_orden;?>' === 'false'){ var order_orden = false; }else{ var order_orden = true;} 
            
            $("#catalogo_portada").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/upload.php",
                uploadAsync: false,
                maxFileCount: 1
            });
            
            $("#catalogo_fondo").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/upload_bg.php",
                uploadAsync: false,
                maxFileCount: 1
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

                //$('#cat_vendido_desde').datepicker();
                //$('#cat_vendido_hasta').datepicker();

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
                            console.log(data);
                            if(data.mss === '1'){
                                $("#"+sub_cat_id).html(data.salida);
                            }else{ 
                                alert(data.mss);
                            }
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
                catalogo_flags = captura_valor_ch('catalogo_flags');
                catalogo_con_img = $('#catalogo_con_img').val();
                catalogo_tipo_inventario = $('#catalogo_sel_tipo_inv').val();
                catalogo_descontinuado = $('#catalogo_descontinuado').prop('checked');
                catalogo_ventaFrom = $('#cat_vendido_desde').val();
                catalogo_ventaTo = $('#cat_vendido_hasta').val();
                catalogo_articulo = $('#catalogo_articulo').val();

//                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                activa_preloader();
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
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
                        console.error(data);
                        modal_busqueda_sal = 'Realice una busqueda para mostrar articulos. '+data.mss;
//                        $('#modal_busqueda').html(modal_busqueda_sal);
                        $('#catalogo_articulo_list_busca').html();
                    }
                    desactiva_preloader();
                },"json");
                
            }
            
            //BUSCA ARTICULO PAGINADO
            function pagina_articulo(){
                opc = "catalogoArtBusca";
                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
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
            function guardar_catalogo(){
                opc = "catalogoGuardar";
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
                    ,"catalogo_codigo":catalogo_codigo
                    ,"catalogo_titulo":catalogo_titulo
                    ,"catalogo_descripcion":catalogo_descripcion
                    ,"catalogo_sel_precio_pdf":catalogo_sel_precio_pdf
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
                    console.log(data);
                    if(data.mss === '1'){
                        alert(data.salida);
                        ir_a('catalogoIndex.php','');
                    }else{ alert(data.mss); }
                    desactiva_preloader();
                },"json").fail(function(error, errormsg){
                    console.log("Error guardar_catalogo: " + errormsg);
                    desactiva_preloader();

                });

            }
            
            var ajaxProcess = false;
            function cancelar_ajax(){
                if(ajaxProcess){
                    ajaxProcess.abort();
                    desactiva_preloader();
                }
            }
        </script>
        <!--END SCRIPT-->
    </body>
</html>
