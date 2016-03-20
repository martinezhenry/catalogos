<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'general.php';
$obj_bdmysql = new coBdmysql();

$obj_function = new coFunction();

//IIIIIIIIIIIIIIIIIIIIIIIIII   PRUEBAS DE INSERT UPDATE
$tabla = "master_id";
$id = "id_catalogo";
//$max_id = "1";
//echo $obj_bdmysql->update($tabla, "$id = '".$max_id."'","",TRUE);
//echo $obj_bdmysql->insert($tabla, $id, "'1'",TRUE);
//echo $obj_function->master_id('id_catalogo', 'ext').'<br>';
//echo $obj_function->master_id('id_catalogo', 'act');

//$max_id = $obj_function->master_id($id,'ext');
//if($max_id == '1'){
//    if($obj_bdmysql->insert($tabla, $id, "'1'") == '1'){ $resp = '1'; }
//}else{
//    if($obj_bdmysql->update($tabla, "$id = '".$max_id."'","") == '1'){ $resp = '1'; }
//}
//echo $max_id.', '.$resp;
//$resul = $obj_bdmysql->select('*', 'art', '', '', '');
//if(!is_array($resul)){ $resul = array('mss' => 'NO SE ENCONTRO ARTICULOS'); }
//
// echo 'COD: '.$resul[0]['codigo'];
// 
// 
//IIIIIIIIIIIIIIIIIIIIIIIIII   CANSULTA DE ARTICULO
//$catalogo_articulo = 'COD3 ARTICULO 3';
//$catalogo_articulo = explode(' ', $catalogo_articulo);
//$cod_articulo = trim($catalogo_articulo[0]);
//
//$mss = 'COD: '.$cod_articulo;
//$html = '';
//
//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
////$mysqli = '';
//$resul = $obj_bdmysql->select("art", "*", "codigo = '".$cod_articulo."'", "", "",$mysqli);
//if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$cod_articulo.', '.$resul; 
//}else{
//    $mss = '1';
//    $html = '<tr>
//                <td data-title="Code" id="catalogo_articulo_list_cod">'.$resul[0]['codigo'].'</td>
//                <td data-title="Article">'.$resul[0]['descripcion'].'</td>
//                <td class="numeric" data-title="Price"><input id="catalogo_articulo_list_price" class="form-control" type="text" placeholder="Price" value="'.$resul[0]['precio'].'"></td>
//                <td class="numeric" data-title="Stock"><input id="catalogo_articulo_list_stock" class="form-control" type="text" placeholder="Stock" value="'.$resul[0]['stock'].'"></td> 
//                <td class="numeric" data-title="Sale"><input id="catalogo_articulo_list_sale" class="form-control" type="text" placeholder="Sale" value="'.$resul[0]['oferta'].'"></td> 
//                <td data-title="Date Sale"><input id="catalogo_articulo_list_date_sale" class="form-control" type="text" placeholder="Date Sale" value="'.$resul[0]['fe_oferta'].'"></td>
//            </tr>';
//}
//echo $mss.' <br>'.$html;


//IIIIIIIIIIIIIIIIIIIIIIIIII   IMPRIME NUMERO DE FILAS
//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
//echo 'N: '.$obj_bdmysql->num_row("catalogo", "", $mysqli);

//IIIIIIIIIIIIIIIIIIIIIIIIII   IMPRIME CODE
//$id = '2355';
//$code = $obj_function->code_url($id,'code');
//echo 'valor: '.$id;
//echo '<br>CODE:'.$code;
//echo '<br>DECODE:'.$obj_function->code_url($code,'decode');
//$corte = 7;
//$control = substr(uniqid(),0,10);
//$control1 = substr($control,0,$corte);
//$control2 = substr($control,$corte,10);
////if($opc == 'code'){
//    $id = utf8_encode($id);
//    $string = $control1.$id.$control2;
//    $string = base64_encode($string);
//    echo 'CODE:<br>$control '.$control.'<br>$control1 '.$control1.'<br>$control2 '.$control2.'<br>$string '.$control1.$id.$control2.'<br>$string_code '.$string;
////}elseif($opc == 'decode'){
//    $string = base64_decode($string);
//    echo '<br><br>DECODE<br>$string '.$string;
//    $control1 = substr($string,$corte);
//    echo '<br>$control1 '.$control1;
//    $control2 = str_replace(substr($control1,-3), '', $control1);
//    echo '<br>$control2 '.$control2;
//    echo '<br>$control1 '.substr($string,$corte);
//    echo '<br>$control2 '. str_replace(substr($string,-3),'',);
//    $control2d = substr($string,-6);
//    echo '<br>$control2 '.substr($string,-6);


    
//IIIIIIIIIIIIIIIIIIIIIIIIII   GENERADOR DE CODIGO QR
//set it to writable location, a place for temp generated PNG files
echo 'GENERAL QR<BR>';

$obj_function->codeQR("http://www.gibble.com.ve/textronic/web/index.php",'50');

//$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
////html PNG location prefix
//$PNG_WEB_DIR = 'temp/';
//
//include "../assets/phpqrcode/qrlib.php";    
//
////ofcourse we need rights to create temp dir
//if (!file_exists($PNG_TEMP_DIR))
//    mkdir($PNG_TEMP_DIR);
//
//$filename = $PNG_TEMP_DIR.'test.png';
//$valor = 'http://www.gibble.com.ve/textronic/web/index.php';
//$matrixPointSize = 10;
//$errorCorrectionLevel = 'L';
//$id = '23';
////$filename = $PNG_TEMP_DIR.'test'.md5($valor.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
//$filename = $PNG_TEMP_DIR.'test'.$id.'.png';
//QRcode::png($valor, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
//
//echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; 