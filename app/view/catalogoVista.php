<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $obj_bdmysql = new coBdmysql();
    $controller = 'ctCatalogo.php';
    $_SESSION['cod_img'] = 'def.jpg';
    $_SESSION['cod_img_fd'] = 'def.jpg';
    $id_catalogo = $obj_function->code_url($_GET['id'],'decode');
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
            $n_cat= $obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli);
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
                //ORDEN DE LOS ARTICULOS
                if ($resul[0]['order_id'] != ''){ $catalogo_order_id = $resul[0]['order_id']; }
                //LISTA DE ORDENAMIENTO DE ARTICULO
                $resul_order = $obj_bdmysql->select("catalogo_order","*","","id","",$mysqli);
                if(!is_array($resul_order)){ 
                    $catalogo_order = '<option value=""></option>'; 
                }else{
                    foreach ($resul_order as $r_order){
//                        echo $resul['order_id'].', '.$catalogo_order_id.' == '.$r_order['id'].'<br>';
                        if($catalogo_order_id == $r_order['id']){
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
                $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'",$catalogo_order_art,"",$mysqli);
                //PDFS
//                echo $num_art.' '.CANT_ART_PDF;
                if($num_art < CANT_ART_PDF){
                    $download_pdf='<h3><i class="fa fa-file-pdf-o"></i> <a href="'.$link_pdf.'&ind=0" target="_blank">Download</a></h3><br>';
                }else{
                    $ind_pdf = intval(($num_art/CANT_ART_PDF)+0.5);
                    $i_pdf = 0;
                    $download_pdf = '';
                    while ($i_pdf < $ind_pdf){
                        $pag_art = $i_pdf + 1;
                        $ver_pdf = 2;
                        if($i_pdf == 1){ $ver_pdf = 1; }
                        $download_pdf.='<h3><i class="fa fa-file-pdf-o"></i> <a href="'.$link_pdf.'&ind='.$i_pdf.'" target="_blank">Download '.$pag_art.'/'.$ind_pdf.'</a></h3>';
                        $i_pdf = $i_pdf + 1;
                    }
                }
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
                    
                    
                    <h3><i class="fa fa-angle-right"></i> <a href="catalogoIndex.php">Catalogos</a> <i class="fa fa-angle-right"></i> Editar</h3>
                    <!-- BASIC FORM ELELEMNTS -->
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                            <h4 class="mb"><i class="fa fa-angle-right"></i> Datos del Catalogo</h4>
                            <form class="form-horizontal style-form" method="get" id="catalogo_form">
                                <input type="hidden" id="catalogo_id" value="<?php echo $id_catalogo?>">
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
                                                            <label class="control-label">Codigo</label>
                                                            <input type="text" id="catalogo_codigo" class="form-control" value="<?php echo $resul[0]['codigo']?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="col-sm-2 col-sm-2 control-label">Fecha</label>
                                                            <input type="text" id="catalogo_fecha" class="form-control" value="<?php echo $resul[0]['fe_us_in_dmy']?>" placeholder="Example: 01/01/1960" onkeyup="mascara(this,'/',patron,true);" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <label class="control-label">Titulo</label>
                                                            <input type="text" id="catalogo_titulo" class="form-control" value="<?php echo $resul[0]['titulo']?>">
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Fuente</label>
                                                            <select id="catalogo_titulo_fuente" class="form-control">
                                                                <option value="courier">Courier</option>
                                                                <option value="times">Times</option>
                                                                <option value="helvetica">Helvetica</option>
                                                                <option value="symbol">Symbol</option>
                                                                <option value="zapfdingbats">Zapf Dingbats</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Tamano</label>
                                                            <input type="text" id="catalogo_titulo_tamano" class="form-control" value="<?php echo $titulo_tamano;?>" onkeyup="mascara(this,'',patron7,true);">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Color</label>
                                                            <input type="text" id="catalogo_titulo_color" class="form-control" value="<?php echo $titulo_color;?>">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Estilo</label>
                                                            <select id="catalogo_titulo_estilo" class="form-control">
                                                                <option value="">Regular</option>
                                                                <option value="B">Bold</option>
                                                                <option value="BI">Bold Italic</option>
                                                                <option value="I">Italic</option>
                                                            </select>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Alineacion Horizontal</label>
                                                            <select id="catalogo_titulo_ali_hor" class="form-control">
                                                                <option value="C">Centro</option>
                                                                <option value="L">Izquierda</option>
                                                                <option value="R">Derecha</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="control-label">Alineacion Vertical</label>
                                                            <select id="catalogo_titulo_ali_ver" class="form-control">
                                                                <option value="C">Centro</option>
                                                                <option value="T">Arriba</option>
                                                                <option value="B">Abajo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <label class="control-label">Descripcion</label>
                                                        <input type="text" id="catalogo_descripcion" class="form-control" value="<?php echo $resul[0]['descripcion']?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                        <br>
                                                        <label class="control-label">Mostrar Precio en PDF</label>
                                                        <br>
                                                        <div class="switch switch-square"
                                                            data-on-label="<i class=' fa fa-check'></i>"
                                                            data-off-label="<i class='fa fa-times'></i>">
                                                           <input type="checkbox" id="catalogo_sel_precio_pdf" <?php echo $ch_precio_pdf;?>/>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6">
                                                            <label class="control-label">Catalogo PDF</label>
                                                            <?php echo $download_pdf;?>
                                                        </div>
                                                        <div class="col-sm-6">
                                                        <label class="control-label">Catalogo Virtual</label>
                                                        <h3><i class="fa fa-desktop"></i> <a href="<?php echo $link;?>" target="_blank"><?php echo $link;?></a></h3>
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
                                                <h4 class="panel-title"><i class="fa fa-picture-o"></i> IMAGENES</h4>
                                            </div>
                                            </a>
                                            <div id="collapse2" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <div class="col-sm-12" id="catalogo_img_portada">
                                                            <label class="control-label">Portada</label>
                                                            <input type="file" id="catalogo_portada" name="catalogo_portada" multiple=true class="file-loading">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12" id="catalogo_img_fondo">
                                                            <label class="control-label">Fondo</label>
                                                            <input type="file" id="catalogo_fondo" name="catalogo_fondo" multiple=true class="file-loading">
                                                        </div>
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
                                                            <label class="control-label">Sub-Categoria</label>
                                                            <select class="form-control" id="catalogo_subcategoria"><?php echo $list_sub_categoria;?></select>
                                                            <label class="control-label">Stock</label>
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
                                                                </div>
                                                            </div>
<!--                                                            <label class="control-label">Stock DTS</label>
                                                            <div class="input-group">
                                                                <input type="text" id="catalogo_stock_dts" class="form-control" aria-label="..." onkeyup="mascara(this,'',patron7,true);">
                                                                <div class="input-group-btn">
                                                                    <select id="catalogo_stock_cond_dts" class="btn btn-default dropdown-toggle">
                                                                        <option value="="> = </option>
                                                                        <option value="<"> < </option>
                                                                        <option value=">"> > </option>
                                                                        <option value="<="> <= </option>
                                                                        <option value=">="> >= </option>
                                                                    </select>
                                                                </div>
                                                            </div>-->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class=" control-label">Flag</label>
                                                            <div id="catalogo_flags" class="form-control" style="overflow:auto;height:150px;"><?php echo $list_flag;?></div>
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
                                                        <select id="catalogo_orden_list" class="btn btn-default dropdown-toggle" onchange="ordenar_catalogo(this.value)">
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
                                                        <?php 
                                                        if($mss_art != ''){?>
                                                        <tr><td colspan="7"><?php echo $mss_art;?></td></tr>
                                                        <?php    
                                                         }else{
                                                            foreach ($resul_art as $r_art){
                                                                $SkuNo = trim($r_art['cod_art']);
                                                                $precio = trim($r_art['precio']);
                                                                $OnHand = trim($r_art['stock_ini']);
                                                                $oferta = trim($r_art['oferta']);
                                                                $where ="SkuNo = '".$SkuNo."'";
                                                                $campos = "*,'00/00/0000' as fe_oferta_dmy,(SELECT CatDesc FROM `codes cat` WHERE `codes cat`.CatCode = g_inventory.CatCode) as CatDesc, PrdCode as PrdDesc";
                                                                $resul = $obj_bdmysql->select("g_inventory", $campos, $where, "ProdDesc", "",$mysqli2);
                                                                if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$SkuNo; 
                                                                }else{
                                                                    foreach ($resul as $r_art2){
                                                                        $PartNo = $r_art2['PartNo'];
                                                                        $ProdDesc = $r_art2['ProdDesc'];
                                                                        $CatDesc = $r_art2['CatDesc'];
                                                                        $PrdDesc = $r_art2['PrdDesc'];

                                                                        //DEFINE FLAG
                                                                        $flag = '';
                                                                        if($r_art2['Flag01'] == '1'){ $flag.= 'Flag01, '; }
                                                                        if($r_art2['Flag02'] == '1'){ $flag.= 'Flag02, '; }
                                                                        if($r_art2['Flag03'] == '1'){ $flag.= 'Flag03, '; }
                                                                        if($r_art2['Flag04'] == '1'){ $flag.= 'Flag04, '; }
                                                                        if($r_art2['Flag05'] == '1'){ $flag.= 'Flag05, '; }
                                                                        if($r_art2['Flag06'] == '1'){ $flag.= 'Flag06, '; }
                                                                        if($r_art2['Flag07'] == '1'){ $flag.= 'Flag07, '; }
                                                                        if($r_art2['Flag08'] == '1'){ $flag.= 'Flag08, '; }
                                                                        if($r_art2['Flag09'] == '1'){ $flag.= 'Flag09, '; }
                                                                        if($r_art2['Flag10'] == '1'){ $flag.= 'Flag10, '; }
                                                                        if(trim($flag) != ''){ $flag = str_replace(', _', '', $flag.'_'); }else{ $flag = 'No Aplica'; }

                                                                        //DEFINE OFERTAS
                                                                        $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$SkuNo."'", "ID", "1",$mysqli2);
                                                                        if(!is_array($resul_oferta)){ $oferta = '0'; $fecha_to_oferta = '00/00/0000'; $fecha_from_oferta = '00/00/0000'; 
                                                                        }else{    $oferta = $resul_oferta[0]['Precio']; $fecha_to_oferta = $resul_oferta[0]['Date_To_dma']; $fecha_from_oferta = $resul_oferta[0]['Date_From_dma'];   }

                                                                    }
                                                                }
                                                        ?>
                                                        <tr class="catalogo_articulo_fila_carga" id="catalogo_articulo_fila_carga_<?php echo $SkuNo;?>">
                                                            <td data-title="remove" id="catalogo_articulo_list_remove_<?php echo $SkuNo;?>" style="text-align:center;" onclick="remover_articulo(this.id);"><i class="fa fa-trash-o" style="font-size:18px"></i></td>
                                                            <td data-title="CODIGO" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="<?php echo $SkuNo;?>"><?php echo $SkuNo;?></td>
                                                            <td data-title="PARTNO"><input type="hidden" id="catalogo_articulo_list_partno" value="<?php echo $PartNo;?>"><?php echo $PartNo;?></td>
                                                            <td data-title="ARTICULO"><input type="hidden" id="catalogo_articulo_list_proddesc" value="<?php echo $ProdDesc;?>"><?php echo $ProdDesc;?></td>
                                                            <td data-title="CATEGORIA"><?php echo $CatDesc;?></td>
                                                            <td data-title="SUB CATEGORIA"><?php echo $PrdDesc;?></td>
                                                            <td class="numeric" data-title="PRECIO"><input type="text" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="<?php echo $precio;?>" style="width:80px;"></td>
                                                            <td class="numeric" data-title="STOCK"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="<?php echo $OnHand;?>" style="width:80px;"></td> 
                                                            <td class="numeric" data-title="OFERTA"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="<?php echo $oferta;?>" style="width:80px;"></td> 
                                                            <td data-title="INI. OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="<?php echo $fecha_to_oferta;?>" onkeyup="mascara(this,'/',patron,true);" style="width:100px;"></td>
                                                            <td data-title="FIN OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="<?php echo $fecha_from_oferta;?>" onkeyup="mascara(this,'/',patron,true);" style="width:100px;"></td>
                                                            <td data-title="Date Sale"><?php echo $flag;?></td>
                                                        </tr>    
                                                        <?php
                                                            }
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
                                        <!--<div class="col-lg-12"><h4>Total Articulos Cargados: <b id="catalogo_articulo_list_total_cargado"></b></h4></div>-->
                                    </div>
                                <br>
                                <div class="form-group">
                                    <div class="col-sm-12" align="right">
                                        <button type="button" class="btn btn-default" onclick="ir_a('catalogoIndex.php','')">Cancelar</button>
                                        <button type="button" class="btn btn-warning" onclick="editar_catalogo();">Guardar</button>
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
        <!--<script src="../../assets/tablesorter/jquery-latest.js"></script>-->
        <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
        <script src="../../assets/js/bootstrap-switch.js"></script>
        <script src="../../assets/js/sortTable.js"></script>
        <script src="../../assets/js/funcionesCat.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/tinycolor/0.11.1/tinycolor.min.js"></script>
        <script src="../../assets/bootstrap-colorpickersliders-master/bootstrap.colorpickersliders.js" type="text/javascript"></script>
        <!--<script src="../../assets/tablesorter/jquery.tablesorter.js"></script>-->
        <!--VARIABLES INICIALES-->
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
                filtro = '';
                n_pag = 0;
                n_pag = n_pag;
                resul_n = 0;
                opc = "catalogoArtBusca";
                catalogo_categoria = forma_cad(document.getElementById('catalogo_categoria').value);
                catalogo_subcategoria = forma_cad(document.getElementById('catalogo_subcategoria').value);
                catalogo_subcategoria_desc = $("#catalogo_subcategoria option:selected").text();
                catalogo_stock = forma_cad(document.getElementById('catalogo_stock').value);
                catalogo_stock_cond = forma_cad(document.getElementById('catalogo_stock_cond').value);
//                catalogo_stock_dts = forma_cad(document.getElementById('catalogo_stock_dts').value);
//                catalogo_stock_cond_dts = forma_cad(document.getElementById('catalogo_stock_cond_dts').value);
                catalogo_flags = captura_valor_ch('catalogo_flags');

                console.log();
//                $('#modal_busqueda').html('Cargando...').fadeIn('fast');
                activa_preloader();
              /// console.log("cargando articulos: <?php echo $controller;?>");
                $.post("../controllers/<?php echo $controller;?>",{
                     "opc":opc
                    ,"catalogo_categoria":catalogo_categoria
                    ,"catalogo_subcategoria":catalogo_subcategoria
                    ,"catalogo_subcategoria_desc":catalogo_subcategoria_desc
                    ,"catalogo_stock":catalogo_stock
                    ,"catalogo_stock_cond":catalogo_stock_cond
//                    ,"catalogo_stock_dts":catalogo_stock_dts
//                    ,"catalogo_stock_cond_dts":catalogo_stock_cond_dts
                    ,"catalogo_flags":catalogo_flags
                    ,"n_pag":n_pag
                },function(data){
                    alert(data);
                    if(data.mss === '1'){
                        $('#catalogo_articulo_list_busca').html(data.salida);
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
                        modal_busqueda_sal = 'Realice una busqueda para mostrar articulos. ';
//                        $('#modal_busqueda').html(modal_busqueda_sal);
                        $('#catalogo_articulo_list_busca').html();
                    }
                    desactiva_preloader();
                },"json").fail(function(error){
                    console.log('ERROR: ' + error);
                });
                    
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
                },function(data){
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