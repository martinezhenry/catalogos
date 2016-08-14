<?php

class Tabulador {

    public function __construct() {
        //parent::__construct();
        //$this->load->helper('url');
        
    }

    var $ini_tabla = '<table border="0" width="520" style="margin:10px;"> <tbody>';
    var $fin_tabla = '</tbody> </table>';
    

    public function index($array_productos) {
        //echo "<pre>";
        //var_dump($array_productos);
        //echo "<pre>";
        //die();
        $contenido[0] = null;
        $contenido[1] = null;
        $contenido[2] = null;
        $contenido[3] = null;
        $contenido[4] = null;

        $i = 0;
        $j = 0;
        $k = 0;
        $maximo_registros = count($array_productos);
        foreach ($array_productos as $value) {
//            echo '<pre>';
//            var_dump("EVALUANDO LOS SIGUIENTES NUMEROS I: $i J: $j  ");
//            echo '</pre>';
            if (!file_exists("../../assets/img/art/".$value['nombre_imagen'].".jpg")){
                $value['nombre_imagen'] = "def2";
            }

            if ($j === 0) {
//                ECHO "VERIFICO PRIMERA PAGINA <BR><BR>";
                if ($i == 0) {/* primera pagina */
//                    echo '<pre>';
//                    var_dump("DESTACADO VALOR DE I:", $i, "VALOR DE J:", $j, "");
//                    echo '</pre>';
                    $contenido[$i] = $this->tabla_producto_destacado($value);
                    $i++;
                    $k++;
                } elseif ($i == 1) {/* primera pagina */
//                    echo '<pre>';
//                    var_dump(" IZQUIERDA VALOR DE I:", $i, "VALOR DE J:", $j, "");
//                    echo '</pre>';
                    $contenido[$i] = $this->tabla_imagen_izquierda($value);
                    $i++;
                    $k++;
                } elseif ($i == 2) {/* primera pagina */
//                    echo '<pre>';
//                    var_dump(" DERECHA VALOR DE I:", $i, "VALOR DE J:", $j, "");
//                    echo '</pre>';
                    $contenido[$i] = $this->tabla_imagen_derecha($value);
                    $i++;
                    $k++;
                }elseif ($i == 3) {/* primera pagina */
//                    echo '<pre>';
//                    var_dump(" DERECHA VALOR DE I:", $i, "VALOR DE J:", $j, "");
//                    echo '</pre>';
                    $contenido[$i] = $this->tabla_imagen_izquierda($value);
                    $i++;
                    $k++;
                }elseif ($i == 4) {/* primera pagina */
//                    echo '<pre>';
//                    var_dump(" DERECHA VALOR DE I:", $i, "VALOR DE J:", $j, "");
//                    echo '</pre>';
                    $contenido[$i] = $this->tabla_imagen_derecha($value);
                    $i++;
                    $k++;
                }
            } elseif ($j % 2 == 0 && $j > 0) {//PAGINA PAR
//                ECHO "VERIFICO PAR";
//                var_dump("PAR VALOR DE I:", $i, "VALOR DE J:", $j, "");
                if ($i === 0) {
//                    ECHO "Imprimiendo par izquierdo 0", "";
                    $contenido[$i] = $this->tabla_imagen_derecha($value, $i);
                    $i++;
                    $k++;
                } elseif ($i == 1) {
//                    ECHO "Imprimiendo  par derecho 1", "";
                    $contenido[$i] = $this->tabla_imagen_izquierda($value, $i);
                    $i++;
                    $k++;
                } elseif ($i == 2) {
//                    ECHO "Imprimiendo  par izquierdo 2", "";
                    $contenido[$i] = $this->tabla_imagen_derecha($value, $i);
                    $i++;
                    $k++;
                }elseif ($i == 3) {
//                    ECHO "Imprimiendo  par derecho 1", "";
                    $contenido[$i] = $this->tabla_imagen_izquierda($value, $i);
                    $i++;
                    $k++;
                }elseif ($i == 4) {
//                    ECHO "Imprimiendo  par izquierdo 2", "";
                    $contenido[$i] = $this->tabla_imagen_derecha($value, $i);
                    $i++;
                    $k++;
                }
            } elseif ($j % 2 != 0 && $j > 0) {//PAGINA IMPAR
//                ECHO "VERIFICO IMPAR", "";
//                var_dump("IMPAR VALOR DE I:", $i, "VALOR DE J:", $j, "");
                if ($i === 0) {
//                    ECHO "Imprimiendo  impar derecho 0", "";
                    $contenido[$i] = $this->tabla_imagen_izquierda($value, $i);
                    $i++;
                    $k++;
                } elseif ($i === 1) {
//                    ECHO "Imprimiendo  impar izquierdo 1", "";
                    $contenido[$i] = $this->tabla_imagen_derecha($value, $i);
                    $i++;
                    $k++;
                } elseif ($i === 2) {
//                    ECHO "Imprimiendo  impar derecho 2", "";
                    $contenido[$i] = $this->tabla_imagen_izquierda($value, $i);
                    $i++;
                    $k++;
                }elseif ($i === 3) {
//                    ECHO "Imprimiendo  impar izquierdo 1", "";
                    $contenido[$i] = $this->tabla_imagen_derecha($value, $i);
                    $i++;
                    $k++;
                }elseif ($i === 4) {
//                    ECHO "Imprimiendo  impar derecho 2", "";
                    $contenido[$i] = $this->tabla_imagen_izquierda($value, $i);
                    $i++;
                    $k++;
                }
            }

            if ($i === 5 || $k == $maximo_registros) {
//                echo "GUARDO LA SALIDA";
                $contenido_tabla = $contenido[0] . $contenido[1] . $contenido[2]. $contenido[3]. $contenido[4];
                $out [$j] = $this->ini_tabla . $contenido_tabla . $this->fin_tabla;
                $contenido[0] = null;
                $contenido[1] = null;
                $contenido[2] = null;
                $contenido[3] = null;
                $contenido[4] = null;

                $i = 0;
                $j++;
            }
        }

        //echo '<pre>';
        //var_dump($out);
        //echo '</pre>';
        //die();
        return $out;
    }

    public function tabla_producto_destacado($param) {
            if(empty($param["alias"])){
                $alias='';
            }else{
                $alias= $param["alias"];
            }

            if(empty($param["price_name_2"])){
                $price_name_2='<td colspan="1" style="text-align:right;"></td> <td colspan="4" style="text-align:left;"></td>';
            }else{
                $price_name_2='<td colspan="1" style="text-align:right;"> <strong> '.$param["price_name_2"].' $: </strong> </td> <td colspan="4" style="text-align:left;"> ' . $param["price_2"] .'</td>';
            }

            if(empty($param["price_name_3"])){
                $price_name_3='<td colspan="1" style="text-align:right;"></td> <td colspan="4" style="text-align:left;"></td>';
            }else{
                $price_name_3='<td colspan="1" style="text-align:right;"> <strong> '.$param["price_name_3"].' $: </strong> </td> <td colspan="4" style="text-align:left;"> ' . $param["price_3"] .' </td> ';
            }

            if(empty($param["smp"])){
                $smp='';
            }else{
                $smp= $param["smp"] ;
            }

            if(empty($param["tomco"])){
                $tomco='';
            }else{
                $tomco=$param["tomco"]  ;
            }

            if(empty($param["oem"])){
                $oem='';
            }else{
                $oem= $param["oem"]  ;
            }
            
            if(empty($param["application"])){
                $application='';
                $application_label='';
            }else{
                $application= $param["application"]  ;
                $application_label= $param["application_label"].':'   ;
            }

            $html = '<!-- Producto Destacado  -->
                
                        <hr style="margin:0px;">

                <tr>
                    <td colspan="12" >
                        <div style="font-size: 22px; margin:0px; padding:0px; text-align:center;"><strong>' . $param["titulo_product_name"] . '</strong></div> <br>
                    </td>
                </tr>
                <tr>
                    <td width="60" colspan="1" style="text-align:right;">
                        <strong style="font-size: 14px; ">Part #: </strong> 
                    </td>
                    <td width="200" colspan="5">
                        <strong style="font-size: 14px; ">' . $param["part"] . ' </strong> 
                    </td>
                    <td width="70" colspan="1"  style="text-align:right;">
                        <strong>'.$param["price_name_1"].' $:</strong>  
                    </td>
                    <td  width="90" colspan="4" style="text-align:left;"> ' . $param["price_1"] . '</td>
                    <td width="100" rowspan="5" style="text-align:center;">
                            <img width="91" height="91"  style="margin-top: 0px; padding-top: 0px; text-align:top" alt="Bootstrap Image Preview"  src="' . '' . '../../assets/img/art/' . $param["nombre_imagen"] . '.jpg"  class="img-rounded">
                            <strong>' . $param["product_name"] . '</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right;">
                        <strong>Wells: </strong> 
                    </td>
                    <td colspan="5" >
                        ' .$alias. '  
                    </td>
                    '.$price_name_2.'
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right;">
                        <strong>SMP: </strong> 
                    </td>
                    <td colspan="5" >
                        ' .$smp.'  
                    </td>
                    '.$price_name_3.'
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right;">
                        <strong>TOMCO: </strong>
                    </td> 
                    <td colspan="10" >
                        ' . $tomco.'  
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right;">
                        <strong>OEM: </strong> 
                    </td> 
                    <td colspan="3" >
                        ' .$oem.' 
                    </td>
                    <td width="70" colspan="1" style="text-align:top;">
                        <strong>' .$application_label.'</strong> 
                    </td>    
                    <td width="170" colspan="6">' .$application.'</td>
                </tr>

                        <hr style="margin:0px;">';

//echo var_dump( '<table border="1" width="525" style="margin:10px;"> <tbody>',$html, '</tbody> </table>');die();
        return $html;


    }

    public function tabla_imagen_derecha($param, $tabla_producto_separador = 1) {

        if ($tabla_producto_separador == 0) {
            $hr = '
                        <hr style="margin:1px;">';
        } else {
            $hr = "";
        }

            if(empty($param["alias"])){
                $alias='';
            }else{
                $alias= $param["alias"];
            }

            if(empty($param["price_name_2"])){
                $price_name_2='<td colspan="3" style="text-align:right"></td> <td colspan="3"></td>';
            }else{
                $price_name_2='<td colspan="3" style="text-align:right"><strong>'.$param["price_name_2"].' $:</strong></td> <td colspan="3">' . $param["price_2"] .'</td>';
            }

            if(empty($param["price_name_3"])){
                $price_name_3='<td colspan="3" style="text-align:right"></td> <td colspan="3"></td>';
            }else{
                $price_name_3='<td colspan="3" style="text-align:right"><strong>'.$param["price_name_3"].' $:</strong></td> <td colspan="3">' . $param["price_3"] .'</td>';
            }

            if(empty($param["smp"])){
                $smp='';
            }else{
                $smp= $param["smp"] ;
            }

            if(empty($param["tomco"])){
                $tomco='';
            }else{
                $tomco=$param["tomco"]  ;
            }

            if(empty($param["oem"])){
                $oem='';
            }else{
                $oem= $param["oem"]  ;
            }
            if(empty($param["application"])){
                $application='';
                $application_label='';
            }else{
                $application= $param["application"]  ;
                $application_label= $param["application_label"].':'   ;
            }

        $html = '<!-- Imagen Derecha  -->
                ' . $hr . '
                
                <tr>
                    <td width="60" colspan="1" style="text-align:right">
                        <strong style="font-size: 14px;">Part #:</strong> 
                    </td>
                    <td width="200" colspan="4">
                        <strong style="font-size: 14px;">' . $param["part"] . ' </strong> 
                    </td>
                    <td width="70" colspan="3" style="text-align:right">
                        <strong>'.$param["price_name_1"].' $: </strong>  
                    </td>
                    <td width="90" colspan="3">' . $param["price_1"] . '</td>
                    <td width="100" rowspan="5" style="text-align:center">
                        <img width="91" height="91" style="margin-top: 0px; padding-top: 0px;" alt="Bootstrap Image Preview" src="' . '' . '../../assets/img/art/' . $param["nombre_imagen"] . '.jpg" class="img-rounded">
                        <br><strong>' . $param["product_name"] . '</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right">
                        <strong>Wells: </strong> 
                    </td>
                    <td colspan="4" style="text-align:left">
                        ' .$alias. '  
                    </td>
                    '.$price_name_2.'
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right">
                        <strong>SMP: </strong> 
                    </td>
                    <td colspan="4" style="text-align:left">
                        ' .$smp.'  
                    </td>
                    '.$price_name_3.'
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right">
                        <strong>TOMCO: </strong>
                    </td> 
                    <td colspan="10" style="text-align:left">
                        ' . $tomco.'  
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="1" style="text-align:right">
                        <strong>OEM: </strong> 
                    </td> 
                    <td colspan="2" style="text-align:left">
                        ' .$oem.' 
                    </td>
                    <td colspan="2" style="text-align:right">
                        <strong>' .$application_label.'</strong> 
                    </td>    
                    <td colspan="6" style="text-align:left">' .$application.'</td>

                </tr>
                        <hr style="margin:1px;">';
        return $html;
    }

    public function tabla_imagen_izquierda($param, $tabla_producto_separador = 1) {
        if ($tabla_producto_separador == 0) {
            $hr = '
                        <hr style="margin:1px;">';
        } else {
            $hr = "";
        }
            if(empty($param["alias"])){
                $alias='';
            }else{
                $alias= $param["alias"];
            }

            if(empty($param["price_name_2"])){
                $price_name_2='<td style="text-align:right;" colspan="2" > </td> <td style="text-align:left;"  colspan="2"></td>';
            }else{
                $price_name_2='<td style="text-align:right;" colspan="2" > <strong> '.$param["price_name_2"].' $: </strong> </td> <td style="text-align:left;"  colspan="2"> ' . $param["price_2"] .' </td>';
            }

            if(empty($param["price_name_3"])){
                $price_name_3='<td style="text-align:right;" colspan="2" ></td> <td style="text-align:left;" colspan="2"> </td>';
            }else{
                $price_name_3='<td style="text-align:right;" colspan="2" > <strong> '.$param["price_name_3"].' $: </strong></td> <td style="text-align:left;" colspan="2"> ' . $param["price_3"] .' </td>';
            }

            if(empty($param["smp"])){
                $smp='';
            }else{
                $smp= $param["smp"] ;
            }

            if(empty($param["tomco"])){
                $tomco='';
            }else{
                $tomco=$param["tomco"]  ;
            }

            if(empty($param["oem"])){
                $oem='';
            }else{
                $oem= $param["oem"]  ;
            }

            if(empty($param["application"])){
                $application='';
                $application_label='';
            }else{
                $application= $param["application"]  ;
                $application_label= $param["application_label"].':'  ;
            }

        $html = '
                <!-- Imagen Izquierda  -->
                ' . $hr . '
                <tr>
                    <td width="100" colspan="2" rowspan="5" style="text-align:center">
                        <img width="91" height="91"  style="margin-top: 0px; padding-top: 0px;" alt="Bootstrap Image Preview"  src="' . '' . '../../assets/img/art/' . $param["nombre_imagen"] . '.jpg"  class="img-rounded">
                        <br><strong>' . $param["product_name"] . '</strong>
                    </td>
                    <td width="80" colspan="2"  style="text-align:right">
                        <strong>'.$param["price_name_1"].' $: </strong> 
                    </td>
                    <td width="100" style="text-align:left" colspan="2" > ' . $param["price_1"] . ' </td>
                    <td width="80" colspan="3" style="text-align:right">
                        <strong style="font-size: 14px;" >Part #: </strong> 
                    </td>
                    <td width="160" colspan="5">
                        <strong style="font-size: 14px;" >' . $param["part"] . '</strong> 
                    </td>
                </tr>
                <tr>
                    '.$price_name_2.'  
                    <td colspan="3" style="text-align:right">
                        <strong>Wells: </strong>   
                    </td>
                    <td colspan="5" style="text-align:left">
                        ' .$alias. '
                    </td>
                </tr>
                <tr>
                    '.$price_name_3.'
                    <td colspan="3" style="text-align:right">
                        <strong>SMP: </strong> 
                    </td>
                    <td colspan="5" style="text-align:left">
                        ' .$smp.'  
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                    </td>
                    <td colspan="3" style="text-align:right">
                        <strong>TOMCO: </strong> 
                    </td>
                    <td colspan="5" style="text-align:left">
                        ' . $tomco.'  
                    </td>

                </tr>    
                <tr>
                    <td colspan="2" style="text-align:right">
                        <strong>' .$application_label.' </strong>
                    </td>
                    <td colspan="3" style="text-align:left">' .$application. '</td>
                    <td colspan="2" style="text-align:right">
                        <strong>OEM: </strong>
                    </td>
                    <td colspan="5" style="text-align:left">
                     ' .$oem.' 
                    </td>
                    
                </tr>

                        <hr style="margin:1px;">';
        return $html;
    }

    

}
