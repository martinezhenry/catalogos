/* 
 * FUNCIONES DE LAS ACCIONES COMUNES DEL CATALOGO.
 */

//CARGA ARTICULOS AL CATALOGO
function cargar_articulo(){
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
            PartNo = arr_art[1];
            ProdDesc = arr_art[2];
            CatDesc = arr_art[3];
            PrdDesc = arr_art[4];
            precio = arr_art[5];
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
                    '    <td data-title="CATEGORIA">'+CatDesc+'</td>'+
                    '    <td data-title="SUB CATEGORIA">'+PrdDesc+'</td>'+
                    '    <td class="numeric" data-title="PRECIO"><input type="text" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="'+precio+'"></td>'+
                    '    <td class="numeric" data-title="STOCK"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="'+OnHand+'"></td>'+
                    '    <td class="numeric" data-title="OFERTA"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="'+oferta+'"></td> '+
                    '    <td data-title="INI. OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_to_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                    '    <td data-title="FIN OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'+fecha_from_oferta+'" onkeyup="mascara(this,\'/\',patron,true);"></td>'+
                    '    <td data-title="FLAG">'+flag+'</td>'+
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

// Generar reporte
function Exportar_reporte(){
    ch_art = captura_valor_ch('catalogo_articulo_list_busca');
     n = 1;
    html = '';
    count = 0;
    allDataExcel = [];
    if(ch_art !== ''){
        ch_art = '_'+ch_art;
        ch_art = ch_art.replace('_/*','');
        arr_ch = ch_art.split('/*');

        arr_ch.forEach(function(value){
            catalogo_articulo_arr = document.getElementById('catalogo_articulo_arr_'+value).value;
            arr_art = catalogo_articulo_arr.split('/*');

            dataExcel = {};
            dataExcel["Skuno"] = arr_art[1];
            dataExcel["Partno"] = arr_art[2];
            dataExcel["xref"] = arr_art[3];
            dataExcel["xrefuniversal"] = arr_art[4];
            dataExcel["descripcion"] = arr_art[5];
            dataExcel["onhandinpickav"] = arr_art[6];
            dataExcel["avidst"] = arr_art[7];
            dataExcel["avrcost"] = arr_art[8];
            dataExcel["precio1"] = arr_art[9];
            dataExcel["dts"] = arr_art[10];
            dataExcel["binloctex"] = arr_art[11];
            dataExcel["binlocdts"] = arr_art[12];
            dataExcel["p1"] = arr_art[13];
            dataExcel["p1"] = arr_art[14];
            dataExcel["p0"] = arr_art[15];

            allDataExcel.push(JSON.stringify(dataExcel));



            
        });
    
        // $.post("../controllers/exportarExcel.php",{lines:allDataExcel},function(data){
        //    alert(data);
        // },"json").fail(function(error, errorText){
          
        //     console.log('ERROR: ' + errorText);
        // });
        // alert('SE GENERO DOCUMENTO EXCEL.');
        // console.log(allDataExcel);

        $.ajax({
            url: '../controllers/exportarExcel.php',
            type: 'POST',
            dataType: 'json',
            data: {lines:allDataExcel},
        })
        .done(function(data) {
            alert(data);
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        


    }

}
            
//MARCA LOS ARTICULOS SEGUN EL MARCADO QUE SE INDIQUE
function sel_all(val){
    if($("#catalogo_articulo_list_busca").length > 0){
        if (val) {
            $("#catalogo_articulo_list_busca input[type=checkbox]").prop('checked', true);
        }else{
            $("#catalogo_articulo_list_busca input[type=checkbox]").prop('checked', false);
        }
    }
}

//DESACTIVA ARTICULOS CARGAOS
function desactiva_cargados(idPadre,clase){
    c = '';
    padre = document.getElementById(idPadre);
        if(padre){
            var elemento = padre.getElementsByTagName('tr');
            var n = elemento.length;
            var existe = 0;
            for (var i = 0; i < n; i++) {
                if(elemento[i].className === clase){
                    id_tr = elemento[i].id.replace("catalogo_articulo_fila_carga_", "catalogo_articulo_fila_");
                    if($("#"+id_tr+" input[type=checkbox]").is(':enabled')){
                        $("#"+id_tr).css('background','#efefef');
                        $("#"+id_tr+" input[type=checkbox]").prop('disabled', true);
                }
            }
        }
    }else{ alert('ERROR EN FUNCION INTERNA DE CLASES. NO EXISTE EL PADRE.'); return; }
}

//CUENTA Y MUESTRA LA CANTIDAD DE ARTICULOS CARGADOS
function cantidad_articulos_catalogo(){
    n = $(".catalogo_articulo_fila_carga").length;
    $('#catalogo_articulo_list_total_cargado').html('Total: '+n);
}

//CUENTA Y MUESTRA LA CANTIDAD DE ARTICULOS DE LA BUSQUEDA
function cantidad_articulos_catalogo_busqueda(){
    n = $(".catalogo_articulo_fila").length;
    $('#catalogo_articulo_list_total_busqeuda').html('Total: '+n);
}

//REMUEVE ARTICULOS
function remover_articulo(id){
    id_tr_c = $('#'+id).parent().attr('id');
    id_tr = id_tr_c.replace("catalogo_articulo_fila_carga_", "catalogo_articulo_fila_");
    if($("#"+id_tr).length > 0){
        $("#"+id_tr).css('background','#ffffff');
        $("#"+id_tr+" input[type=checkbox]").prop('disabled', false);
    }  
    $('#'+id).parent().remove();
    cantidad_articulos_catalogo();
}

//REMUEVE ARTICULOS
function remover_articulo_todos(){
    if($(".catalogo_articulo_fila_carga").length > 0){    
        if($(".catalogo_articulo_fila").length > 0){
            $(".catalogo_articulo_fila").css('background','#ffffff');
            $(".catalogo_articulo_fila input[type=checkbox]").prop('disabled', false);
        }
        $('.catalogo_articulo_fila_carga').remove();
        cantidad_articulos_catalogo();
    }
}

//ORDENA COLUMNAS DEL CATALOGO
function ordenar_catalogo(id){
    ord = id.split('_');
    order_id = ord[0];
    order_columna = ord[1];
    order_tipo = ord[2];
    if(ord[3] === 'false'){ order_orden = false; }else{ order_orden = true;}
    $("#catalogo_articulo_list_carga_table").sortTable(order_tipo, {column: order_columna, reverse: order_orden });
}

//QUITA ACENTOS
function omitirAcentos(text) {
    var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
    var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
    for (var i=0; i<acentos.length; i++) {
        text = text.replace(acentos.charAt(i), original.charAt(i));
    }
    return text;
}



function contruirReporte(resul){



var n;
var ini_pag;
var n_pag=1; 
var salida = '';
                    if(n_pag == 1){
                    salida = '<tr><th>'+
                                '<th>Skuno</th>'+
                                '<th>Part-no</th>'+
                                '<th width="10%">xref</th>'+
                                '<th width="10%">xref-universal</th>'+
                                '<th>descripcion</th>'+
                                '<th>onhand- inpick = av</th>'+
                                '<th class="numeric">avi-dst</th>'+
                                '<th>avrcost</th>'+
                                '<th>precio1</th>'+
                                '<th class="numeric">dts</th>'+
                                '<th>binloctex</th>'+
                                '<th>binlocdts</th>'+
                                '<th>p1</th>'+
                                '<th>p1</th>'+
                                '<th>p0</th>'+
                                '</tr>';
                    }
                    salida += '<tr id="' + n_pag +'"><td colspan="12">PAGINA ' +n_pag+'</td></tr>';
                    n = ini_pag+1;
                    $.each(resul, function(k,r){
                        //DEFINE PRECIO
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
                        
                        catalogo_articulo_arr = r.SkuNo + '/*'+ r.PartNo+'/*'+r.ProdDesc+'/*'+r.CatDesc+'/*'+r.PrdDesc+'/*'+precio+'/*'+r.OnHand+'/*'+oferta+'/*'+fecha_to_oferta+'/*'+fecha_to_oferta+'/*'+flag;
                        salida+= '<tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_'+r.SkuNo+'" >'+
                                   '<td data-title="N" style="text-align:center;">'+(k+1)+'</td>'+
                                    '<td data-title="CH" style="text-align:center;"><input type="checkbox" id="catalogo_articulo_list_ch_'+r.SkuNo+'" value="'+r.SkuNo+'"></td>'+
                                    '<td data-title="SKUNO" id="catalogo_articulo_list_cod">'+r.SkuNo+'</td>'+
                                    '<td data-title="PARTNO">'+r.PartNo+'</td>'+
                                    '<td data-title="ArtICULO">'+r.ProdDesc+'</td>'+
                                    '<td data-title="CATEGORIA">'+r.CatDesc+'</td>'+
                                    '<td data-title="SUB CATEGORIA">'+r.PrdDesc+'</td>'+
                                    '<td class="numeric" data-title="PRECIO">'+precio+'</td>'+
                                    '<td class="numeric" data-title="STOCK">'+r.OnHand+'</td> '+
                                    '<td class="numeric" data-title="STOCK">'+r.qty_dts+'</td> '+
                                    '<td class="numeric" data-title="OFERTA">'+oferta+'</td> '+
                                    '<td data-title="INI+ OFERTA">'+fecha_to_oferta+'</td>'+
                                    '<td data-title="FIN OFERTA">'+fecha_from_oferta+'</td>'+
                                    '<td data-title="FLAG">'+flag+'</td>'+
                                    '<td data-title="FLAG">'+flag+'</td>'+
                                    '<td data-title="FLAG">'+flag+'</td>'+
                                    '<input type="hidden" id="catalogo_articulo_arr_'+r.SkuNo+'" value="'+catalogo_articulo_arr+'">'+
                                  '</tr>';
                        n = n +1;
                    });

                    return salida;

}



function contruirArticulos(resul){



var n;
var ini_pag;
var n_pag=1; 
var salida = '';
                    if(n_pag == 1){
                    salida = '<tr>'+
                                '<th>N</th>'+
                                '<th>Sel</th>'+
                                '<th width="10%">SkuNo</th>'+
                                '<th width="10%">PartNo</th>'+
                                '<th>Descripcion</th>'+
                                '<th>Categoria.</th>'+
                                '<th>Sub Cat.</th>'+
                                '<th class="numeric">Precio</th>'+
                                '<th>Cat Tex.</th>'+
                                '<th>Cat DTS.</th>'+
                                '<th class="numeric">Oferta</th>'+
                                '<th>Ini. Oferta</th>'+
                                '<th>Fin. Oferta</th>'+
                                '<th>Flag</th>'+
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
                                    '<td data-title="SKUNO" id="catalogo_articulo_list_cod">'+r.SkuNo+'</td>'+
                                    '<td data-title="PARTNO">'+r.PartNo+'</td>'+
                                    '<td data-title="ArtICULO">'+r.ProdDesc+'</td>'+
                                    '<td data-title="CATEGORIA">'+r.CatDesc+'</td>'+
                                    '<td data-title="SUB CATEGORIA">'+r.PrdDesc+'</td>'+
                                    '<td class="numeric" data-title="PRECIO">'+precio+'</td>'+
                                    '<td class="numeric" data-title="STOCK">'+r.OnHand+'</td> '+
                                    '<td class="numeric" data-title="STOCK">'+r.qty_dts+'</td> '+
                                    '<td class="numeric" data-title="OFERTA">'+oferta+'</td> '+
                                    '<td data-title="INI+ OFERTA">'+fecha_to_oferta+'</td>'+
                                    '<td data-title="FIN OFERTA">'+fecha_from_oferta+'</td>'+
                                    '<td data-title="FLAG">'+flag+'</td>'+
                                    '<input type="hidden" id="catalogo_articulo_arr_'+r.SkuNo+'" value="'+catalogo_articulo_arr+'">'+
                                  '</tr>';
                        n = n +1;
                    });

                    return salida;

}

function verificarExisteFile(SkuNo){

    $.ajax({
    url:'../../assets/img/art/'+SkuNo+'.jpg',
    type:'HEAD',
    statusCode : {
        404: function(){
            return false;
        }

    },
    error: function(XMLHttpRequest, textStatus, errorThrown)
    {
        //file not exists
        console.log('error error');
        return false;
    },
    success: function()
    {
        //file exists
        return true;
    }
}).fail(function( jqXHR, textStatus, errorThrown ){
    console.log('error not found');
    return false;
});

}


function UrlExists(url)
{
    try {
    var http = new XMLHttpRequest();
    http.open('HEAD', '../../assets/img/art/' + url + '.jpg', false);
    http.send();
    1/0;
    if (http.status!=404){
        return true;
    } else {
        return false;
    }
   // return http.status!=404;
} catch (excepcion){

    console.log(excepcion);
    alert(excepcion);
    return false;

}
}


function file_exists(url) {
  // http://kevin.vanzonneveld.net
  // +   original by: Enrique Gonzalez
  // +      input by: Jani Hartikainen
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // %        note 1: This function uses XmlHttpRequest and cannot retrieve resource from different domain.
  // %        note 1: Synchronous so may lock up browser, mainly here for study purposes.
  // *     example 1: file_exists('http://kevin.vanzonneveld.net/pj_test_supportfile_1.htm');
  // *     returns 1: '123'
  var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
  if (!req) {
    throw new Error('XMLHttpRequest not supported');
  }

  // HEAD Results are usually shorter (faster) than GET
  req.open('HEAD', url, false);
  req.send(null);
  if (req.status == 200) {
    return true;
  }

  return false;
}