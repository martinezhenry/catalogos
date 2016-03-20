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
global $desc_catalogo;
$id_catalogo = '3';
$desc_catalogo = 'CATALOGO MES DE MAYO.';

//include '../../../common/general.php';
//$obj_bdmysql = new coBdmysql();
//$obj_function = new coFunction();
//$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
//if (!$mysqli->connect_error) {
//    
//    $id_catalogo = $obj_function->code_url($_REQUEST['id'],'decode');
//    if($obj_bdmysql->num_row("catalogo", "id_catalogo = '".$id_catalogo."'", $mysqli) > 0){
//        $resul = $obj_bdmysql->select("catalogo","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
//        if(!is_array($resul)){ $val = FALSE;
//        }else{ 
//            //TITULO
//            $desc_catalogo = $resul[0]['titulo'];
//            //CODIGO QR
            $codigo_qr = '../../../common/codeqr/'.$id_catalogo.'.png';
//            //PORTADA
//            $portada = '../../../assets/bootstrap-fileinput-master/portadas/'.$resul[0]['portada'];
//            //LISTADO DE ARTICULOS
//            $resul_art = $obj_bdmysql->select("vw_catalogo_reng","*,DATE_FORMAT(fe_us_in,'%d/%m/%Y') as fe_us_in_dmy","id_catalogo = '".$id_catalogo."'","","",$mysqli);
//            if(!is_array($resul_art)){ $val = FALSE;
//            }else{ $val = TRUE; }
//        }
//    }else{
//        $val = FALSE;
//    }
//}else{
//    $val = FALSE;
//}

$val = TRUE;
if(!$val){
    echo 'NO SE IDENTIFICO EL CATALOGO '.$id_catalogo;
}else{
    // Include the main TCPDF library (search for installation path).
    require_once('tcpdf_include.php');
    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

        //Page header
        public function Header() {
            global $desc_catalogo;
            // Logo
    //        $image_file = K_PATH_IMAGES.'logo_example.jpg';
    //        $this->Image($image_file, 10, 5, 70, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            $image_file1 = "../../../assets/img/catalogo/bg/bg2.jpg";
            $this->Image($image_file1, 0, 0, 210, 300, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);

            $image_file2 = "../../../assets/img/catalogo/header1.jpg";
            $this->Image($image_file2, 0, 0, 210, 14, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);

            $image_file3 = '../../../assets/img/logo.png';
            $this->Image($image_file3, 13, 0, 56, 14, '', '', '', false, 300);

    //        $this->Image($image_file, 0, 0, 30, 80, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 9);

            $this->writeHTMLCell(0,0,0,5,$desc_catalogo,0,0,false,true,'R',true);
    //        $this->Cell(0, 10, 'DEYANBISLICK.', 0, false, 'R', 0, '', 0, false, 'M', 'M');
    //        $this->Cell(0, 10, 'Fecha Registro: .'.utf8_encode($r_persona['fe_us_in'], 0, false, 'R', 0, '', 0, false, 'M', 'M');
    //        $this->Text(5, 10, 'DEYANBISLICK.', false, false, TRUE, 0, 0, 'R', false);
    //        $this->Text(5, 15, 'Registrado: '.$fecha_reg, false, false, TRUE, 0, 0, 'R', false);
        }

        // Page footer
        public function Footer() {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'B', 10);
//            $this->SetTextColor(255,255,255);
            $this->SetTextColor(0,0,0);
            // Page number
    //        if(trim($this->getAliasNumPage()) != '1'){
//            $image_file = "../../../assets/img/catalogo/footer1.jpg";
//            $this->Image($image_file, 0, 285, 210, 13, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);
            
            $this->writeHTMLCell('0','14','30','286',$this->getAliasNumPage().'/'.$this->getAliasNbPages(),0,0,false,true,'C',true);
            $this->writeHTMLCell('0','14','10','291','Textronic Inc 4079 NW 79th Ave Doral FL 33166 * Phone: (305) 597-5740 * Toll Free: * Fax: (305) 597-5741',0,0,false,true,'C',true);
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

    // set font
    $pdf->SetTextColor(255,255,255);
    $pdf->SetFont('helvetica', '', 36);
    //IIIIIIIIIIIIIIIIIIIIIIIII  PORTADA
    $pdf->AddPage();
//    if(!file_exists($portada)){ $portada = "../../../assets/img/catalogo/bg/cat1.jpg";}
    $portada = "../../../assets/img/catalogo/bg/cat1.jpg";
    $this->Image('../../../assets/img/logo.png', 13, 0, 56, 14, '', '', '', false, 300);
    $pdf->Image($portada, 0, 0, 210, 300, 'JPG', '', 'T', false, 300, '', false, false, 10, false, false, false);
    $pdf->writeHTMLCell('0','14',10,120,$desc_catalogo,0,0,false,true,'C',true);
    $pdf->Image($codigo_qr, 160, 200, 40, 40, '', '', '', false, 300);

    //ARTICULOS
    $pdf->AddPage();
    // set font
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('helvetica', '', 11);
    //$html=  '<div align="center">PLANILLA DE REGISTRO'.$ci_persona.'</div>';
    //$html.=  '
    $pdf->SetFont('helvetica', 'B', 10);
    $image_panel = "../../../assets/img/catalogo/item2.png";
    $image_label= "../../../assets/img/catalogo/label.png";
    $image_art= "../../../assets/img/art/art1.jpg";
    //$pdf->Image($image_panel, 50, 50, 40, 40, '', 'http://www.tcpdf.org', '', false, 300);

    //SEPARACION
    $marginx = 3;
    $marginy = 14;
    $paddinx = 1;
    $paddiny = 4;
    //FILAS Y COLUMNAS
    $col = 4;
    $fil = 5;
    //CONTADOR FILA COLUMNA
    $nf = 0;
    $nc = 0;
    //ANCHO Y ALTO DE ITEM
    $wpanel = 50; 
    $hpanel = 50;
    $resul_art = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22);
    foreach ($resul_art as $r_art){
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
        $xart = $xpanel+13; $yart = $ypanel+13;
        $xcod = $xpanel; $ycod = $ypanel+7;
        $xdes = $xpanel; $ydes = $ypanel+36;
        $xlabel = $xpanel+35; $ylabel = $ypanel+38;
        $xtexprice = $xlabel+3; $ytexprice = $ylabel+6;

        $pdf->Image($image_panel, $xpanel, $ypanel, $wpanel, $hpanel, '', '', '', false, 300);
        $pdf->Image($image_art, $xart, $yart, 23, 23, '', '', '', false, 300);
        $pdf->Image($image_label, $xlabel, $ylabel, 17, 17, '', '', '', false, 300);
        $pdf->Text($xtexprice,$ytexprice, '$ 50');
//        $pdf->writeHTMLCell('50','14',$xcod,$ycod,$r_art['cod_art'],0,0,false,true,'C',true);
//        $pdf->writeHTMLCell('41','14',$xdes,$ydes,$r_art['descripcion'],0,0,false,true,'C',true);
        $pdf->Text($xcod,$ycod, 'SKU: 107227');
        $pdf->writeHTMLCell('41','14',$xdes,$ydes,'Alt-nd Irif Celica, Camry 70A 2.2L',0,0,false,true,'C',true);
        $nc = $nc + 1;
    }
    // ---------------------------------------------------------
    //Close and output PDF document
    $pdf->Output('planilla_registro.pdf', 'I');

    //============================================================+
    // END OF FILE
    //============================================================+
}