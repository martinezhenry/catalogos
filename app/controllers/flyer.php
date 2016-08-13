<?php	
	error_reporting(E_ALL ^ E_DEPRECATED);
	include 'flyer_functions.php';
	include '../../common/general.php';
	
	$id_flyer = $_SERVER['QUERY_STRING'];
	
	$obj_function = new coFunction();
	$obj_bdmysql = new coBdmysql();	
	$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
	
	if (!$mysqli->connect_error){
		$where = "idflyer= '" . $id_flyer . "'";
		$SQL = "SELECT pf.idproductFlyer, pf.name, pf.no_part as parts, pf.alias as wells, pf.smp, pf.tomco, 
					pf.price_name_one, pf.price_one, pf.price_name_two, pf.application, pf.oem, pf.skuno,
					pf.price_two, pf.price_two, pf.price_name_three, pf.price_three, pf.image  
				FROM flyer f 
					JOIN productFlyer pf ON f.idflyer = pf.flayer_idflyer
				WHERE  " . $where;		
		$resul = $mysqli->query($SQL)  or trigger_error($mysqli->error."[$SQL]");
		//$r = $resul->fetch_array(MYSQLI_ASSOC);
		$r =  mysqli_fetch_all ($resul, MYSQLI_ASSOC);;
		//var_dump($resul);
		//var_dump($r);
		if(is_array($r)){						
			$pro = $r;
		}else{
			$aResult['error'] = "FLYER NO EXISTE";
		}			
	}else{ $aResult['error'] = "NO SE PUDO CONECTAR A LA BASE DE DATOS!"; }
	
	/*if (!empty($pro['image'])) {
		file_put_contents('', $pro['image']);
	} else {

	}*/
	/*$prd = array(
					"NAME"=> "Hola Mundo Como estas?", 
					"PARTS"=> "123-45690", 
					"WELLS"=> "789857,2548796", 
					"SMP"=> "5897757,6698962", 
					"TOMCO"=> "NDSP", 
					"OEM"=> "889657,6548822,2123365,1266542",
					"APLICACION"=>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
					"PRICE_NAME"=>array(100,101,102), 
					"image"=> "images/asistchar.png"
				);
	*/
	$cur = 0;
	$max = 5; #max number of products for each page
	$sen = True; #direction of the product inside of the flyer 
	$pos = array('X' => 5, 'Y' => 5); #array with the startup position
	
	$pdf = new PDF('P','mm','Letter');	
	$pdf->SetMargins(0,0,0,0);
	$pdf->SetAutoPageBreak(false, 0.0);
	$pdf->AddPage();	 	
	$pdf->SetFont('Arial','B',18);	
	
	$pdf->SetFillColor(192);
	$pdf->SetLineWidth(0.3);	
	
	$pdf->Line(0, 5, 218, 5);
	//var_dump($pro);
	foreach($pro as $prd){
		if($cur == $max){
			$pdf->AddPage();
			$cur = 0;
			$sen = True;
			$pos = array('X' => 5, 'Y' => 5);			
		}
		//var_dump($prd);
		
		$pos = add_product($pdf,$prd, $sen,$pos,5);
		$sen = !$sen;
		$cur++;
	}	
	
	$pdf->Output();
	
?>