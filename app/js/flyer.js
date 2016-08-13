
  var order_tipo = 'both';
  var order_columna = 1;
  if('false' === 'false'){ var order_orden = false; }else{ var order_orden = true;}
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
                opc = "flyerArtBusca";
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
                $.post("../controllers/ctFlyer.php",{
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
                        $('#catalogo_articulo_list_busca').html(contruirArticulosFlyer(data.salida));
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





function contruirArticulosFlyer(resul){



var n;
var ini_pag;
var n_pag=1; 
var salida = '';
                    if(n_pag == 1){
                    salida = '<tr>'+
                                '<th>N</th>'+
                                '<th>Sel</th>'+
                                ''+
                                '<th width="10%">PartNo</th>'+
                                '<th>Aplication</th>'+
                                '<th>Tomco</th>'+
                                '<th>SMP</th>'+
                                '<th>OEM</th>'+
                                '<th>WELLS</th>'+
                                '<th class="numeric">Precio Name 1</th>'+
                                '<th class="numeric">Precio Name 2</th>'+
                                '<th class="numeric">Precio Name 3</th>'+

                                '<th class="numeric">Precio 1</th>'+
                                '<th class="numeric">Precio 2</th>'+
                                '<th class="numeric">Precio 3</th>'+
                                ''+
                                ''+
                                ''+
                                ''+
                                '</tr>';
                    }
                    salida += '<tr id="' + n_pag +'"><td colspan="12">PAGINA ' +n_pag+'</td></tr>';
                    n = ini_pag+1;
                    $.each(resul, function(k,r){
                        //DEFINE PRECIO

                        if ($('#catalogo_con_img').prop('checked')){
                            var conImg = true;
                            
                        } else {
                            var conImg = false;
                        }

                        if (conImg == true){
                            if (file_exists('../../assets/img/art/'+r.SkuNo+'.jpg') != true) {
                                return;
                            }
                        }
                        var precio = '0';
                        //DEFINE FLAG
                        var flag = '';
                        if(r.Flag01 == '1'){ flag+= 'Flag01, '; };
                        if(r.Flag02 == '1'){ flag+= 'Flag02, '; };
                        if(r.Flag03 == '1'){ flag+= 'Flag03, '; };
                        if(r.Flag04 == '1'){ flag+= 'Flag04, '; };
                        if(r.Flag05 == '1'){ flag+= 'Flag05, '; };
                        if(r.Flag06 == '1'){ flag+= 'Flag06, '; };
                        if(r.Flag07 == '1'){ flag+= 'Flag07, '; };
                        if(r.Flag08 == '1'){ flag+= 'Flag08, '; };
                        if(r.Flag09 == '1'){ flag+= 'Flag09, '; };
                        if(r.Flag10 == '1'){ flag+= 'Flag10, '; };
                        if(flag.trim() != ''){ 
                            flag = (flag+'_').replace(', _', '');
                        }
                        else { 
                            flag = 'No Aplica'; 
                        }

                        //DEFINE OFERTAS
    //                    select *,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma 
    //FROM autodatasystem.`ofertas detail` as a LEFT JOIN autodatasystem.ofertas as b ON a.ID = b.OfertaId
    //WHERE SkuNo = '113631' ORDER BY b.Date_To DESC LIMIT 1
                       // $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$r['SkuNo']."'", "Date_To DESC", "1",$mysqli);
                        //if(!is_array($resul_oferta)){
                         oferta = '0';
                          fecha_to_oferta = '00/00/0000';
                          fecha_from_oferta = '00/00/0000'; 
                      //  }else{  
                          oferta = r.Precio;
                           fecha_to_oferta = r.Date_To_dma;
                            fecha_from_oferta = r.Date_From_dma;
                            precio = r.precio2;
                        
                        catalogo_articulo_arr = r.SkuNo + '/*'+ r.PartNo+'/*'+r.ProdDesc+'/*'+r.CatDesc+'/*'+r.PrdDesc+'/*'+precio+'/*'+r.OnHand+'/*'+oferta+'/*'+fecha_to_oferta+'/*'+fecha_to_oferta+'/*'+flag;
                        salida+= '<tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_'+r.SkuNo+'" >'+
                                   '<td data-title="N" style="text-align:center;">'+(k+1)+'</td>'+
                                    '<td data-title="CH" style="text-align:center;"><input type="checkbox" id="catalogo_articulo_list_ch_'+r.SkuNo+'" value="'+r.SkuNo+'"></td>'+
                                  //  '<td data-title="SKUNO" id="catalogo_articulo_list_cod">'+r.SkuNo+'</td>'+
                                    '<td data-title="PARTNO"><input id="flyer_partNo_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.PartNo+'" /></td>'+
                                    '<td data-title="prodDesc"><input id="flyer_prodDesc_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.Desc+'" /></td>'+
                                    '<td data-title="TOMCO"><input id="flyer_tomco_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.tomco+'" /></td>'+
                                    '<td data-title="SMP"><input id="flyer_smp_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.smp+'" /></td>'+
                                    '<td data-title="OEM"><input id="flyer_oem_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.oem+'" /></td>'+
                                    '<td data-title="WELLS"><input id="flyer_wells_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.wells+'" /></td>'+
                                    '<td class="numeric" data-title="PRECIO"><input id="flyer_precioN_'+r.SkuNo+'" type="text" style="width: 100%;" value="" /></td>'+
                                    '<td class="numeric" data-title="PRECION2"><input id="flyer_precioN2_'+r.SkuNo+'" type="text" style="width: 100%;" value="" /></td>'+
                                    '<td class="numeric" data-title="PRECION3"><input id="flyer_precioN3_'+r.SkuNo+'" type="text" style="width: 100%;" value="" /></td>'+
                                    '<td class="numeric" data-title="PRECIO"><input id="flyer_precio_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+r.Precio+'" /></td>'+
                                    '<td class="numeric" data-title="PRECIO2"><input id="flyer_precio2_'+r.SkuNo+'" type="text" style="width: 100%;" value="" /></td>'+
                                    '<td class="numeric" data-title="PRECIO3"><input id="flyer_precio3_'+r.SkuNo+'" type="text" style="width: 100%;" value="" /></td>'+
                                   // '<td data-title="SUB CATEGORIA">'+r.PrdDesc+'</td>'+
                                    //'<td class="numeric" data-title="PRECIO"><input id="flyer_precio_'+r.SkuNo+'" type="text" style="width: 100%;" value="'+precio+'" /></td>'+
                                   // '<td class="numeric" data-title="STOCK">'+r.OnHand+'</td> '+
                                    //'<td class="numeric" data-title="STOCK">'+r.qty_dts+'</td> '+
                                    //'<td class="numeric" data-title="OFERTA">'+oferta+'</td> '+
                                    //'<td data-title="INI+ OFERTA">'+fecha_to_oferta+'</td>'+
                                    //'<td data-title="FIN OFERTA">'+fecha_from_oferta+'</td>'+
                                    //'<td data-title="FLAG">'+flag+'</td>'+
                                    '<input type="hidden" id="catalogo_articulo_arr_'+r.SkuNo+'" value="'+catalogo_articulo_arr+'">'+
                                  '</tr>';
                        n = n +1;
                    });

                    return salida;

}



//CARGA ARTICULOS AL CATALOGO
function cargar_articuloFlyer(){
    ch_art = captura_valor_ch('catalogo_articulo_list_busca');
    n = 1;
    html = '';
    count = 0;
    if(ch_art !== ''){
        ch_art = '_'+ch_art;
        ch_art = ch_art.replace('_/*','');
        arr_ch = ch_art.split('/*');
        arr_ch.forEach(function(value){
            catalogo_articulo_arr = document.getElementById('catalogo_articulo_arr_'+value).value;
            arr_art = catalogo_articulo_arr.split('/*');
            SkuNo = value;
            PartNo = $('#flyer_partNo_' + value).val();
            ProdDesc = $('#flyer_prodDesc_'+ value).val();
            CatDesc = arr_art[3];
            PrdDesc = arr_art[4];
            precio = $('#flyer_precio_'+ value).val();
            precio3 = $('#flyer_precio3_'+ value).val();
            precio2 = $('#flyer_precio2_'+ value).val();
            precioN = $('#flyer_precioN_'+ value).val();
            precioN3 = $('#flyer_precioN3_'+ value).val();
            precioN2 = $('#flyer_precioN2_'+ value).val();
            tomco = $('#flyer_tomco_'+ value).val();
            oem = $('#flyer_oem_'+ value).val();
            smp = $('#flyer_smp_'+ value).val();

            wells = $('#flyer_wells_'+ value).val();
            OnHand = arr_art[6];
            oferta = arr_art[7];
            fecha_to_oferta = arr_art[8];
            fecha_from_oferta = arr_art[9];
            flag = arr_art[10];
            if(!document.getElementById('catalogo_articulo_fila_carga_'+SkuNo)){
                count=count+1;
            html =  html+
                    '<tr class="catalogo_articulo_fila_carga" id="catalogo_articulo_fila_carga_'+SkuNo+'">'+
                    '    <td data-title="remove" id="catalogo_articulo_list_remove_'+SkuNo+'" style="text-align:center;" onclick="remover_articulo(this.id);"><i class="fa fa-trash-o" style="font-size:18px; cursor: pointer;"></i></td>'+
                    '    <td data-title="CODIGO" class="catalogo_articulo_list_cod" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="'+SkuNo+'">'+SkuNo+'</td>'+
                    '    <td data-title="PARTNO" class="catalogo_articulo_list_partNo"><input type="hidden" id="catalogo_articulo_list_partno" value="'+PartNo+'">'+PartNo+'</td>'+
                    '    <td data-title="ARTICULO" class="catalogo_articulo_list_prodDesc"><input type="hidden" id="catalogo_articulo_list_proddesc" value="'+ProdDesc+'">'+ProdDesc+'</td>'+
                    '    <td data-title="ARTICULO" class="catalogo_articulo_list_tomco"><input type="hidden" id="catalogo_articulo_list_tomco" value="'+tomco+'">'+tomco+'</td>'+
                    '    <td data-title="ARTICULO" class="catalogo_articulo_list_smp"><input type="hidden" id="catalogo_articulo_list_smp" value="'+smp+'">'+smp+'</td>'+
                    '    <td data-title="ARTICULO" class="catalogo_articulo_list_oem"><input type="hidden" id="catalogo_articulo_list_oem" value="'+oem+'">'+oem+'</td>'+
                    '    <td data-title="ARTICULO" class="catalogo_articulo_list_wells"><input type="hidden" id="catalogo_articulo_list_wells" value="'+wells+'">'+wells+'</td>'+
                   // '    <td data-title="CATEGORIA">'+CatDesc+'</td>'+
                   // '    <td data-title="SUB CATEGORIA">'+PrdDesc+'</td>'+
                   '    <td class="numeric" data-title="PRECION"><input type="hidden" id="catalogo_articulo_list_priceN" class="form-control" placeholder="Price Name" value="'+precioN+'">'+precioN+'</td>'+
                    '    <td class="numeric" data-title="PRECION2"><input type="hidden" id="catalogo_articulo_list_priceN2" class="form-control" placeholder="Price Name 2" value="'+precioN2+'">'+precioN2+'</td>'+
                    '    <td class="numeric" data-title="PRECION3"><input type="hidden" id="catalogo_articulo_list_priceN3" class="form-control" placeholder="Price Name 3" value="'+precioN3+'">'+precioN3+'</td>'+
                    '    <td class="numeric" data-title="PRECIO"><input type="hidden" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="'+precio+'">'+precio+'</td>'+
                    '    <td class="numeric" data-title="PRECIO2"><input type="hidden" id="catalogo_articulo_list_price2" class="form-control" placeholder="Price 2" value="'+precio2+'">'+precio2+'</td>'+
                    '    <td class="numeric" data-title="PRECIO3"><input type="hidden" id="catalogo_articulo_list_price3" class="form-control" placeholder="Price 3" value="'+precio3+'">'+precio3+'</td>'+
                    //'    <td class="numeric" data-title="STOCK"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="'+OnHand+'"></td>'+
                    //'    <td class="numeric" data-title="OFERTA"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="'+oferta+'"></td> '+
                    //'    <td data-title="INI. OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_to_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                    //'    <td data-title="FIN OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_from_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                    //'    <td data-title="FLAG">'+flag+'</td>'+
                    //'    <td data-title="image"></td>'+
                    '</tr>';
            n = n + 1;
            if (count > 100){
                $('#catalogo_articulo_list_carga').append(html);
                html = null;
                count = null;
                html = "";
                count = 0;        
            }
            }
        });
        $('#catalogo_articulo_list_carga').append(html);
        n_cargado = n - 1;
        //CUENTA ARTICULOS CARGADOR
        cantidad_articulos_catalogo();
        //ORDENA ARTICULOS
        $("#catalogo_articulo_list_carga_table").sortTable(order_tipo, {column: order_columna, reverse: order_orden});
        //DESACTIVA ARTICULOS CARGADOS
        desactiva_cargados('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
        alert('SE CARGARON '+n_cargado+' ARTICULOS NUEVOS.');
    }else{ alert('NO HAY ARTICULOS SELECCINADOS.'); }
}

//ORDENA COLUMNAS DEL CATALOGO
function ordenar_Flyer(id){
    ord = id.split('_');
    order_id = ord[0];
    order_columna = ord[1];
    order_tipo = ord[2];
    if(ord[3] === 'false'){ order_orden = false; }else{ order_orden = true;}
    $("#catalogo_articulo_list_carga_table").sortTable(order_tipo, {column: order_columna, reverse: order_orden });
}


//GUARDA_CATALOGO
            function guardar_flyer(){
                opc = "flyerGuardar";
                
                flyer_tittle = forma_cad(document.getElementById('flyer_tittle').value);
                flyer_created = forma_cad(document.getElementById('flyer_created').value);
                flyer_description = forma_cad(document.getElementById('flyer_description').value);
                catalogo_sel_presentacion = $('#catalogo_sel_presentacion').val();
                
                products = captura_valor_class_hijos('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');
                
                activa_preloader();
                $.post("../controllers/ctFlyer.php",{
                     "opc":opc
                    ,"flyer_tittle":flyer_tittle
                    ,"flyer_created":flyer_created
                    ,"flyer_description":flyer_description
                    ,"products":products
                },function(data){
                    console.error(data);
                    if(data.mss === '1'){
                        alert(data.salida);
                        ir_a('flyer.php','');
                    }else{ alert(data.mss); }
                    desactiva_preloader();
                },"json").fail(function(error, errormsg){
                    console.error("Error guardar_catalogo: " + errormsg);
                    desactiva_preloader();

                });

            }


            //GUARDA_CATALOGO
            function editar_flyer(){
                
                if ($("#catalogo_img_portada .file-preview-image").length > 0){ catalogo_img_portada_del = 1;
                }else{ catalogo_img_portada_del = 0; }
                if ($("#catalogo_img_fondo .file-preview-image").length > 0){ catalogo_img_fondo_del = 1;
                }else{ catalogo_img_fondo_del = 0; }
                
                opc = "flyerEditar";
                flyer_id = forma_cad(document.getElementById('flyer_id').value);
                
                flyer_tittle = forma_cad(document.getElementById('flyer_tittle').value);
                flyer_created = forma_cad(document.getElementById('flyer_created').value);
                flyer_description = forma_cad(document.getElementById('flyer_description').value);
                products = captura_valor_class_hijos('catalogo_articulo_list_carga','catalogo_articulo_fila_carga');

                activa_preloader();
                $.post("../controllers/ctFlyer.php",{
                     "opc":opc
                    ,"flyer_id":flyer_id
                    ,"flyer_tittle":flyer_tittle
                    ,"flyer_created":flyer_created
                    ,"flyer_description":flyer_description
                    ,"products":products
                },function(data){
                    console.error(data);
                    if(data.mss === '1'){
                        alert(data.salida);
                        ir_a('flyer.php','');
                    }else{ alert(data.mss); }
                    desactiva_preloader();
                },"json").fail(function(error, errormsg){
                    console.error("Error editar_flyer: " + errormsg);
                    desactiva_preloader();

                });

            }

            

$(document).ready(function(){

                //$('#cat_vendido_desde').datepicker();
                //$('#cat_vendido_hasta').datepicker();


            $("#flyer_fondo").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/flyerUpload.php",
                uploadAsync: false,
                maxFileCount: 1
            });
            /*
            $("#productFlyer_img").fileinput({
                uploadUrl: "../../assets/bootstrap-fileinput-master/flyerUpload.php",
                uploadAsync: false,
                maxFileCount: 1
            });
            */
            $("input#catalogo_titulo_color").ColorPickerSliders({
                size: 'sm',
                placement: 'right',
                swatches: false,
                sliders: false,
                hsvpanel: true
            });


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
                        $.post("../controllers/ctCatalogo.php",{
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
                                   
        
            });
            