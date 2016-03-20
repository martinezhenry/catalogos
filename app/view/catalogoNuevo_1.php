<?php
//    include '../../common/general.php';
    $obj_common = new common();
?>
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
                                  <!--<input type="file" id="catalogo_portada" class="file">-->
                                  <!--<input type="file" id="input-701" name="kartik-input-701[]" multiple=true class="file-loading">-->
                                  <input type="file" id="catalogo_portada" name="catalogo_portada" multiple=true class="file-loading">
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
    <!--JAVACRIPT LOCAL-->
    <!--CARGA IMAGEN DE PORTADA-->
    <script src="../../assets/bootstrap-fileinput-master/js/fileinput.js" type="text/javascript"></script>
    <script>
    $("#catalogo_portada").fileinput({
        uploadUrl: "../../assets/bootstrap-fileinput-master/upload.php", // server upload action
        uploadAsync: false,
        maxFileCount: 5
    });
    </script>

    <!--AUTOCOMPLETAR ARTICULO-->
    <script src="../../assets/js/typeahead.js" type="text/javascript"></script>
    <script>
        var substringMatcher = function(strs) {
            return function findMatches(q, cb) {
            var matches, substringRegex;
            matches = [];
            substrRegex = new RegExp(q, 'i');
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
