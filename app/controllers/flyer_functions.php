<?php
	include '../assets/fpdf/class_fpdf.php';

	function add_MultiCell($pdf, $pos, $ali, $val, $siz, $fon, $bor){ 		
		/**	$pdf=> Document PDF, 
		/**	$pos => Array Position X & Y, 
		/**	$ali => Alignment Center, Left, Right, Justified, 
		/**	$val => String with the cell title, 
		/**	$siz => Array of the size W & H, 
		/**	$fon => Array setting a Font for this element
		/**	$bor => Boolean (0,1) for the border on the element MultiCell
		*/		
		$pdf->SetFont($fon[0],$fon[1],$fon[2]);
		$pdf->SetXY($pos['X'],$pos['Y']);
		$pdf->MultiCell($siz[0],$siz[1],utf8_decode($val),$bor, $ali);
		$pos['Y'] += $siz[1];
		return $pos;
	}
	
	function add_product($pdf,$prd,$sen,$pos,$lin){
		/**
		/**	$pdf=> PDF Document
		/**	$pro=> Product to add to the flyer
		/**	$sen=> Image Position on this Product 0= Right 1= Left
		/**	$pos=> Startup Position of this element 
		*/	
		$pdf->Line($pos['X'], $pos['Y'], 210, $pos['Y']);	
		$pos = add_MultiCell($pdf,$pos,'C',$prd['name'],array(210,10),array('Arial','B',18),'0');		
		$pos['Y'] += 5;
		/* Prices */		
		$pos['X'] += 65;	
		
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_name_one'] + ':',array(25,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_name_two'] + ':',array(25,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_name_three'] + ':',array(25,$lin),array('Arial','',10),'0');
		
		$pdf->RoundedRect($pos['X'], $pos['Y'], 60, 20, 2, '1234', 'D');
		$pos = add_MultiCell($pdf,$pos,'L','Aplicación:',array(25,$lin),array('Arial','',10),'0');		
		
		$pos['X'] += 25;
		$pos['Y'] -= $lin * 3;
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_one'] + ':',array(25,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_two'] + ':',array(25,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['price_three'] + ':',array(25,$lin),array('Arial','',10),'0');
		
		$pos['X'] -= 25;
		$pos = add_MultiCell($pdf,$pos,'J',$prd['aplicacion'],array(60,$lin),array('Arial','',8),'0');	
		
		$pos['Y'] -= $lin * 5;
		if(!$sen){$pos['X'] = 135;}else{$pos['X'] = 5;}	
		
		/* Labels */
		$pos = add_MultiCell($pdf,$pos,'L','Parts:',array(15,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L','Wells:',array(15,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L','SMP:',array(15,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L','Tomco:',array(15,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L','OEM:',array(15,$lin),array('Arial','',10),'0');
		
		/* Data */ 
		$pos['X'] += 15;
		$pos['Y'] -= $lin * 5;
		
		$pos = add_MultiCell($pdf,$pos,'L',$prd['parts'],array(40,$lin),array('Arial','B',14),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['wells'],array(40,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['smp'],array(40,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['tomco'],array(40,$lin),array('Arial','',10),'0');
		$pos = add_MultiCell($pdf,$pos,'L',$prd['oem'],array(50,$lin),array('Arial','',10),'0');	
		
		if(!$sen){$pos['X'] = 5;}else{$pos['X'] = 150;}
		
		$pos['Y'] -= $lin * 5;
		file_put_contents('../assets/img/' + $prd['idproductFlayer'] + '.jpg',$prd['image']);
		$pdf->Image('../assets/img/' + $prd['idproductFlayer'] + '.jpg',$pos['X'],$pos['Y'],60,35);		
		$pos['Y'] += $lin * 7;
		
		add_MultiCell($pdf,$pos,'C',$prd['name'],array(60,$lin),array('Arial','',8),'0');
		$pos['X'] = 5;	
		$pos['Y'] += $lin * 2;
		$pdf->Line($pos['X'], $pos['Y'] - 5, 210, $pos['Y'] - 5);
		return $pos;
	}

?>