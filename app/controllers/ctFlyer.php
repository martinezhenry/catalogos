<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../common/general.php';
$obj_function = new coFunction();
$obj_bdmysql = new coBdmysql();
$cod_usuario = $_SESSION["cod_usuario"];
//VARIABLES DE LA VISTA.
//foreach ($_GET as $i_dato => $dato_){ $$i_dato = $obj_function->evalua_array($_GET,$i_dato); }
foreach ($_POST as $i_dato => $dato_){ 
    $$i_dato = $obj_function->evalua_array($_POST,$i_dato);
     }

switch ($opc){
    //LISTA ARTICULOS
    case 'catalogoArtList':
//        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
//        $resul = $obj_bdmysql->select("art","*","","","",$mysqli);
//        if(!is_array($resul)){ $resul = array('mss' => 'NO SE ENCONTRO ARTICULOS'); }
//        echo json_encode($resul);
        
        $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
//        $where = "1=1 AND Discontinued = 0 ";
        $where = "(SkuNo like '%".$art_val."%') or (ProdDesc like '%".$art_val."%')";
//        $catalogo_categoria = '';$catalogo_subcategoria = ''; $catalogo_stock = '';
//        if($catalogo_categoria != ''){ $where.=" AND CatCode = '".$catalogo_categoria."'";}
//        if($catalogo_subcategoria != ''){ $where.=" AND PrdCode = '".$catalogo_subcategoria."'"; }
//        if($catalogo_stock != ''){ $where.=" AND OnHand = '".$catalogo_stock."'"; }
        $resul = $obj_bdmysql->select("inventory","*,".$art_val." as xx",$where,"","0,10",$mysqli);
        if(!is_array($resul)){ $resul = array('mss' => 'NO SE ENCONTRO ARTICULOS'); }
        foreach ($resul as $r){ $rr = $r['SkuNo']; }
        echo json_encode($rr);
//        echo json_encode($resul);
    break;
    //EVALUA ARTICULOS
    case 'catalogoArtBuscaEval':
        $mss = '';
        $salida = '';
        $limit_busqueda = 100;
        $resul_n = 0;
        $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli->connect_error) {
            $where = " 1=1";
            $where.= " AND (Discontinued = 0)";
            if($catalogo_articulo != ''){ $where.= " AND ( ( PartNo like '%".$catalogo_articulo."%' ) OR ( SkuNo like '%".$catalogo_articulo."%' ) OR ( ProdDesc like '%".$catalogo_articulo."%' ) )"; }
            if($catalogo_categoria != ''){ $where.= " AND ( CatCode = '".$catalogo_categoria."' ) "; }
            //ACA DEBERIA FILTRAR POR EL NOMBRE DE LA SUB-CATEGORIA
            if($catalogo_subcategoria != ''){ $where.= " AND ( PrdCode = '".$catalogo_subcategoria_desc."' ) "; }
            if($catalogo_stock != ''){ $where.= " AND ( OnHand ".$catalogo_stock_cond." '".$catalogo_stock."' ) "; }
            if($catalogo_flags != ''){ 
                $arr_flag = explode('/*',str_replace('_/*', '', '_'.$catalogo_flags));
                $where_flag = " AND (";
                foreach ($arr_flag as $r_flag){ $where_flag.= " ( ".$r_flag." = '1' ) OR"; }
                $where.= str_replace("ORX","",$where_flag."X")." )";
            }
            $resul_n = $obj_bdmysql->num_row("inventory", $where ,$mysqli);
            $mss = 1; $salida = 233;
        }
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
    break;
    //BUSCA ARTICULOS
    case 'flyerArtBusca':
        //$catalogo_articulo = explode(' ', $catalogo_articulo);
        //$cod_articulo = trim($catalogo_articulo[0]);
        $mss = '';
        $salida = '';
        $limit_busqueda = 100;
        $resul_n = 0;
        //$mss = 'antes del mysqli';
        $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        
        if (!$mysqli->connect_error) {

            $mysqli->set_charset("utf8");

            $where = "";

            if($catalogo_descontinuado == 'true'){
                $where.= " (Discontinued = 1)";
            } else {
                $where.= " (Discontinued = 0)";
            }

            //echo  $catalogo_descontinuado . " : " . $where;
            //exit;


            
            if($catalogo_articulo != ''){
             $where.= " AND ( ( inventory.PartNo like '%".$catalogo_articulo."%' ) OR ( inventory.SkuNo like '%".$catalogo_articulo."%' ) OR ( inventory.ProdDesc like '%".$catalogo_articulo."%' ) )";
              }

            if($catalogo_categoria != ''){

                 $where.= " AND ( CatCode = '".$catalogo_categoria."' ) "; 
             }
            //ACA DEBERIA FILTRAR POR EL NOMBRE DE LA SUB-CATEGORIA

//            if($catalogo_subcategoria != ''){ 

  //              $where.= " AND ( PrdCode = '".$catalogo_subcategoria_desc."' ) ";
    //        }
      //      if($catalogo_stock != ''){ 
        //        $where.= " AND ( OnHand + qty_dts ".$catalogo_stock_cond." '".$catalogo_stock."' ) ";
          //  }

             if($catalogo_subcategoria != ''){ $where.= " AND ( PrdCode IN (".$catalogo_subcategoria.") ) "; }

            if ($catalogo_tipo_inventario == '1'){
                $tipoInv = ' ifnull(OnHand,0) ';
            } else if ($catalogo_tipo_inventario == '2'){
                $tipoInv = ' ifnull(invdts.qty,0) ';
            } else {
                $tipoInv = ' ifnull(OnHand,0) + ifnull(invdts.qty,0) ';
            }

            if($catalogo_stock != ''){ $where.= " AND ( ".$tipoInv." ".$catalogo_stock_cond." '".$catalogo_stock."' ) "; }

//            if($catalogo_stock != ''){ $where.= " AND ( OnHand ".$catalogo_stock_cond." '".$catalogo_stock."' ) "; }
            if($catalogo_flags != ''){ 
                $arr_flag = explode('/*',str_replace('_/*', '', '_'.$catalogo_flags));
                $where_flag = " AND (";
                foreach ($arr_flag as $r_flag)
                { 
                    $where_flag.= " ( ".$r_flag." = '1' ) OR"; 
                }
                $where.= str_replace("ORX","",$where_flag."X")." )";
            }


            if ($catalogo_ventaFrom != ''){
                $where .= " AND dateord >= '". $catalogo_ventaFrom . "'";
            }

            if ($catalogo_ventaTo != ''){
                $where .= " AND dateord <= '". $catalogo_ventaTo . "'";
            }



           
           // $n_elem_pag = 50;
          //  if($n_pag == ''){ $ini_pag = 0; }else{ $ini_pag = $n_pag*$n_elem_pag; }
            $n_pag++;
            $limit = '';          
            //$campos = '*';
            $campos = ' distinct
            `inventory`.`Desc` ,
            `inventory`.`SkuNo` ,
            `inventory`.`PartNo` ,
             ifnull(z.Precio,0) as Precio,
        (select PrdDesc from `codes catsub` where PrdCode = `inventory`.`PrdCode` LIMIT 1) AS `PrdDesc`,
		ifnull((select iix.partno from `Inventory Items Xref` iix where 
			iix.mfgcode = \'TEX\' and iix.`desc` = \'WELLS\' and iix.skuno = inventory.skuno limit 1),\'\') as wells,
		ifnull((select iix.partno from `Inventory Items Xref` iix where 
			iix.mfgcode = \'TEX\' and iix.`desc` in (\'SMP\',\'Standard\') and iix.skuno = inventory.skuno limit 1),\'\') as smp,
		ifnull((select iix.partno from `Inventory Items Xref` iix where 
			iix.mfgcode = \'TEX\' and iix.`desc` in (\'TOMCO\',\'TOMCO MX\') and iix.skuno = inventory.skuno limit 1),\'\') as tomco,
		ifnull((select iix.partno from `Inventory Items Xref` iix where 
			iix.mfgcode = \'OEM\' and  iix.skuno = inventory.skuno  limit 1),\'\') as oem



            ';



            $myTable = "
                   inventory 
                    left join (
                    select  det.SkuNo, det.precio,
                    DATE_FORMAT(max(ofer.Date_To),'%d/%m/%Y') AS Date_To_dma,
                    DATE_FORMAT(max(ofer.Date_From),'%d/%m/%Y') AS Date_From_dma
                    
                     from  `ofertas detail` det
                    left join `ofertas` ofer
                    on (ofer.ofertaid = det.id )
                    group by
                    det.SkuNo, det.precio
                    order by ofer.date_to desc
                    limit 1
                    ) z
                    on (z.SkuNo = inventory.SkuNo)
left join
(
                            select 
                                aa.`SkuNo`,
                                (aa.`Qty`) qty
                            from
                                `inventory dts` aa
                            where
                        
                             (aa.`SkuNo` <> 0) and
                             qty = (select max(qty) from `inventory dts`  where SkuNo = aa.SkuNo)
                             ) as invdts
                            on (invdts.SkuNo = inventory.SkuNo)
                            left join `inventory pricing` invpri
                            on (invpri.SkuNo = inventory.SkuNo and invpri.PriceColumn = 4)
                        left join (
                            
                            select max(ord.invDate) as dateord, orddet.skuno from `orders detail` orddet
                            left join
                            orders ord
                            on (ord.ordid = orddet.ordid)
                            group by orddet.skuno

                        ) y
                        on (y.skuno = inventory.SkuNo)

                            
            ";

           // $resul_n = $obj_bdmysql->num_row(myTable, $where ,$mysqli);
            $resul = $obj_bdmysql->select($myTable, $campos, $where, "PartNo", $limit,$mysqli,false);
           // $mss = $resul;
            //var_dump($resul);

            $resul_n = 1;
            if(count($resul) == 0){ 
                $mss = 'NO SE ENCONTRARON ARTICULOS. ';
            }else{
                if(!is_array($resul)){ 
                    $mss = 'NO SE ENCONTRARON ARTICULOS. '.$resul;
                }else{
                    $mss = 1;
                    $salida = $resul;
                   /* if($n_pag == 1){

                    $salida = '<tr>
                                    <th>N</th>
                                    <th>Sel</th>
                                    <th width="10%">SkuNo</th>
                                    <th width="10%">PartNo</th>
                                    <th>Descripcion</th>
                                    <th>Sub Cat.</th>
                                    <th class="numeric">Precio</th>
                                    <th>Cat Tex.</th>
                                    <th>Cat DTS.</th>
                                    <th class="numeric">Oferta</th>
                                    <th>Ini. Oferta</th>
                                    <th>Fin. Oferta</th>
                                    <th>Flag</th>
                                </tr>';
                    }
                    $salida.= '<tr id="'.$n_pag.'"><td colspan="12">PAGINA '.$n_pag.'</td></tr>';
                    $n = $ini_pag+1;
                    foreach ($resul as $r){
                        //DEFINE PRECIO
                        $precio = '0';
                        //DEFINE FLAG
                        $flag = '';
                        if($r['Flag01'] == '1'){ $flag.= 'Flag01, '; }
                        if($r['Flag02'] == '1'){ $flag.= 'Flag02, '; }
                        if($r['Flag03'] == '1'){ $flag.= 'Flag03, '; }
                        if($r['Flag04'] == '1'){ $flag.= 'Flag04, '; }
                        if($r['Flag05'] == '1'){ $flag.= 'Flag05, '; }
                        if($r['Flag06'] == '1'){ $flag.= 'Flag06, '; }
                        if($r['Flag07'] == '1'){ $flag.= 'Flag07, '; }
                        if($r['Flag08'] == '1'){ $flag.= 'Flag08, '; }
                        if($r['Flag09'] == '1'){ $flag.= 'Flag09, '; }
                        if($r['Flag10'] == '1'){ $flag.= 'Flag10, '; }
                        if(trim($flag) != ''){ $flag = str_replace(', _', '', $flag.'_'); }else{ $flag = 'No Aplica'; }

                        //DEFINE OFERTAS
    //                    select *,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma 
    //FROM autodatasystem.`ofertas detail` as a LEFT JOIN autodatasystem.ofertas as b ON a.ID = b.OfertaId
    //WHERE SkuNo = '113631' ORDER BY b.Date_To DESC LIMIT 1
                        $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$r['SkuNo']."'", "Date_To DESC", "1",$mysqli);
                        if(!is_array($resul_oferta)){ $oferta = '0'; $fecha_to_oferta = '00/00/0000'; $fecha_from_oferta = '00/00/0000'; 
                        }else{    $oferta = $resul_oferta[0]['Precio']; $fecha_to_oferta = $resul_oferta[0]['Date_To_dma']; $fecha_from_oferta = $resul_oferta[0]['Date_From_dma'];   }
                        if($resul_n <= $limit_busqueda){ $mss = '1'; }else{ $mss = '2'; }
//                        if($resul_n <= $limit_busqueda){ 
                        $mss = '1';
                        $catalogo_articulo_arr = $r['SkuNo'].'/*'.$r['PartNo'].'/*'.$r['ProdDesc'].'/*'.$r['CatDesc'].'/*'.$r['PrdDesc'].'/*'.$precio.'/*'.$r['OnHand'].'/*'.$oferta.'/*'.$fecha_to_oferta.'/*'.$fecha_to_oferta.'/*'.$flag;
                        $salida.= '
                                <tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_'.$r['SkuNo'].'" >
                                    <td data-title="N" style="text-align:center;">'.$n.'</td>
                                    <td data-title="CH" style="text-align:center;"><input type="checkbox" id="catalogo_articulo_list_ch_'.$r['SkuNo'].'" value="'.$r['SkuNo'].'"></td>
                                    <td data-title="SKUNO" id="catalogo_articulo_list_cod">'.$r['SkuNo'].'</td>
                                    <td data-title="PARTNO">'.$r['PartNo'].'</td>
                                    <td data-title="ArtICULO">'.$r['ProdDesc'].'</td>
                                    <td data-title="CATEGORIA">'.$r['CatDesc'].'</td>
                                    <td data-title="SUB CATEGORIA">'.$r['PrdDesc'].'</td>
                                    <td class="numeric" data-title="PRECIO">'.$precio.'</td>
                                    <td class="numeric" data-title="STOCK">'.$r['OnHand'].'</td> 
                                    <td class="numeric" data-title="STOCK">'.$r['qty_dts'].'</td> 
                                    <td class="numeric" data-title="OFERTA">'.$oferta.'</td> 
                                    <td data-title="INI. OFERTA">'.$fecha_to_oferta.'</td>
                                    <td data-title="FIN OFERTA">'.$fecha_from_oferta.'</td>
                                    <td data-title="FLAG">'.$flag.'</td>
                                    <input type="hidden" id="catalogo_articulo_arr_'.$r['SkuNo'].'" value="'.$catalogo_articulo_arr.'">
                                </tr>';
                        $n = $n +1;*/
                  //  }
                }
            }
            
             
        }else{ $mss = 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error;}
        $resp = array('mss' => utf8_encode($mss), 'salida' => ($salida));
       // header('Content-type: application/json');
        echo (json_encode($resp));
    break;
    //CARGA ARTICULOS AL CATALOGO
    case 'catalogoArtCarga':
        $mss = '';
        $salida = '';
        $where = "1";
        $n = 1;
        if($ch_art != ''){
            $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
            if (!$mysqli->connect_error) {
                $art = explode('/*', str_replace('_/*', "", '_'.$ch_art));
                foreach ($art as $arr_art){
                    $where.=" OR SkuNo = '".$arr_art."'";
                }
                $campos = "*,'00/00/0000' as fe_oferta_dmy,(SELECT CatDesc FROM `codes cat` WHERE `codes cat`.CatCode = inventory.CatCode) as CatDesc, (SELECT PrdDesc FROM `codes catsub` WHERE `codes catsub`.PrdCode = inventory.PrdCode) as PrdDesc";
                $resul = $obj_bdmysql->select("inventory", $campos, $where, "PartNo", "",$mysqli);
                if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$cod_articulo; 
                }else{

                    $salida = '<tr>
                                    <th>N</th>
                                    <th>Sel</th>
                                    <th>Codigo</th>
                                    <th>Articulo</th>
                                    <th>Cat.</th>
                                    <th>Sub Cat.</th>
                                    <th class="numeric">Precio</th>
                                    <th class="numeric">Stock</th>
                                    <th class="numeric">Oferta</th>
                                    <th>Ini. Oferta</th>
                                    <th>Fin. Oferta</th>
                                    <th>Flag</th>
                                </tr>';
                    foreach ($resul as $r){
                        //DEFINE PRECIO
                        $precio = '';
                        //DEFINE FLAG
                        $flag = '';
                        if($r['Flag01'] == '1'){ $flag.= 'Flag01, '; }
                        if($r['Flag02'] == '1'){ $flag.= 'Flag02, '; }
                        if($r['Flag03'] == '1'){ $flag.= 'Flag03, '; }
                        if($r['Flag04'] == '1'){ $flag.= 'Flag04, '; }
                        if($r['Flag05'] == '1'){ $flag.= 'Flag05, '; }
                        if($r['Flag06'] == '1'){ $flag.= 'Flag06, '; }
                        if($r['Flag07'] == '1'){ $flag.= 'Flag07, '; }
                        if($r['Flag08'] == '1'){ $flag.= 'Flag08, '; }
                        if($r['Flag09'] == '1'){ $flag.= 'Flag09, '; }
                        if($r['Flag10'] == '1'){ $flag.= 'Flag10, '; }
                        if(trim($flag) != ''){ $flag = str_replace(', _', '', $flag.'_'); }else{ $flag = 'No Aplica'; }

                        //DEFINE OFERTAS
                        $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$cod_articulo."'", "ID", "1",$mysqli);
                        if(!is_array($resul_oferta)){ $oferta = '0'; $fecha_to_oferta = '00/00/0000'; $fecha_from_oferta = '00/00/0000'; 
                        }else{    $oferta = $resul_oferta[0]['Precio']; $fecha_to_oferta = $resul_oferta[0]['Date_To_dma']; $fecha_from_oferta = $resul_oferta[0]['Date_From_dma'];   }
                        $mss = '1';
                        $salida.= '
                                <tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_'.$r['SkuNo'].'">
                                    <td data-title="N" style="text-align:center;">'.$n.'</td>
                                    <td data-title="CH" style="text-align:center;"><input type="checkbox" id="catalogo_articulo_list_ch_'.$r['SkuNo'].'" class="catalogo_ch_sel" value="'.$r['SkuNo'].'"></td>
                                    <td data-title="CODIGO" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="'.$r['SkuNo'].'">'.$r['SkuNo'].'</td>
                                    <td data-title="ArtICULO">'.$r['ProdDesc'].'</td>
                                    <td data-title="CATEGORIA"><input type="hidden" id="catalogo_articulo_list_categoria" class="catalogo_articulo_list_cod" value="'.$r['CatCode'].'">'.$r['CatDesc'].'</td>
                                    <td data-title="SUB CATEGORIA"><input type="hidden" id="catalogo_articulo_list_subcategoria" class="catalogo_articulo_list_cod" value="'.$r['PrdCode'].'">'.$r['PrdDesc'].'</td>
                                    <td class="numeric" data-title="PRECIO"><input type="text" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="'.$precio.'"></td>
                                    <td class="numeric" data-title="STOCK"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="'.$r['OnHand'].'"></td> 
                                    <td class="numeric" data-title="OFERTA"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="'.$oferta.'"></td> 
                                    <td data-title="INI. OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'.$fecha_to_oferta.'" onkeyup="mascara(this,\'/\',patron,true);"></td>
                                    <td data-title="FIN OFERTA"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'.$fecha_to_oferta.'" onkeyup="mascara(this,\'/\',patron,true);"></td>
                                    <td data-title="FLAG">'.$flag.'</td>
                                </tr>';
                        $n = $n +1;
                    }
                }
            }else{ $mss = 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error;}
        }else{ $mss = 'NO HAY ARTICULOS SELECCINADOS...';}
//        $mss = $where;
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
        /*
        $catalogo_articulo = explode(' ', $catalogo_articulo);
        $cod_articulo = trim($catalogo_articulo[0]);
        $mss = '';
        $salida = '';
//        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
        $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli->connect_error) {
//            $resul = $obj_bdmysql->select("art", "*,DATE_FORMAT(fe_oferta,'%d/%m/%Y') as fe_oferta_dmy", "codigo = '".$cod_articulo."'", "", "",$mysqli);
            $resul = $obj_bdmysql->select("inventory", "*,'00/00/0000' as fe_oferta_dmy", "SkuNo = '".$cod_articulo."'", "", "",$mysqli);
            if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$cod_articulo; 
            }else{
                $mss = '1';
                $salida = '
                        <tr class="catalogo_articulo_fila" id="catalogo_articulo_fila_'.$resul[0]['SkuNo'].'">
                            <td data-title="remove" id="catalogo_articulo_list_remove_'.$resul[0]['SkuNo'].'" style="text-align:center;" onclick="remover_articulo(this.id);"><i class="fa fa-trash-o" style="font-size:28px"></i></td>
                            <td data-title="Code" id="catalogo_articulo_list_cod"><input type="hidden" id="catalogo_articulo_list_price" class="catalogo_articulo_list_cod" value="'.$resul[0]['codigo'].'">'.$resul[0]['codigo'].'</td>
                            <td data-title="Article">'.$resul[0]['ProdDesc'].'</td>
                            <td class="numeric" data-title="Price"><input type="text" id="catalogo_articulo_list_price" class="form-control" placeholder="Price" value="'.$resul[0]['precio'].'"></td>
                            <td class="numeric" data-title="Stock"><input type="text" id="catalogo_articulo_list_stock" class="form-control" placeholder="Stock" value="'.$resul[0]['stock'].'"></td> 
                            <td class="numeric" data-title="Sale"><input type="text" id="catalogo_articulo_list_sale" class="form-control" placeholder="Sale" value="'.$resul[0]['oferta'].'"></td> 
                            <td data-title="Date Sale"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'.$resul[0]['fe_oferta_dmy'].'" onkeyup="mascara(this,\'/\',patron,true);"></td>
                        </tr>';
            }
        }else{ $mss = 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error;}
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);*/
    break;
    //GUARDA CATALOGO
    case 'flyerGuardar':
        
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
        $salida = "";
        //$mss="tst";
        
        if (!$mysqli->connect_error){
        	$campos = "tittle, description, background_img, type";

        	//este es el tipo de archivo
			$imagen_temporal = "../../assets/img/fondoFlyer/";
			$directorio = opendir("../../assets/img/fondoFlyer"); //ruta actual
			while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
			{
			    if (strpos($archivo, 'fondoTemp.') !== false){
			    	$arr = explode('.', $archivo);
			    	//echo "La extension es: " . $arr[1];
			    	$archivoFinal = $archivo;
			    	$tipoArchivo = $arr[1];
			    	break;
			    }
			    
			}

			//leer el archivo temporal en binario
            $fp     = fopen($imagen_temporal.$archivoFinal, 'r+b');
            $data = fread($fp, filesize($imagen_temporal.$archivoFinal));
            fclose($fp);

                //escapar los caracteres
            $data = $mysqli->real_escape_string($data);

        	$valores = "'" . $flyer_tittle . "', '" . $flyer_description. "', '" . $data. "', '" . $tipoArchivo . "'";
        	$insert = $obj_bdmysql->insert("flyer", $campos, $valores, $mysqli);
        	if ($insert == "1"){
        		$idFlyer = $obj_bdmysql->getUltID();
        		$productsFinal = explode('/*', $products);

        		foreach ($productsFinal as $key => $value) {
        			if ($key != 0) {
        			$campos = "name, no_part, alias, xref, smp, tomco, oem,
        			price_name_one, price_name_two, price_name_three, price_one, price_two, 
        			price_three, flayer_idflyer, image";
        			//echo $value;
        			$arrVal = explode('|',$value);
        			//var_dump ( empty(trim($arrVal[11])));
        			$skuno = $arrVal[1];
        			$priceOne = ((trim($arrVal[11])) === '') ? "'0'":"'".$arrVal[11]."'";
        			$priceTwo = ((trim($arrVal[12])) === '') ? "'0'":"'".$arrVal[12]."'";
        			$priceThree = ((trim($arrVal[13])) === '') ? "'0'":"'".$arrVal[13]."'";
        			$imagen_temporal = "../../assets/img/art/";
        			if (file_exists("../../assets/img/art/" . trim($skuno) . ".jpg")) {
							
						$fp     = fopen("../../assets/img/art/" . trim($skuno) . ".jpg", 'r+b');
		            	$data = fread($fp, filesize("../../assets/img/art/" . trim($skuno) . ".jpg"));
		            	fclose($fp);

		                //escapar los caracteres
		            	$data = "'" . $mysqli->real_escape_string($data) . "'";//ruta actual
					} else {
						$data = "NULL";
					}
					
        			 $valores = "'', " 
        			 		  ."'" . $arrVal[2] . "', " 
        			 		  . "'" . $arrVal[7] . "', " 
        			 		  . "'', " 
        			 		  . "'" . $arrVal[5] . "', " 
        			 		  . "'" . $arrVal[4] . "', " 
        			 		  . "'" . $arrVal[6] . "', " 
        			 		  . "'" . $arrVal[8] . "', " 
        			 		  . "'" . $arrVal[9] . "', " 
        			 		  . "'" . $arrVal[10] . "', " 
        			 		  . "" . $priceOne . ", " 
        			 		  . "" . $priceTwo . ", " 
        			 		  . "" . $priceThree . ", "
        			 		  . "'" . $idFlyer . "', "
        			 		  . "" . $data . " " ;
        			$insert = $obj_bdmysql->insert("productflyer", $campos, $valores, $mysqli);
        			//echo $insert;

        		}

        		}

        		$salida = "Flyer Created";
        		$mss = "1";
        	} else {
        		$mss = "Error inserting Flyer. " . $insert;
        	}
         } else {
         	$mss = "Not Connected to DB";

         }
//        $mss = 'ART: '.$articulos;

        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
    break;
    //EDITA CATALOGO
    case 'catalogoEditar':
        $portada = $_SESSION['cod_img'];
        $fondo = $_SESSION['cod_img_fd'];
        $art_repetido = ''; 
        $mysqli2 = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli2->connect_error){
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
            if (!$mysqli->connect_error){
                $mss = '';
                $salida = '';

                if($articulos != ''){
                    //EXTRAE DATOS DEL ARTICULO
                    $catalogo_articulo_array = explode('/*',str_replace('_/*','','_'.$articulos));
                    $i_val = 0;
                    foreach ($catalogo_articulo_array as $ca_array_val){
                        $catalogo_reng_val = explode('|',str_replace('_|','','_'.$ca_array_val));
                        $cod_articulo_val = trim($catalogo_reng_val[0]);
                        $eval_ca_array[$i_val] = $cod_articulo_val;
                        $eval_ca_array_c[$i_val] = $cod_articulo_val;
                        $i_val = $i_val + 1;
                    }


                    //VALIDA SI EL ARTICULO EXISTE EN LA TABLA ARTICULO Y SI ESTA REPETIDO
                    $art_no_existe = '';
                    foreach ($eval_ca_array as $eval_ca_array_){
                        $repetido = 0;
                        $art_repetido = ''; 
                        foreach ($eval_ca_array_c as $eval_ca_array_c_){
                            if($eval_ca_array_ == $eval_ca_array_c_){
                                $repetido = $repetido + 1;
                                $art_repetido.= $eval_ca_array_.' == '.$eval_ca_array_c_.', ';
                            }
                        }
                        if($obj_bdmysql->num_row("inventory", "SkuNo = '".$eval_ca_array_."'", $mysqli2) == 0){
                            $art_no_existe = $art_no_existe.', '.$eval_ca_array_;
                        }
                    }


                    if($repetido < 2){
                        if($art_no_existe == ''){
                            if($catalogo_titulo != ''){
//                            if($catalogo_codigo != '' AND $catalogo_titulo != '' AND $catalogo_descripcion != ''){
                            if(preg_match(EXP_REG_RGB, $catalogo_titulo_color)){   
                                if($catalogo_img_portada_del == '1'){
                                    if($portada != 'def.jpg'){
                                        $nombre_archivo = '../../assets/bootstrap-fileinput-master/portadas_temp/'.$portada;
                                        $val_img = file_exists($nombre_archivo);
                                        $upd_portada = ",portada = '".$portada."'";
                                    }else{ 
                                        $val_img = TRUE; 
                                        $upd_portada = "";
                                    }
                                }else{
                                    $val_img = TRUE; 
                                    $upd_portada = ",portada = '".$portada."'";
                                }

                                if($catalogo_img_fondo_del == '1'){
                                    if($fondo != 'def.jpg'){
                                        $nombre_archivo_fd = '../../assets/bootstrap-fileinput-master/fondo_temp/'.$fondo;
                                        $val_img_fd = file_exists($nombre_archivo_fd);
                                        $upd_fondo = ",fondo = '".$fondo."'";
                                    }else{ 
                                        $val_img_fd = TRUE; 
                                        $upd_fondo = "";
                                    }
                                }else{
                                    $val_img_fd = TRUE; 
                                    $upd_fondo = ",fondo = '".$fondo."'";
                                }

//                                if($val_img AND $val_img_fd){
                                    $val_cod = $obj_bdmysql->num_row("catalogo", "codigo = '".$catalogo_codigo."' AND id_catalogo != '".$catalogo_id."'", $mysqli);
                                    if($val_cod == 0){
                                        $catalogo_sel = $obj_bdmysql->select("catalogo", "*", "codigo = '".$catalogo_codigo."' AND id_catalogo = '".$catalogo_id."'", "", "", $mysqli);
                                    //CONEXION CON BD
                                        if($catalogo_id != ''){                 
                                            //INICIA TRANSACCION
                                            $mysqli->autocommit(FALSE);
                                            //EDITA CATALOGO
                                            $campo = "codigo = '".$catalogo_codigo."',titulo = '".$catalogo_titulo."',descripcion = '".$catalogo_descripcion."'".$upd_portada.$upd_fondo.",precio_pdf = '".$catalogo_sel_precio_pdf."',order_id = '".$catalogo_order_id."',titulo_fuente = '".$catalogo_titulo_fuente."',titulo_tamano = '".$catalogo_titulo_tamano."',titulo_color = '".$catalogo_titulo_color."',titulo_estilo = '".$catalogo_titulo_estilo."',titulo_ali_hor = '".$catalogo_titulo_ali_hor."',titulo_ali_ver = '".$catalogo_titulo_ali_ver."',co_us_mo = '".$cod_usuario."',fe_us_mo = NOW(), presentacion = '".$catalogo_sel_presentacion."'";
//                                            $campo = "codigo = '".$catalogo_codigo."',titulo = '".$catalogo_titulo."',descripcion = '".$catalogo_descripcion."'".",precio_pdf = '".$catalogo_sel_precio_pdf."',co_us_mo = '".$cod_usuario."',fe_us_mo = NOW()";
                                            $where = "id_catalogo = '".$catalogo_id."'";
        //                                    $catalogo_insert = $obj_bdmysql->insert("catalogo", $campo, $valor, $mysqli);
                                            $catalogo_insert = $obj_bdmysql->update("catalogo", $campo, $where, $mysqli);
                                            if($catalogo_insert  == '1'){
                                                //ELIMINA RENGLONES DEL CATALOGO
                                                $catalogo_reng_delete = $obj_bdmysql->delete("catalogo_reng", $where, $mysqli);
                                                if($catalogo_reng_delete  == '1'){
                                                    //INSERTA LOS RENGLONES DEL CATALOGO
                                                    $num_reng = 1;
                                                    $error_reng = '';
                                                    $campo = "id_catalogo, reng_num, cod_art, precio, precio_sugerido, oferta, fe_oferta, fe_oferta_fin, stock_ini, stock_act, stock_comp, stock_ped, cat, subcat, PartNo, ProdDesc, co_us_in, fe_us_in, co_us_mo, fe_us_mo, co_us_de, fe_us_de, cat_desc, detalles";
                                                    foreach ($catalogo_articulo_array as $ca_array){
                                                        $catalogo_reng = explode('|',str_replace('_|','','_'.$ca_array));
                                                        $SkuNo = trim($catalogo_reng[0]);
                                                        $PartNo = trim($catalogo_reng[1]);
                                                        $ProdDesc = trim($catalogo_reng[2]);
                                                        $precio = trim($catalogo_reng[3]);
                                                        $OnHand = trim($catalogo_reng[4]);
                                                        $oferta = trim($catalogo_reng[5]);
                                                        $fecha_to_oferta = (trim($catalogo_reng[6]) == '') ? '00/00/0000' : trim($catalogo_reng[6]);
                                                        $fecha_from_oferta = (trim($catalogo_reng[7]) == '') ? '00/00/0000':trim($catalogo_reng[7]);
                                                        $valor = "'".$catalogo_id."','".$num_reng."','".$SkuNo."','".$precio."','0','".$oferta."','".$fecha_to_oferta."','".$fecha_from_oferta."','".$OnHand."','".$OnHand."','".$OnHand."','".$OnHand."','0','','".$PartNo."','".$ProdDesc."','1',CURRENT_TIME,'0',CURRENT_TIME,'0',CURRENT_TIME, '', ''";
                                                        $catalogo_reng_insert = $obj_bdmysql->insert("catalogo_reng", $campo, $valor, $mysqli, false);
                                                        $num_reng = $num_reng + 1; 
                                                        $linkArtQR = "http://textronic.us/showitem.aspx?id=" . $SkuNo;
                                                        $obj_function->codeQR($linkArtQR, $SkuNo, TRUE);
                                                        if($catalogo_reng_insert != '1'){ $error_reng = $error_reng.'. '.$catalogo_reng[0].': '.$catalogo_reng_insert; }
                                                    }

                                                    if($error_reng == ''){
                                                        //GENERA CODIGO QR O LO ACTUALIZA
                                                        $id_catalogo_code = $obj_function->code_url($catalogo_id,'code');
                                                        $link = 'http://textronic.info/cat/cv?cd='.$id_catalogo_code;
//                                                        $url = "http://www.gibble.com.ve/textronic/web/index.php?id=".$id_catalogo_code;
                                                        $s = $obj_function->codeQR($link, $catalogo_id);
                                                        //CARGA IMAGEN DE PORTADA
                                                        if($portada != 'def.jpg'){
                                                            $mv_portada = rename($nombre_archivo,'../../assets/bootstrap-fileinput-master/portadas/'.$portada);
                                                        } else { $mv_portada = TRUE; }                                                    
                                                        //CARGA IMAGEN DE FONDO
                                                        if($fondo != 'def.jpg'){
                                                            $mv_fondo = rename($nombre_archivo_fd,'../../assets/bootstrap-fileinput-master/fondo/'.$fondo);
                                                        }  else { $mv_fondo = TRUE; }

                                                        //ELIMINA IMAGEN DE PORTADA SI SE ELIMINO
                                                        $del_portada_arc = '../../assets/bootstrap-fileinput-master/portadas/'.$catalogo_sel[0]['portada'];
                                                        $del_portada = TRUE;
                                                        $dp = 'portada no elimina';
//                                                        if($catalogo_img_portada_del == '0'){ if(file_exists($del_portada_arc)){ $dp = 'portada elimina';/*$del_portada = unlink($del_portada_arc);*/} }
                                                        if($catalogo_img_portada_del == '0'){ if(file_exists($del_portada_arc)){ $del_portada = unlink($del_portada_arc);} }
                                                        //ELIMINA IMAGEN DE FONDO SI SE ELIMINO
                                                        $del_fondo_arc = '../../assets/bootstrap-fileinput-master/fondo/'.$catalogo_sel[0]['fondo'];
                                                        $del_fondo = TRUE;
                                                        $df = 'fondo no elimina';
//                                                        if($catalogo_img_fondo_del == '0'){ if(file_exists($del_fondo_arc)){ $df = 'fonod elimina';/*$del_fondo = unlink($del_fondo_arc);*/} }
                                                        if($catalogo_img_fondo_del == '0'){ if(file_exists($del_fondo_arc)){ $del_fondo = unlink($del_fondo_arc);} }
                                                        
                                                        if ($mv_portada){
                                                            if ($mv_fondo){
                                                                if($del_portada AND $del_fondo){
//                                                                    $mss = 'CATALOGO EDITADO CORRECTAMENTE.'.$catalogo_img_portada_del.' = '.$dp.', '.$catalogo_img_fondo_del.' = '.$df.'.';
                                                                    $mss = 'CATALOGO EDITADO CORRECTAMENTE.';
                                                                    $mysqli->commit();
                                                                    $_SESSION['cod_img'] = 'def.jpg';
                                                                    $_SESSION['cod_img_fd'] = 'def.jpg';
                                                                }else{ $mss = 'ERROR AL ELIMINAR IMAGEN DE PORTADA Y/O FONDO.';}
                                                            }else{ $mss = 'ERROR AL CARGAR IMAGEN DE FONDO.'; rename('../../assets/bootstrap-fileinput-master/portadas/'.$portada,$nombre_archivo); }
                                                        }else{ $mss = 'ERROR AL CARGAR IMAGEN DE PORTADA.'; }
                                                    }else{ $mss = 'ERROR AL GUARDAR ARTICULOS CON CODIGO: '.$error_reng;}
                                                }else{ $mss = 'ERROR AL ACTUALIZAR ARTICULOS';}
                                            }else{ $mss = 'ERROR AL GUARDAR CATALOGO: '.$catalogo_insert;}
                                        }else{ $mss = 'ERROR AL IDENTIFICAR ID DE CATALOGO.';}
                                    }else{ $mss = 'EL CODIGO DEL CATALOGO YA EXISTE.'.$val_cod.$catalogo_codigo."'  '".$catalogo_id;}
//                                $mss = 'DATOS: portada = '.$catalogo_img_portada_del.', fondo = '.$catalogo_img_fondo_del;
//                                }else{ $mss = 'NO SE ENCONTRO LA IMAGEN DE PORTADA Y/O LA IMAGEN DE FONDO. POR FAVOR ELIMINELAS Y CARGUELAS NUEVAMENTE DE SER NECESARIO.'; }
                            }else{ $mss = 'EL COLOR DEL TITULO NO PARECE SER VALIDO.';}       
//                            }else{ $mss = 'VERIFIQUE LOS CAMPOS OBLIGATORIOS.';}
                            }else{ $mss = 'VERIFIQUE QUE EL CAMPO TITULO NO ESTE VACIO.';}
                        }else{ $mss = 'LOS SIGUIENTES ARTICULOS NO FUERON ENCONTRADOS EN LA TABLA ARTICULOS: '.$art_no_existe; }
                    }else{ $mss = 'ERROR AL GUARDAR EL CATALOGO LOS SIGUIENTES ARTICULOS SE ENCUENTRAN REPETIDOS: '.$repetido.', '.$art_repetido;}
                }else{ $mss = 'DEBE INDICAR AL MENOS UN ARTICULO.';}
            }else{ $mss = 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error;}
        }else{ $mss = 'ERROR EN CONEXION CON LA BD2: '.$mysqli2->connect_error;}
//        $portada = $_SESSION['cod_img'];$fondo = $_SESSION['cod_img_fd'];
//        $mss = '.'.$portada.','.$fondo.'.';
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
    break;
    //ELIMINA CATALOGO
    case 'catalogoEliminar':
            $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
            if (!$mysqli->connect_error){
                
                $mss = 'php';
                
                $salida = '';
                if($id != ''){
//                    //INICIA TRANSACCION
                    $mysqli->autocommit(FALSE);
                    $tabla = "catalogo";
                    $tabla_reng = "catalogo_reng";
                    $where = "id_catalogo = '".$id."'";
                    if($obj_bdmysql->num_row($tabla, $where, $mysqli) > 0){
                        //PORTADA Y FONDO
                        $resul = $obj_bdmysql->select($tabla,"*",$where,"","",$mysqli);

                        if(trim($resul[0]['portada']) == ''){ $resul[0]['portada'] = 'img'; }
                        if(trim($resul[0]['fondo']) == ''){ $resul[0]['fondo'] = 'img'; }
                        $portada = '../../assets/bootstrap-fileinput-master/portadas/'.$resul[0]['portada'];
                        $fondo = '../../assets/bootstrap-fileinput-master/fondo/'.$resul[0]['fondo'];
    //                    //ELIMINA CATALOGO
                        $catalogo_insert = $obj_bdmysql->delete($tabla,$where,$mysqli);
                        if($catalogo_insert  == '1'){
                            //ELIMINA RENGLONES DEL CATALOGO
                            $catalogo_reng_insert = $obj_bdmysql->delete($tabla_reng,$where,$mysqli);
                            if($catalogo_reng_insert  == '1'){
                                //ELIMINA IMAGENES
                                if(file_exists($portada) && strcmp($resul[0]['portada'], 'def.jpg') !== 0){
                                    if(unlink($portada)){
                                        $portada_val = 1;
                                    }else{
                                         $portada_val = '1';
                                    }
                                }else{
                                     $portada_val = '1';
                                }
                                if(file_exists($fondo) && strcmp($resul[0]['portada'], 'def.jpg') !== 0){
                                     if(unlink($fondo)){
                                        $fondo_val = 1;
                                    }else{ 
                                        $fondo_val = '1';
                                    }
                                }else{ 
                                    $fondo_val = '1'; 
                                }
                                if($portada_val == '1'){
                                    if($fondo_val == '1'){
                                        $mss = '1';$salida = 'REGISTRO ELIMINADO CORRECTAMENTE. '; $mysqli->commit();
                                    }else{ $mss = 'ERROR AL ELIMNAR IMAGEN DE FONDO.'; }
                                }else{ $mss = 'ERROR AL ELIMINAR IMAGEN DE PORTADA. '.$portada; }
                            }else{ $mss = 'ERROR AL ELIMINAR REGISTRO: '.$catalogo_reng_insert;}
                        }else{ $mss = 'ERROR AL ELIMINAR REGISTRO: '.$catalogo_insert;}
                    }else{ $mss = 'ERROR AL NO SE ENCONTRARON RESULTADOS PARA EL ID DEL CATALOGO.'.$id;}
                }else{ $mss = 'ERROR AL IDENTIFICAR ID DE CATALOGO.';}
            }else{ $mss = 'ERROR EN CONEXION CON LA BD: '.$mysqli->connect_error;}
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
    break;
    case 'carga_subcategoria':
        $mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli->connect_error){
            //$salida = '<option value="">Seleccione...</option>';
            $salida = '';
            $n_vehiculos = $obj_bdmysql->num_row("`codes catsub`", "CatCode = '".$cat_val."'", $mysqli);
            if($n_vehiculos > 0){
                $mss = 1;
                $resul = $obj_bdmysql->select("`codes catsub`", "*", "CatCode = '".$cat_val."'", "PrdCode", "0,100",$mysqli);
                if(!is_array($resul)){
                 $mss = 'ERROR AL CARGAR DATOS.'; 
             }
                foreach ($resul as $r){
                    //$salida.= '<option value="'.$r['PrdCode'].'">'.$r['PrdDesc'].'</option>';
					$salida.='<input type="checkbox" id="catalogo_ch_'.$r['PrdCode'].'" value="'.$r['PrdCode'].'"> <label for="catalogo_ch_'.$r['PrdCode'].'">'.$r['PrdDesc'].'</label> <br>';
                }
            }else{
                $mss = 'NO SE ENCONTRARON DATOS';
            }
        }else{ $mss = 'ERROR EN CONEXION CON LA BD.'; }
        $resp = array('mss' => utf8_encode($mss), 'salida' => utf8_encode($salida));
        echo json_encode($resp);
    break;
    default :
        echo json_encode(array('mss' => utf8_encode('NO SE IDENTIFICO LA SOLICITUD. '.$opc.'.'), 'salida' => utf8_encode('')));
    break;
}
