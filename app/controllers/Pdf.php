<?php
require_once '../../assets/tcpdf/tcpdf.php';
class Pdf  {

    var $tcpdf;
    var $productos;
    public function __construct() {
        //parent::__construct();
        //$this->load->library('/tcpdf/tcpdf');
        //$this->load->library('session');
        //$this->load->helper('url');
        $this->tcpdf = new TCPDF();
    }

    public function index($imagen = false) {
//        echo "hola";die();
        // create new PDF document
        //        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $this->tcpdf->SetCreator(PDF_CREATOR);
        $this->tcpdf->SetAuthor('Grey Uzcategui');
        $this->tcpdf->SetTitle('Catalogo de Productos');
        $this->tcpdf->SetSubject('Catalogo de Productos');
        $this->tcpdf->SetKeywords('Catalogo, PDF, Productos, Textronic');

/**
 * Header logo image width in user units.
 */
        

        //// set header and footer fonts
        //        $this->tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //
        //// set default monospaced font
        //        $this->tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //
        // set margins
        $this->tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->tcpdf->SetHeaderMargin(0);
        $this->tcpdf->SetFooterMargin(15);
        //
        //// remove default footer
        //        $this->tcpdf->setPrintFooter(false);
        //
        //// set auto page breaks
        //        $this->tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //
        //// set image scale factor
        //        $this->tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //
        //// set some language-dependent strings (optional)
        //        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        //            require_once(dirname(__FILE__) . '/lang/eng.php');
        //            $this->tcpdf->setLanguageArray($l);
        //        }
        //
        //// ---------------------------------------------------------
        // set font
        $this->tcpdf->SetFont('helvetica', '', 10);
        //CONSULTANDO DATA TABLAS A MOSTRAR
        //var_dump($this->session->userdata('productos_usuario'));
        $data = $this->productos;
        foreach ($data as $contenido_pagina) {
            //var_dump($contenido_pagina);
            $this->agregar_pagina($contenido_pagina);
        }
        // ---------------------------------------------------------
        //Close and output PDF document
        if ($imagen == true) {
            $this->tcpdf->Output(dirname(__FILE__).'/downloads/catalogo_productos.pdf', 'F');
    /*        echo '<script type="text/javascript">
                setTimeout ("redireccionar()", 500000);
                window.location="' . "" . '../view/flyer.php";

            </script>
';*/
        } else {
            $this->tcpdf->Output($_SERVER['DOCUMENT_ROOT'] . 'catalogo_productos.pdf', 'FD');
        }

        return true;
        //        $this->tcpdf->Output('catalogo_productos.pdf', 'I');
        //============================================================+
        // END OF FILE
        //============================================================+
    }

    public function agregar_pagina($contenido_tabla) {
        // remove default header
        $this->tcpdf->setPrintHeader(true);
        // add a page
        $this->tcpdf->AddPage();
        // -- set new background ---
        // get the current page break margin
        $bMargin = $this->tcpdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->tcpdf->getAutoPageBreak();
        // disable auto-page-break
        $this->tcpdf->SetAutoPageBreak(false, 0);
        // set bacground image
        //        $img_file = K_PATH_IMAGES . 'image_demo.jpg';
        $img_file = "../../" . 'assets/img/catalogo/bg/cat2.jpg';

        $this->tcpdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->tcpdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->tcpdf->setPageMark();
        // Print a text
        $html = $contenido_tabla;
        //var_dump($html);
        $this->tcpdf->writeHTML($html, true, false, true, false, '');
    }

//    	//Page header
//	public function Header() {
//		// Logo
//		$image_file = K_PATH_IMAGES.'logo_example.jpg';
//		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//		// Set font
//		$this->SetFont('helvetica', 'B', 20);
//		// Title
//		$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//	}
//
//	// Page footer
//	public function Footer() {
//		// Position at 15 mm from bottom
//		$this->SetY(-15);
//		// Set font
//		$this->SetFont('helvetica', 'I', 8);
//		// Page number
//		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//	}
}
