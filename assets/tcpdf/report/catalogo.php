<?php
//============================================================+
// File name   : catalogo.php
// Begin       : 01-05-2015
// Last Update : 31-05-2015
//
// Description : CATALOGO PDF
//
//
// Author: YORDIN DA ROCHA
//
// (c) Copyright:
//               YORDIN DA ROCHA
//               www.gibble.com.ve
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - CATALOGO: VERSION PDF DE CATALOGO 
 * @author YORDIN DA ROCHA
 * @since 01-05-2015
 */
// --------------------------------------------------------
//DATOS SQL
global $desc_catalogo,$fondo,$top_art_pag,$limit_art,$ind_pag;
include '../../../common/general.php';
$obj_bdmysql = new coBdmysql();
$obj_function = new coFunction();
$id_catalogo = $obj_function->code_url($_REQUEST['id'],'decode');
//echo base64_decode($_REQUEST['id']);
//echo "<br>".substr(base64_decode($_REQUEST['id']),7);
//echo "<br>".substr(substr(base64_decode($_REQUEST['id']),7),-3);
//echo "<br>".str_replace(substr(substr(base64_decode($_REQUEST['id']),7),-3),"",substr(base64_decode($_REQUEST['id']),7));
//exit;
//TITULO
//$desc_catalogo = 'CATALOGO MES DE MAYO.';
$titulo_fuente = 'helvetica';
$titulo_estilo = '';
$titulo_tamano = 36;
$titulo_color = '0,0,0';
$titulo_hor = 'C';
$titulo_ver = '120';
//PAGINACION
$ind_pag = (isset($_REQUEST['ind'])) ? trim($_REQUEST['ind']):0;
$top_art_pag = $ind_pag * CANT_ART_PDF;
//BD
$column = "*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy,(SELECT order_art FROM catalogo_order WHERE id = order_id) order_art";
$where = "id_catalogo = '".$id_catalogo."'";
$limit = "";
$order = "";
//$limit_art = "0,10";
//$limit_art = $top_art_pag.",".CANT_ART_PDF;
$limit_art = "";
$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
if (!$mysqli->connect_error) {
    if($obj_bdmysql->num_row("catalogo", $where, $mysqli) > 0){
//        $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy,(SELECT order_art FROM catalogo_order WHERE id = order_id) order_art",$where,"","",$mysqli);
        $resul = $obj_bdmysql->select("catalogo",$column,$where,$order,$limit,$mysqli);
        if(!is_array($resul)){ $val = FALSE;
        }else{
            //TITULO
            $desc_catalogo = $resul[0]['titulo'];
            // Get Filas Columnas
            $filasXcolumnas = $resul[0]['presentacion'];
            //CODIGO QR
            $codigo_qr = '../../../common/codeqr/'.$id_catalogo.'.png';
            //PORTADA
            if(trim($resul[0]['portada']) != ''){ $portada = '../../bootstrap-fileinput-master/portadas/'.$resul[0]['portada']; 
            }else{ $portada = "../../bootstrap-fileinput-master/portadas/def.jpg"; }
            //FONDO
            if(trim($resul[0]['fondo']) != ''){ $fondo = '../../bootstrap-fileinput-master/fondo/'.$resul[0]['fondo']; 
            }else{ $fondo = "../../bootstrap-fileinput-master/fondo/def.jpg"; }
            //ORDENAMIENTO DE ARTICULOS
            $order_art = $resul[0]['order_art'];
            //ESTILO DE TITULO
            if(trim($resul[0]['titulo_fuente']) != ''){ $titulo_fuente = $resul[0]['titulo_fuente']; }
            if(trim($resul[0]['titulo_tamano']) != ''){ $titulo_tamano = $resul[0]['titulo_tamano']; }
            if(trim($resul[0]['titulo_estilo']) != ''){ $titulo_estilo = $resul[0]['titulo_estilo']; }
            if(trim($resul[0]['titulo_color']) != ''){ $titulo_color = $resul[0]['titulo_color']; }
            if(trim($resul[0]['titulo_ali_hor']) != ''){ $titulo_hor = $resul[0]['titulo_ali_hor']; }
            if(trim($resul[0]['titulo_ali_ver']) == 'T'){ $titulo_ver = '10'; }elseif(trim($resul[0]['titulo_ali_ver']) == 'B'){ $titulo_ver = '240'; }
            //LISTADO DE ARTICULOS
            $resul_art = $obj_bdmysql->select("catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'",$order_art,$limit_art,$mysqli);
            if(!is_array($resul_art)){ $val = FALSE;
            }else{ $val = TRUE; }
        }
    }else{
        $val = FALSE;
    }
}else{
    $val = FALSE;
}
$limit_art = $top_art_pag.",".CANT_ART_PDF;
$val = TRUE;
if(!$val){
    echo 'NO SE IDENTIFICO EL CATALOGO '.$id_catalogo;
}else{
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// --------------------------------------------------------
//DATOS SQL
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        global $fecha_reg,$fondo,$desc_catalogo,$ind_pag;
        $ind_pag = $ind_pag + 1;
        $this->Image($fondo, 0, 0, 210, 300, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);

        $image_file2 = "../../../assets/img/catalogo/header1.jpg";
        $this->Image($image_file2, 0, 0, 210, 14, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);

        $image_file3 = '../../../assets/img/logo.png';
        $this->Image($image_file3, 13, 0, 56, 14, '', '', '', false, 300);

        $this->SetFont('helvetica', 'B', 9);

        $this->writeHTMLCell(0,0,0,5,$desc_catalogo,0,0,false,true,'R',true);
    }

    // Page footer
    public function Footer() {
        global $top_art_pag,$ind_pag;
        $ind_pag = $ind_pag + 1;
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
//            $this->SetTextColor(255,255,255);
        $this->SetTextColor(0,0,0);
        // Page number
    //        if(trim($this->getAliasNumPage()) != '1'){
        $image_file = "../../../assets/img/catalogo/footer1.jpg";
        $this->Image($image_file, 0, 285, 210, 13, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);
        $n_pagina = $top_art_pag + floatval($this->getAliasNumPage());
        $this->writeHTMLCell('0','14','30','286',$top_art_pag.' + '.floatval($this->getAliasNumPage()).', '.$n_pagina.' '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0,0,false,true,'C',true);
        $this->writeHTMLCell('0','14','10','291','Textronic Inc 4079 NW 79th Ave Doral FL 33166 * Phone: (305) 597-5740 * Toll Free: * Fax: (305) 597-5741. P'.$ind_pag,0,0,false,true,'C',true);
    //        }
    //        $this->Cell(0, 10, 'Pag '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 1, '', 1, false, 'T', 'M');
    //        $this->Cell(0, 10, 'Pag '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('YORDIN DA ROCHA');
$pdf->SetTitle('TEXTRONIC');
$pdf->SetSubject('CATALOGO');
$pdf->SetKeywords('TEXTRONIC');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, -30);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

    //ESTILO DE TITULO
    //COLOR
    $titulo_rgb_rep = str_replace(' ','',str_replace('rgb(','',str_replace(')','',$titulo_color)));
    $titulo_rgb = explode(',',$titulo_rgb_rep);
    $titulo_r = $titulo_rgb[0];
    $titulo_g = $titulo_rgb[1];
    $titulo_b = $titulo_rgb[2];
    $pdf->SetTextColor($titulo_r,$titulo_g,$titulo_b);
    //FUENTE, TAMANO Y ESTILO
    $pdf->SetFont($titulo_fuente, $titulo_estilo, $titulo_tamano);
    if($ind_pag == 0){
    //IIIIIIIIIIIIIIIIIIIIIIIII  PORTADA
        $pdf->AddPage();
        //IMAGEN DE PORTADA
        $pdf->Image($portada, 0, 0, 210, 300, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);
        $pdf->Image('../../../assets/img/logo.png', 10, 240, 120, 28, '', '', '', false, 300);
        $pdf->writeHTMLCell(0,14,10,$titulo_ver,$desc_catalogo,0,0,false,true,$titulo_hor,true);
        $pdf->Image($codigo_qr, 160, 200, 40, 40, '', '', '', false, 300);
    }
    
    //IIIIIIIIIIIIIIIIIIIIIIIII  ARTICULOS
    $pdf->AddPage();
    // set font
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('helvetica', '', 10);
    $image_panel = "../../img/catalogo/item5.png";
    $image_panel_qr = "../../img/catalogo/panel_precio.png";
    $image_label= "../../img/catalogo/label.png";
    $image_label_sale= "../../img/catalogo/label_sale.png";
    $image_art= "../../img/art/art1.jpg";
    $dir_flag = '../../img/catalogo/flag_n/';
    $image_sale = '../../img/catalogo/sale-label.png';
    //$pdf->Image($image_panel, 50, 50, 40, 40, '', 'http://www.tcpdf.org', '', false, 300);

    //SEPARACION
    $colS = explode('x', $filasXcolumnas)[1];
    $filS = explode('x', $filasXcolumnas)[0];
    $marginx = 3;
    $marginy = 14;
    //ANCHO Y ALTO DE ITEM
    $wpanel = 50; 
    $hpanel = 50;

    //$colS = 4;
   // $filS = 5;
    // ancho descfripcion
    $widthDesc = 41;
    // ancho flag
    $widthFlag = 13;
    // suma articulo panel
    $plusArt = 13;
    // XY QR
    $xyQR = 10;
    // plus Y QR
    $plusYQR = 40;
    // plus X Desc
    $plusXDesc = 3;

    if ($filS == 3){
        $multiplicadorY = 11;
        $marginy = 30;
    } else if ($filS == 4){
        $multiplicadorY = 4;
        $marginy = 20;
    } else {
        $multiplicadorY = 1;
    }

    if ($colS == 5){
        $multiplicadorX = 1;
        $wpanel = 40;
        $widthDesc = 31;
        $widthFlag = 8;
        $plusArt = 9;
        $xyQR = 9;
        $plusYQR = 44;
        $plusXDesc = 5;
    } else if($colS == 3){
        $multiplicadorX = 18;
        $marginx = 12;
    } else {
        $multiplicadorX = 1;
    }
    $paddinx = 1 * $multiplicadorX;
    $paddiny = 4 * $multiplicadorY;
    //FILAS Y COLUMNAS
    $col = $colS;
    $fil = $filS;
    //CONTADOR FILA COLUMNA
    $nf = 0;
    $nc = 0;
    
//    $resul_art = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22);
    foreach ($resul_art as $r_art){
        $SkuNo = trim($r_art['cod_art']);
        $precio = trim($r_art['precio']);
        $OnHand = trim($r_art['stock_ini']);
        $oferta = trim($r_art['oferta']);
        $fecha_to_oferta = trim($r_art['fe_oferta']);
        $fecha_from_oferta = trim($r_art['fe_oferta_fin']);
        $mysqli2 = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli2->connect_error) {
            $where ="SkuNo = '".$SkuNo."'";
            $campos = "*,'00/00/0000' as fe_oferta_dmy,(SELECT CatDesc FROM `codes cat` WHERE `codes cat`.CatCode = g_inventory.CatCode) as CatDesc, (SELECT PrdDesc FROM `codes catsub` WHERE `codes catsub`.PrdCode = g_inventory.PrdCode) as PrdDesc";
            $resul = $obj_bdmysql->select("g_inventory", $campos, $where, "ProdDesc", "",$mysqli2);
            if(!is_array($resul)){ $mss = 'NO SE ENCONTRO ARTICULO PARA EL CODIGO '.$r_art['cod_art']; 
            }else{
                foreach ($resul as $r_art2){
                    $PartNo = $r_art2['PartNo'];
                    $ProdDesc = $r_art2['ProdDesc'];
                    $CatDesc = $r_art2['CatDesc'];
                    $PrdDesc = $r_art2['PrdDesc'];
                    //DEFINE IMAGEN
                    $image_art= "../../img/art/".$SkuNo.".jpg";
                    $image_art_qr= "../../img/art_qr/".$SkuNo.".jpg";
                    if(!file_exists($image_art)){ $image_art= "../../img/art/def.jpg"; }
                    if(!file_exists($image_art_qr)){ $image_art_qr= $codigo_qr; }
                    //DEFINE FLAG
                    $flag = '';
                    $arr_flag = '';
                    //if($r_art2['Flag01'] == '1'){ $flag.= '01.png,'; }
                    //if($r_art2['Flag02'] == '1'){ $flag.= '02.png,'; }
                    if($r_art2['Flag03'] == '1'){ $flag.= '03.png,'; }
                    //if($r_art2['Flag04'] == '1'){ $flag.= '04.png,'; }
                    //if($r_art2['Flag05'] == '1'){ $flag.= '05.png,'; }
                    if($r_art2['Flag06'] == '1'){ $flag.= '06.png,'; }
                    //if($r_art2['Flag07'] == '1'){ $flag.= '07.png,'; }
                    if($r_art2['Flag08'] == '1'){ $flag.= '08.png,'; }
                    //if($r_art2['Flag09'] == '1'){ $flag.= '09.png,'; }
                    if($r_art2['Flag10'] == '1'){ $flag.= '10.png,'; }
                    if($flag != ''){ $arr_flag = explode(',', str_replace(',_', '',$flag.'_')); }

                    //DEFINE OFERTAS
                    $resul_oferta = $obj_bdmysql->select("`ofertas detail` as a LEFT JOIN ofertas as b ON a.ID = b.OfertaId", "*,b.nombre,b.Date_To,DATE_FORMAT(b.Date_To,'%d/%m/%Y') AS Date_To_dma,b.Date_From,DATE_FORMAT(b.Date_From,'%d/%m/%Y') AS Date_From_dma", "SkuNo = '".$SkuNo."'", "Date_To DESC", "1",$mysqli2);
                    if(!is_array($resul_oferta)){ $oferta = '0'; $fecha_to_oferta = '00/00/0000'; $fecha_from_oferta = '00/00/0000'; 
                    }else{    
                        //DIAS DE DIFERENCIA FECHA FIN OFERTA Y FECHA ACTUAL
//                        $datetime1 = new DateTime($resul_oferta[0]['Date_From_dma'], new DateTimeZone('America/Caracas'));
//                        $datetime2 = new DateTime(date('d/m/Y'), new DateTimeZone('America/Caracas'));
//                        $interval = $datetime1->diff($datetime2);
//                        $dif_fecha = $interval->format('%R%a');
//                        if($dif_fecha > 0){
                        $datetime1 = date_create('2009-10-11');
                        $datetime2 = date_create('2009-10-13');
                        $interval = date_diff($datetime1, $datetime2);
                        $dif_fecha = $interval->format('%R%a días');
                            $oferta = $resul_oferta[0]['Precio']; 
                            $r_art['precio'] = $oferta; 
                            $fecha_to_oferta = $resul_oferta[0]['Date_To_dma']; 
                            $fecha_from_oferta = $resul_oferta[0]['Date_From_dma'];
                            $image_label = $image_label_sale;
//                        }
                    }             
                }
            }
        }else{
            header('../../../common/error_conexion.php');
        }
        if($nc > $col-1){
            $nf = $nf + 1;
            $nc = 0;
        }

        if($nf > $fil-1){
            $pdf->AddPage();
            //CONTADOR FILA COLUMNA
            $nf = 0;
            $nc = 0;
        }

        $xf = $marginx+(($wpanel+$paddinx)*$nc); $yf = $marginy+($hpanel+$paddiny)*$nf;
    //    $xpanel = 14;$ypanel = 50;    
        $xpanel = $xf;$ypanel = $yf;
        $xart = $xpanel+$plusArt; $yart = $ypanel+9;
        $xcod = $xpanel; $ycod = $ypanel+3;
        $xdes = $xpanel+$plusXDesc; $ydes = $ypanel+33;
        $xlabel = $xpanel+35; $ylabel = $ypanel+38;
        $xtexprice = $xlabel+2; $ytexprice = $ylabel+6;
        $xsale = $xpanel-2; $ysale = $ypanel-1;
        $xartqr = $xpanel; $yartqr = $ypanel+$plusYQR;
        $xartqr_panel = $xpanel+9; $yartqr_panel = $ypanel+40;
        //IIIIIIIIIIIIIII IMAGEN PANEL
        $pdf->Image($image_panel, $xpanel, $ypanel, $wpanel, $hpanel, '', '', '', false, 300);
        //IIIIIIIIIIIIIII IMAGEN ARTICULO
        $pdf->Image($image_art, $xart, $yart, 23, 23, '', '', '', false, 300);
        //IIIIIIIIIIIIIII PRECIO
        /*if($r_art['precio_pdf'] == 1){
            if($r_art['precio'] > 0){
            //IIIIIIIIIIIIIII IMAGEN
            //$pdf->Image($image_label, $xlabel, $ylabel, 17, 17, '', '', '', false, 300);
            //IIIIIIIIIIIIIII CANTIDAD
            //$pdf->Text($xtexprice,$ytexprice, '$'.number_format($r_art['precio'],2,".",","));
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->SetTextColor(183,40,35);
//            $pdf->SetTextColor(255,255,255);
            //$pdf->Text($xtexprice,$ytexprice, '$'.number_format($r_art['precio'],2,".",","));
            $pdf->writeHTMLCell('45','14',$xcod,$ytexprice,'$'.number_format($r_art['precio'],2,".",","),0,0,false,true,'R',true);
            }
        }*/
        $pdf->SetTextColor(0,0,0);
        //IIIIIIIIIIIIIII CODIGO DE PRODUCTO
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->writeHTMLCell('50','14',$xcod,$ycod,$PartNo,0,0,false,true,'C',true);
        $pdf->SetFont('helvetica', '', 8);
        //IIIIIIIIIIIIIII DESCRIPCION PRODUCTO
        $pdf->writeHTMLCell($widthDesc,'14',$xdes,$ydes,$ProdDesc,0,0,false,true,'C',true);
        //IIIIIIIIIIIIIII CODIGO QR DE ARTICULO
//        $pdf->Image($image_panel_qr, $xartqr_panel, $yartqr_panel, 30, 15, '', '', '', false, 300);
        $pdf->Image($image_art_qr, $xartqr, $yartqr, $xyQR, $xyQR, '', '', '', false, 300);
        //IIIIIIIIIIIIIII OFERTAS
        if($oferta != 0){ $pdf->Image($image_sale, $xsale, $ysale, 16, 16, '', '', '', false, 300); }
//        $pdf->Image($image_sale, $xsale, $ysale, 16, 16, '', '', '', false, 300);
        //IIIIIIIIIIIIIII FLAG
        $xflag = $xpanel-0.7; $yflag = $ypanel+14;
     /*   if(is_array($arr_flag)){
            foreach ($arr_flag as $r_flag){
                $pdf->Image($dir_flag.$r_flag, $xflag, $yflag, $widthFlag, 7, '', '', '', false, 300);
//                $xflag = $xflag+8; 
                $yflag = $yflag+5; 
            }
        } */
        
//        $pdf->writeHTMLCell('50','14',$xcod,$ycod,'SKU: 107227',0,0,false,true,'C',true);
//        $pdf->writeHTMLCell('41','14',$xdes,$ydes,'Alt-nd Irif Celica, Camry 70A 2.2L',0,0,false,true,'C',true);
//        $pdf->Text($xcod,$ycod, 'SKU: 107227');
//        $pdf->writeHTMLCell('41','14',$xdes,$ydes,'Alt-nd Irif Celica, Camry 70A 2.2L',0,0,false,true,'C',true);
        $nc = $nc + 1;
    }
// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('catalogo.pdf', 'I');
//$pdf->Output('catalogo.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
}