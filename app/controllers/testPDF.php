<?php
error_reporting(E_ALL ^ E_DEPRECATED);
require_once 'Tabulador.php';
require_once 'Pdf.php';
//	require_once 'flyer_functions.php';
	require_once '../../common/general.php';
	
	$id_flyer = $_GET['id'];
	$download = $_GET['down'];
	
	$obj_function = new coFunction();
	$obj_bdmysql = new coBdmysql();	
	$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
	
	if (!$mysqli->connect_error){
		$where = "idflyer= '" . $id_flyer . "'";
		$SQL = "SELECT pf.idproductFlyer, pf.name as product_name, pf.no_part as part, pf.alias as alias, pf.smp, pf.tomco, 
					pf.price_name_one as price_name_1, pf.price_one as price_1, pf.price_name_two as price_name_2,
					 pf.application, pf.oem, pf.skuno as nombre_imagen,
					pf.price_two as price_2, pf.price_name_three as price_name_3, pf.price_three as price_3, pf.image ,
					pf.applicationLabel, pf.titulo_product_name
				FROM flyer f 
					JOIN productFlyer pf ON f.idflyer = pf.flayer_idflyer
				WHERE  " . $where;		
		$resul = $mysqli->query($SQL)  or trigger_error($mysqli->error."[$SQL]");
		//$r = $resul->fetch_array(MYSQLI_ASSOC);
		$productos_array =  mysqli_fetch_all ($resul, MYSQLI_ASSOC);;
		//var_dump($resul);
		//var_dump($r);
			
	}else{ $aResult['error'] = "NO SE PUDO CONECTAR A LA BASE DE DATOS!"; }
/*
$productos_array = array(array(
                    'titulo_product_name' => "titulo",
                    'product_name' => "producto1",
                    'part' => "part",
                    'alias' => "alias",
                    //'xref' => $this->input->post('xref'),
                    'smp' => "smp",
                    'tomco' => "tomco",
                    'oem' => "oem",
                    'price_name_1' => "pricename1",
                    'price_name_2' => "pricename2",
                    'price_name_3' => "pricename3",
                    'price_1' => "1",
                    'price_2' => "2",
                    'price_3' => "3",
                    'application' => "application text",
                    'application_label' => "application tittle",
                    'nombre_imagen' => "def2"
            )
);
*/


//var_dump( $tab->index($productos_array));

//$pdf = new Pdf();
//$pdf->productos = $tab->index($productos_array);
//$pdf->index(true);
crear_pdf($productos_array, ($download === 'true'));



 function crear_pdf($productos_array, $download = false) {
        //Creo el pdf
 		$tab = new Tabulador();
        $pdf = new Pdf();
		$pdf->productos = $tab->index($productos_array);
		$pdf->index($download);

        //Creando Imagenes
        if ($download) {

        $pdf_file = dirname(__FILE__) . '/downloads/catalogo_productos.pdf';
        $save_to = dirname(__FILE__) . '/downloads/img/catalogo_productos.jpg';
        
        //exec("convert -density 600 $pdf_file -colorspace RGB -resize 800 $save_to ");
        exec("convert -quality 100 -density 300 $pdf_file $save_to ");
        //Comprimiendo Imagenes
        comprimir_imagenes();
        //limpiar_dir_imagenes();
    	}
    }



    function down_grey($archivo = "catalogo_productos.zip") {
// File: download.php
        if (!isset($archivo) || empty($archivo)) {
            exit();
        }
        $root = dirname(__FILE__) .'/downloads/';
        $file = basename($archivo);
        $path = $root . $file;
        $type = '';
        if (is_file($path)) {
            $size = filesize($path);
            if (function_exists('mime_content_type')) {
                $type = mime_content_type($path);
            } else if (function_exists('finfo_file')) {
                $info = finfo_open(FILEINFO_MIME);
                $type = finfo_file($info, $path);
                finfo_close($info);
            }
            if ($type == '') {
                $type = 'application/force-download';
            }

            // Set Headers
            header('Content-Type: $type');
            header('Content-Disposition: attachment; filename = ' . $file);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . $size);
            // Download File
            readfile($path);
        } else {
            die('File not exist!!');
        }
        $zipname =  dirname(__FILE__)  . '/downloads/catalogo_productos.zip';
        ///////Then download the zipped file.
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
    
    }


      function limpiar_dir_imagenes() {
        //Limpiando Carpeta files/image
        $ruta_directorio_cliente = "assets/image";
        //Elimino la gestion documental de ese cliente  
        if (file_exists($ruta_directorio_cliente)) {
            eliminarDir($ruta_directorio_cliente);
        }

        //$this->crearDir($ruta_directorio_cliente);
    }

     function comprimir_imagenes() {

        
        //Listando archivos
        $directorio = opendir( dirname(__FILE__) . "/downloads/img/"); //ruta actual

        while ($archivo = readdir($directorio)) { //obtenemos un archivo y luego otro sucesivamente
            if (is_dir($archivo)) {//verificamos si es o no un directorio
            } else {
                $listado_archivos[] = "downloads/img/"."$archivo";
            }
        }

        //$directorio = $_SERVER['DOCUMENT_ROOT'] . "ecp/assets/image/";
        //$directorio='C:\xampp\htdocs\ecp\assets\image\\\\\\\\\\\\\\');


        // Comprimiendo Archivos //http://php.net/manual/es/class.ziparchive.php
        $files = $listado_archivos;
        var_dump($files);
        $path = 'downloads/catalogo_productos.jpg';
        $zipname = 'downloads/catalogo_productos.zip';
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file);
        }
        $zip->close();

        //comprimir($directorio, $zipname);

        //Descargar Archivo comprimido
        down_grey();
    }
