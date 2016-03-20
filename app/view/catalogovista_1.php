<?php
//    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $obj_bdmysql = new coBdmysql();
    
    $id_catalogo = $obj_function->code_url($_GET['id'],'decode');
    $link = 'http://www.gibble.com.ve/textronic/web/index.php';
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
    if (!$mysqli->connect_error){
        //DATOS DEL CATALOGO
        $mss = '';
        $mss_art = '';
        if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
            $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
            if(!is_array($resul)){ $mss = 'NO SE ENCONTRARON DATOS PARA EL CATALOGO. '.$resul; }
            
            //LISTADO DE ARTICULOS
            $resul_art = $obj_bdmysql->select("vw_catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
            if(!is_array($resul_art)){ $mss_art = 'NO SE ENCONTRARON ARTICULOS EN EL CATALOGO. '; }
            //CODIGO QR
            $codigo_qr = '../../common/codeqr/'.$id_catalogo.'.png';
            if(file_exists($codigo_qr)){  $img_cod_qr = '<img src="'.$codigo_qr.'" alt="QR" style="width:200px;height:200px;">';
            }else{ $img_cod_qr = 'QR NO ENCONTRADO.'; }
        }else{
            $mss = "NO SE ENCONTRO EL CATALOGO.";
        }
    }
?>
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
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Codigo</label>
                              <div class="col-sm-10">
                                  <input type="text" id="catalogo_codigo" class="form-control" value="<?php echo $resul[0]['codigo']?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Titulo</label>
                              <div class="col-sm-10">
                                  <input type="text" id="catalogo_titulo" class="form-control" value="<?php echo $resul[0]['titulo']?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Descripcion</label>
                              <div class="col-sm-10">
                                  <input type="text" id="catalogo_descripcion" class="form-control" value="<?php echo $resul[0]['descripcion']?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Fecha</label>
                              <div class="col-sm-10">
                                  <input type="text" id="catalogo_fecha" class="form-control" value="<?php echo $resul[0]['fe_us_in_dmy']?>" placeholder="Example: 01/01/1960" onkeyup="mascara(this,'/',patron,true);" readonly>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Link</label>
                              <div class="col-sm-10">
                                  <input type="text" id="catalogo_fecha" class="form-control" value="<?php echo $link;?>" placeholder="" readonly>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">CODIGO QR</label>
                              <div class="col-sm-10" align="center">
                                  <?php echo $img_cod_qr;?>
<!--                                      <img src="../../common/codeqr/3.png" alt="QR" style="width:200px;height:200px;">-->
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Portada</label>
                              <div class="col-sm-10">
                                  <input type="file" id="catalogo_portada" class="file">
                              </div>
                          </div>
                          <div class="form-group">
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
                                                    <th>Remove</th>
                                                    <th>Code</th>
                                                    <th>Article</th>
                                                    <th class="numeric">Price</th>
                                                    <th class="numeric">Stock</th>
                                                    <th class="numeric">Sale</th>
                                                    <th>Date Sale</th>
                                                </tr>
                                                <?php 
                                                if($mss_art != ''){?>
                                                <tr><td colspan="7"><?php echo $mss_art;?></td></tr>
                                                <?php    
                                                }else{
                                                    foreach ($resul_art as $r_art){?>
                                                <tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_<?php echo $r_art['id'];?>">
                                                    <td data-title="remove" id="catalogo_articulo_list_remove_<?php echo $r_art['id'];?>" style="text-align:center;" onclick="remover_articulo(this.id);"><i class="fa fa-trash-o" style="font-size:28px"></i></td>
                                                    <td data-title="Code" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="<?php echo $r_art['cod_art'];?>"><?php echo $r_art['cod_art'];?></td>
                                                    <td data-title="Article"><?php echo $r_art['descripcion'];?></td>
                                                    <td class="numeric" data-title="Price"><input type="text" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="<?php echo $r_art['precio'];?>"></td>
                                                    <td class="numeric" data-title="Stock"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="<?php echo $r_art['stock_ini'];?>"></td> 
                                                    <td class="numeric" data-title="Sale"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="<?php echo $r_art['oferta'];?>"></td> 
                                                    <td data-title="Date Sale"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="<?php echo $r_art['fe_us_in_dmy'];?>" onkeyup="mascara(this,\'/\',patron,true);"></td>
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
                            </div><!-- /row -->
                            <br>
                            <div class="form-group">
                                <div class="col-sm-12" align="right">
                                    <button type="button" class="btn btn-default" onclick="ir_a('catalogoIndex.php','')">Cancelar</button>
                                    <button type="button" class="btn btn-warning" onclick="guardar_catalogo();">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- col-lg-12-->      	
            </div><!-- /row -->
        </section>
    </section>
    <!--ESTILO DE INPUT FILE-->
    <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
    <script>
//        $(function(){
//                $('select.styled').customSelect();
//        });
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

        var states = [];
        $(document).ready(function(){
            preloader();
            $.getJSON("../controllers/ctCatalogo.php",{"opc":"catalogoArtList"},function(data){
                var n = 0;
                $.each( data, function(i, object) {
                    states[n] = object['codigo']+' '+object['descripcion'];
                    n = n +1;
                });
            });
        });

        $('#the-basics .form-control').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },{
            name: 'states',
            source: substringMatcher(states)
        });
    </script>

    <!--ACCIONES DEL FORMULARIO-->
    <script>
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
//                        $('#catalogo_articulo_list').append(data.salida);
                }else{ alert(data.mss); }
                desactiva_preloader();
            });
        }
    </script>
    <!--END SCRIPT-->
