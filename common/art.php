<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'general.php';
$obj_function = new coFunction();
$obj_bdmysql = new coBdmysql();

$mysqli = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
//        $where = "1=1 AND Discontinued = 0 ";
//        $where = "(SkuNo like '%".$art_val."%') or (ProdDesc like '%".$art_val."%')";
$where = "";
//        $catalogo_categoria = '';$catalogo_subcategoria = ''; $catalogo_stock = '';
//        if($catalogo_categoria != ''){ $where.=" AND CatCode = '".$catalogo_categoria."'";}
//        if($catalogo_subcategoria != ''){ $where.=" AND PrdCode = '".$catalogo_subcategoria."'"; }
//        if($catalogo_stock != ''){ $where.=" AND OnHand = '".$catalogo_stock."'"; }
//$resul = $obj_bdmysql->select("g_inventory","*,".$art_val." as xx",$where,"","0,10",$mysqli);
$resul = $obj_bdmysql->select("g_inventory","SkuNo","","0,10",$mysqli);
if(!is_array($resul)){ $resul = array('mss' => 'NO SE ENCONTRO ARTICULOS'); }
//$i = 0;
//foreach ($resul as $r){ $rr[$i] = $r['SkuNo']; $i = $i + 1;}
echo json_encode($rr);