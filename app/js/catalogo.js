function contruirArticulos(resul){



var n;
var ini_pag;
var n_pag=1; 
var salida = '';
                    if(n_pag == 1){
                    salida = '<tr><th>'+
                                '<th>N</th>'+
                                '<th>Sel</th>'+
                                '<th width="10%">SkuNo</th>'+
                                '<th width="10%">PartNo</th>'+
                                '<th>Descripcion</th>'+
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
                                    '<td class="resultInput" data-title="ArtICULO">'+r.ProdDesc+'</td>'+
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
