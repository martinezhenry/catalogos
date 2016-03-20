<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_bdmysql = new coBdmysql();
    $_SESSION['cod_img'] = 'np';
    $_SESSION['cod_img_fd'] = 'np';
    
//    $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
//    $resul = $obj_bdmysql->select("`codes cat`","*","","CatCode Desc","0,10",$mysqli);
////    $resul = $obj_bdmysql->select("g_inventory","*","","","0,10",$mysqli);
//    if(!is_array($resul)){ echo 'ERROR EN CONEXION';
//    }else{
//        echo $resul[0]['CatCode'];
////        echo $resul[0]['SkuNo'];
//    }
    $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
    if (!$mysqli->connect_error){
        //CATAGORIAS
        $list_categoria = '<option value="">Seleccione...</option>';
        $n_vehiculos = $obj_bdmysql->num_row("`codes cat`", "", $mysqli);
        if($n_vehiculos > 0){
            $resul = $obj_bdmysql->select("`codes cat`", "*", "CatCode", "", "0,100",$mysqli);
            if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
            foreach ($resul as $r){
                $list_categoria.= '<option value="'.$r['CatCode'].'">'.$r['CatCode'].' - '.$r['CatDesc'].'</option>';
            }
        }else{
            $list_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
        }
        //SUB-CATAGORIAS
//        $list_sub_categoria = '<option value="">Seleccione...</option>';
//        $n_vehiculos = $obj_bdmysql->num_row("`codes catsub`", "", $mysqli);
//        if($n_vehiculos > 0){
//            $resul = $obj_bdmysql->select("`codes catsub`", "*", "", "PrdCode", "0,100",$mysqli);
//            if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
//            foreach ($resul as $r){
//                $list_sub_categoria.= '<option value="'.$r['PrdCode'].'">'.$r['PrdCode'].' - '.$r['PrdDesc'].'</option>';
//            }
//        }else{
//            $list_sub_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
//        }
        //FLAG
        $list_flag = '';
        $n_vehiculos = $obj_bdmysql->num_row("`codes flag`", "FlagActive = '1'", $mysqli);
        if($n_vehiculos > 0){
            $resul = $obj_bdmysql->select("`codes flag`", "*", "FlagActive = '1'", "Flag", "0,100",$mysqli);
            if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
            $n_flag = 1;
            foreach ($resul as $r){
                $list_flag.= $n_flag.') <input type="checkbox" id="" value="'.$r['Flag'].'"> '.$r['FlagDesc'].'<br>';
                $n_flag = $n_flag + 1;
            }
        }else{
            $list_flag = 'NO SE ENCONTRARON DATOS';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap-fileinput-master/css/fileinput.css" />
    <link rel="stylesheet" type="text/css" href="../../assets/css/typeahead.css" />
    
    <body>

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
                              <h4 class="mb"><i class="fa fa-angle-right"></i> Datos del Catalogo</h4>
                          <form class="form-horizontal style-form" method="get" id="catalogo_form">
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Codigo</label>
                                  <div class="col-sm-10">
                                      <input type="text" id="catalogo_codigo" class="form-control">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Titulo</label>
                                  <div class="col-sm-10">
                                      <input type="text" id="catalogo_titulo" class="form-control">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Descripcion</label>
                                  <div class="col-sm-10">
                                      <input type="text" id="catalogo_descripcion" class="form-control">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Fecha</label>
                                  <div class="col-sm-10">
                                      <input type="text" id="catalogo_fecha" class="form-control" value="<?php echo date('d/m/Y');?>" placeholder="Example: 01/01/1960" onkeyup="mascara(this,'/',patron,true);" readonly>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Portada</label>
                                  <div class="col-sm-10">
                                      <input type="file" id="catalogo_portada" name="catalogo_portada" multiple=true class="file-loading">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Fondo</label>
                                  <div class="col-sm-10">
                                      <input type="file" id="catalogo_fondo" name="catalogo_fondo" multiple=true class="file-loading">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">Fitro</label>
                                  <div class="col-sm-10">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-6">
                                                <label class="col-sm-12 control-label">Categoria</label>
                                                <select class="form-control" id="catalogo_categoria"><?php echo $list_categoria;?></select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-sm-12 control-label">Sub-Categoria</label>
                                                <select class="form-control" id="catalogo_subcategoria"><?php echo $list_sub_categoria;?></select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-sm-12 control-label">Flag</label>
                                                <div class="form-control col-sm-12" style="overflow:auto;height:80px;"><?php echo $list_flag;?></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="col-sm-12 control-label">Stock</label>
                                                <input type="text" id="catalogo_stock" class="form-control" value="" placeholder="" onkeyup="mascara(this,'/',patron,true);">
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="clearfix"></div>
                                  <label class="col-sm-2 col-sm-2 control-label">Cargar Articulo</label>
                                  <div class="col-sm-9" id="the-basics">
                                        <input type="text" id="catalogo_articulo" class="form-control" placeholder="Article">
                                  </div>
                                  <div class="col-sm-1" align="right"><button type="button" class="btn btn-default" onclick="cargar_articulo();">Cargar</button></div>
                              </div>
                              <!--TABLA DE ARTICULOS CARGADOS-->
                              <div class="row mt">
                                <div class="col-lg-12">
                                        <div class="content-panel">
                                            <h4><i class="fa fa-angle-right"></i> Articulos cargados</h4>
                                            <section id="no-more-tables">
                                                <table class="table table-bordered table-striped table-condensed cf">
                                                    <thead class="cf" id="catalogo_articulo_list">
                                                    <tr>
                                                        <th>Borrar</th>
                                                        <th>Codigo</th>
                                                        <th>Articulo</th>
                                                        <th>Cat.</th>
                                                        <th>Sub Cat.</th>
                                                        <th class="numeric">Precio</th>
                                                        <th class="numeric">Stock</th>
                                                        <th class="numeric">Oferta</th>
                                                        <th>Fecha Oferta</th>
                                                        <th>Flag</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </section>
                                        </div><!-- /content-panel -->
                                    </div><!-- /col-lg-12 -->
                                </div><!-- /row -->
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
        <!--CARGA IMAGEN DE PORTADA-->
        <!--<script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>-->
        <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
        <script>
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
        </script>
        
        <!--AUTOCOMPLETAR ARTICULO-->
        <script src="../../assets/js/typeahead.js" type="text/javascript"></script>
        <script>
            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                var matches, substringRegex;
                // an array that will be populated with substring matches
                matches = [];

                // regex used to determine if a string contains the substring `q`
                substrRegex = new RegExp(q, 'i');

                // iterate through the pool of strings and for any string that
                // contains the substring `q`, add it to the `matches` array
                $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                        matches.push(str);
                    }
                });

                cb(matches);
                };
            };
        </script>
        
        <!--ACCIONES DEL FORMULARIO-->
        <script>
            //CARGAR INICIALES
            var states = [];
            var cod_pd = '';
            $(document).ready(function(){
                //CARGA SELECT SUBCATEGORIA DE A PARTIR DE LA CATEGORIA
                $("#catalogo_categoria").change(function() {
                    //ACTIVA PRELOADER
                    cat_val = this.value;
                    alert(cat_val);
                    sub_cat_id = 'catalogo_subcategoria';
                    activa_preloader();
                    $.getJSON("../controllers/ctCatalogo.php?",{"opc":"carga_subcategoria","cat_val":cat_val},function(data){
                        if(data.mss === '1'){
                            $("#"+sub_cat_id).html(data.salida);
                        }else{ alert(data.mss); }
                        //DESACTIVA PRELOADER
                        desactiva_preloader();
                    });
                });
                //CARGA EL LISTADO DE ARTICULOS
//                alert('COD: '=new Date().getTime());
                $('#catalogo_articulo').bind('keypress', function(){
//                $('#catalogo_articulo').bind('keydown', function(){
//                $('#catalogo_articulo').bind('keyup', function(){
//                    alert('vv');
//                    cod_pd = new Date().getTime();
                    art_val = this.value;
                    $.getJSON("../controllers/ctCatalogo.php",{"opc":"catalogoArtList","art_val":art_val},function(data){
                        var n = 0;
                        $.each( data, function(i, object) {
                            states[n] = object['SkuNo']+' '+object['ProdDesc']+' ('+object['xx']+')';
                            n = n +1;
                        });
                    });
                });
        
                /*
                $('#the-basics .form-control').typeahead({
                   source: function (query, process) {
                        return $.get('../controllers/ctCatalogo.php', { "opc":"catalogoArtList","query": query }, function (data) {
                            return process(data);
                        });
                    } 
                });
        */
                /*
                $('#the-basics .form-control').typeahead({
                    source: function (query, process) {
                        $.ajax({
                          url: '../controllers/ctCatalogo.php',
                          type: 'GET',
                          dataType: 'JSON',
                          data: 'opc=catalogoArtList&query=' + query,
                          success: function(data) {
                            console.log(data);
                            process(data);
                          }
                        });
                    }
                });
        */
        
                /*
                $('#the-basics .form-control').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },{
                    name: 'states',
//                    source: function () {
                    source: function (query, process) {
                        $.getJSON("../controllers/ctCatalogo.php",{"opc":"catalogoArtList","art_val":this.value},function(data){
//                            var n = 0;
                            $.each( data, function(i, object) {
                                states[n] = object['SkuNo']+' '+object['ProdDesc']+' ('+object['xx']+')';
//                                n = n +1;
                            });
                        });}
                });
        */
        
//                $('#the-basics .form-control').typeahead({
//                    source: function (query, process) {
//                        $.getJSON("../controllers/ctCatalogo.php",{"opc":"catalogoArtList","art_val":query},function(data){
//                            process(data);
//                        });}
//                });
            });
      
            
            $('#the-basics .form-control').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },{
                name: 'states',
                source: substringMatcher(states)
            });
            
//                source: substringMatcher(states)
            
            //CARGA ARTICULOS
            function cargar_articulo(){
                datos = captura_datos_padre('the-basics');
                catalogo_articulo = document.getElementById('catalogo_articulo').value;
                catalogo_articulo = catalogo_articulo.split(' ');
                cod = catalogo_articulo[0];
                if(compara_valor_class('catalogo_articulo_list','catalogo_articulo_list_cod',cod) === 0){
                    activa_preloader();
                    $.getJSON("../controllers/ctCatalogo.php?"+datos,{"opc":"catalogoArtCarga"},function(data){
                        if(data.mss === '1'){
                            $('#catalogo_articulo_list').append(data.salida);
                        }else{ alert(data.mss); }
                        desactiva_preloader();
                    });
                }else{
                    alert('EL ARTICULO YA EXISTE');
                }
            }
            
            //REMUEVE ARTICULOS
            function remover_articulo(id){
                $('#'+id).parent().remove();
            }
            
            //GUARDA_CATALOGO
            function guardar_catalogo(){
                datos = captura_datos_padre('catalogo_form');
                articulos = captura_valor_class_hijos('catalogo_articulo_list','catalogo_articulo_fila');
//                alert(articulos);
                activa_preloader();
                $.getJSON("../controllers/ctCatalogo.php?"+datos+'&articulos='+articulos,{"opc":"catalogoGuardar"},function(data){
                    if(data.mss === '1'){
                        alert(data.salida);
                        ir_a('catalogoIndex.php','');
//                        $('#catalogo_articulo_list').append(data.salida);
                    }else{ alert(data.mss); }
                    desactiva_preloader();
                });
            }
        </script>
        <!--END SCRIPT-->
    </body>
</html>
