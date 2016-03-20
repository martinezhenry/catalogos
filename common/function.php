<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class coFunction{
    //GENERA OPTION DE LISTAS DESPLEGABLES
    function select_list($id,$etiqueta,$tabla,$aux){
        $select = '<option value="">Seleccione...</option>';
        $list = $select;
        $query = mysql_query("SELECT * FROM ".$tabla." ".$aux);
        if(mysql_num_rows($query) > 0){
            while ($r = mysql_fetch_array($query)){
                $list.= '<option value="'.$r[$id].'">'.strtoupper($r[$etiqueta]).'</option>';
            }
        }
        return $list;
    }
    
    //VALIDA Y DEPURA VALORES DE ARREGLOS
    function evalua_array($array,$i){ 
        if (array_key_exists($i,$array)){
            if (isset($array[$i])) {
                $resp = utf8_encode(trim($array[$i]));
            }else{
                $resp = "";
            }
        }else{
            $resp = "";
        }
        return $resp;
    }
    function envia_correo($origen_nom,$asunto,$html,$mensaje,$destino,$destino_nom){
        include("phpMailer/class.phpmailer.php");
        include("phpMailer/class.smtp.php");
        
        $usuario = 'y.alayn@gmail.com';
        $clave = 'bd7613bfy1015232y';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = $usuario;
        $mail->Password = $clave;

        $mail->From = $usuario;
        $mail->FromName = $origen_nom;
        $mail->Subject = $asunto;
        $mail->AltBody = $mensaje;
        $mail->MsgHTML($html);
        foreach ($destino as $i => $d){
            $mail->AddAddress($d,trim(strtolower($destino_nom[$i])));
        }
        $mail->IsHTML(true);
        if(!$mail->Send()){
            return 'Error: '.trim($mail->ErrorInfo);
        }else{
            return '1';
        }
//        unset($mail);
    }
    
    function code_url($valor,$opc){
        $corte = 7;
        if($opc == 'code'){
            $control = substr(uniqid(),0,10);
            $control1 = substr($control,0,$corte);
            $control2 = substr($control,$corte,10);
            $string = utf8_encode($valor);
            $resp = base64_encode($control1.$string.$control2);
        }elseif($opc == 'decode'){
            $string = base64_decode($valor);
            $control1 = substr($string,$corte);
            $control2 = substr($control1,-3);
            $resp = str_replace($control2,"",$control1);
        }else{
           $resp = '';   
        }
        return($resp);
    } 
    
    function codeQR($valor,$name){
        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'codeqr'.DIRECTORY_SEPARATOR;
        include "../../assets/phpqrcode/qrlib.php";    

        //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR)){
            mkdir($PNG_TEMP_DIR);
        }
//
        $filename = $PNG_TEMP_DIR.'test.png';
//        
        $matrixPointSize = 10;
        $errorCorrectionLevel = 'L';
//        //$filename = $PNG_TEMP_DIR.'test'.md5($valor.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        $filename = $PNG_TEMP_DIR.$name.'.png';
        QRcode::png($valor, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        return $valor.$name;
    }
    
    function master_id($id,$opc,$mysqli){
        $obj_bdmysql = new coBdmysql();
        $tabla = "master_id";
        $resp = '0';
        
//        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
        if($opc == 'ext'){
            $resul = $obj_bdmysql->select($tabla, "CASE WHEN MAX(".$id.") IS NULL THEN 1 ELSE MAX(".$id.")+1 END AS $id", "", "", "",$mysqli);
            if(is_array($resul)){  $resp = $resul[0][$id]; }
        }elseif($opc == 'act'){
            if($obj_bdmysql->num_row($tabla,"",$mysqli) == 0){
                if($obj_bdmysql->insert($tabla, $id, "'1'",$mysqli) == '1'){ $resp = '1'; }
            }else{
                $max_id = $this->master_id($id, 'ext',$mysqli);
                if($obj_bdmysql->update($tabla, "$id = '".$max_id."'","",$mysqli) == '1'){ $resp = '1'; }
            }
        }else{ $resp = '0'; }
        return $resp;
    }
}