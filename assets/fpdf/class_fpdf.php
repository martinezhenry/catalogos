<?php
require('fpdf.php');
class PDF extends FPDF
	{
		var $B;
		var $I;
		var $U;
		var $HREF;

		function PDF($orientation='P', $unit='mm', $size='A4')
		{
			// Call parent constructor
			$this->FPDF($orientation,$unit,$size);
			// Initialization
			$this->B = 0;
			$this->I = 0;
			$this->U = 0;
			$this->HREF = '';
		}

		function WriteHTML($html)
		{
			// HTML parser
			$html = str_replace("\n",' ',$html);
			$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
			foreach($a as $i=>$e)
			{
				if($i%2==0)
					{
					// Text
					if($this->HREF)
						$this->PutLink($this->HREF,$e);
					else
						$this->Write(5,$e);
				}
				else
				{
					// Tag
					if($e[0]=='/')
						$this->CloseTag(strtoupper(substr($e,1)));
					else
					{
						// Extract attributes
						$a2 = explode(' ',$e);
						$tag = strtoupper(array_shift($a2));
						$attr = array();
						foreach($a2 as $v)
						{
							if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3)){
								$attr[strtoupper($a3[1])] = $a3[2];
							}
						}
						$this->OpenTag($tag,$attr);
					}
				}
			}
		}

		function OpenTag($tag, $attr)
		{
			// Opening tag
			if($tag=='B' || $tag=='I' || $tag=='U'){			
				$this->SetStyle($tag,true);
			}
			
			if($tag=='A'){
				$this->HREF = $attr['HREF'];
			}
			if($tag=='BR'){
				$this->Ln(5);
		}	}

		function CloseTag($tag)
		{
			// Closing tag
			if($tag=='B' || $tag=='I' || $tag=='U'){
				$this->SetStyle($tag,false);
			}
			
			if($tag=='A'){
				$this->HREF = '';
			}
		}

		function SetStyle($tag, $enable)
		{
			// Modify style and select corresponding font
			$this->$tag += ($enable ? 1 : -1);
			$style = '';
			foreach(array('B', 'I', 'U') as $s)
			{
				if($this->$s>0){
					$style .= $s;
				}
			}
		$this->SetFont('',$style);
		}

		function PutLink($URL, $txt)
		{
			// Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
		}

		function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
		{
			$k = $this->k;
			$hp = $this->h;
			if($style=='F'){
				$op='f';
			}
			elseif($style=='FD' || $style=='DF'){
				$op='B';
			}
			else{
				$op='S';
			}
			$MyArc = 4/3 * (sqrt(2) - 1);
			$this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

			$xc = $x+$w-$r;
			$yc = $y+$r;
			$this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
			if (strpos($corners, '2')===false)
				$this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
			else
				$this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

			$xc = $x+$w-$r;
			$yc = $y+$h-$r;
			$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
			if (strpos($corners, '3')===false)
				$this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
			else
				$this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

			$xc = $x+$r;
			$yc = $y+$h-$r;
			$this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
			if (strpos($corners, '4')===false)
				$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
			else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

			$xc = $x+$r ;
			$yc = $y+$r;
			$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
			if (strpos($corners, '1')===false)
			{
				$this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
				$this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
			}
			else
				$this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
				$this->_out($op);
		}

		function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
		{
			$h = $this->h;
			$this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
		}
		
		function Rotate($angle,$x=-1,$y=-1){
			if($x==-1){
				$x=$this->x;
			}
		
			if($y==-1){
				$y=$this->y;
			}
		
			if($this->angle!=0){
				$this->_out('Q');
			}
		
			$this->angle=$angle;
		
			if($angle!=0){
				$angle*=M_PI/180;
				$c=cos($angle);
				$s=sin($angle);
				$cx=$x*$this->k;
				$cy=($this->h-$y)*$this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
			}
		}
		
		/*function _endpage(){
			if($this->angle!=0){
				$this->angle=0;
			$this->_out('Q');
			}
			parent::_endpage();
		}*/
		
		function RotatedText($x,$y,$txt,$angle){
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}

		function RotatedImage($file,$x,$y,$w,$h,$angle){
			//Image rotated around its upper-left corner
			$this->Rotate($angle,$x,$y);
			$this->Image($file,$x,$y,$w,$h);
			$this->Rotate(0);
		}
		
	}	


?>