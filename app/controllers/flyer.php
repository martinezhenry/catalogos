<?php	
	include 'flyer_functions.php';
	include '../common/general.php';
	
	$id_flyer = $_SERVER['QUERY_STRING'];
	
	$obj_function = new coFunction();
	$obj_bdmysql = new coBdmysql();	
	$mysqli = new mysqli(DBHOST3, DBUSER3, DBPASS3, DBNOM3);
	
	if (!$mysqli->connect_error){
		$where = "idflyer= '" . $id_flyer . "'";
		$SQL = "SELECT pf.idproductFlayer, pf.name, pf.no_part, pf.wells, pf.smp, pf.tomco, 
					pf.price_name_one, pf.price_one, pf.price_name_two, pf.aplicacion,
					pf.price_two, pf.price_two, pf.price_name_three, pf.price_three, pf.image  
				FROM flayer f 
					JOIN productFlayer pf ON f.idflayer = pf.flayer_idflayer
				WHERE  " . $where;		
		$resul = $mysqli->query($SQL);
		$r = $resul->fetch_array(MYSQLI_ASSOC);
		if(is_array($r)){						
			$pro = $r;
		}else{
			$aResult['error'] = "FLYER NO EXISTE";
		}			
	}else{ $aResult['error'] = "NO SE PUDO CONECTAR A LA BASE DE DATOS!"; }	
	
	
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
	
	foreach($pro as $prd){
		if($cur == $max){
			$pdf->AddPage();
			$cur = 0;
			$sen = True;
			$pos = array('X' => 5, 'Y' => 5);			
		}
		$pos = add_product($pdf,$prd, $sen,$pos,5);
		$sen = !$sen;
		$cur++;
	}	
	
	$pdf->Output();
	
?>