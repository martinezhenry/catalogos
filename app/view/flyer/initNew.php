<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_bdmysql = new coBdmysql();
    $controller = 'ctCatalogo.php';
    $_SESSION['cod_img'] = 'def.jpg';
    $_SESSION['cod_img_fd'] = 'def.jpg';
    //$id_catalogo = $obj_function->code_url($_GET['id'],'decode');
    $catalogo_order = '';
    $catalogo_order_id = '1';
    $catalogo_order_selected = '';
    $catalogo_order_columna = 1;
    $catalogo_order_orden = false;
    $catalogo_order_tipo = "both";
    $catalogo_order_art = 'cod_art';
    $titulo_fuente = 'helvetica';
    $titulo_estilo = '';
    $titulo_tamano = 36;
    $titulo_color = 'rgb(0,0,0)';
    $titulo_hor = 'C';
    $titulo_ver = 'C';
    //$link = 'http://textronic.info/cat/cv?cd='.$id_catalogo;
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
    if (!$mysqli->connect_error){
        $mysqli2 = new mysqli(DBHOST2, DBUSER2, DBPASS2, DBNOM2);
        if (!$mysqli2->connect_error) {
            //FILTROS
            //CATAGORIAS
            $list_categoria = '<option value="">Seleccione...</option>';
            $n_vehiculos = $obj_bdmysql->num_row("`codes cat`", "", $mysqli2);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes cat`", "*", "CatCode", "", "0,100",$mysqli2);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                foreach ($resul as $r){
                    $list_categoria.= '<option value="'.$r['CatCode'].'">'.$r['CatDesc'].'</option>';
                }
            }else{
                $list_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
            }

            //SUB-CATAGORIAS
            $list_sub_categoria = '<option value="">Seleccione Categoria...</option>';
            /*
            $list_sub_categoria = '<option value="">Seleccione...</option>';
            $n_vehiculos = $obj_bdmysql->num_row("`codes catsub`", "", $mysqli);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes catsub`", "*", "", "PrdCode", "0,100",$mysqli);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                foreach ($resul as $r){
                    $list_sub_categoria.= '<option value="'.$r['PrdCode'].'">'.$r['PrdCode'].' - '.$r['PrdDesc'].'</option>';
                }
            }else{
                $list_sub_categoria = '<option value="">NO SE ENCONTRARON DATOS</option>';
            }*/
            
            //FLAG        
            $list_flag = '';
            $n_vehiculos = $obj_bdmysql->num_row("`codes flag`", "FlagActive = '1'", $mysqli2);
            if($n_vehiculos > 0){
                $resul = $obj_bdmysql->select("`codes flag`", "*", "FlagActive = '1'", "Flag", "0,100",$mysqli2);
                if(!is_array($resul)){ $mss = 'ERROR AL CARGAR DATOS.'; }
                $n_flag = 1;
                foreach ($resul as $r){
                    $list_flag.= $n_flag.') <input type="checkbox" id="catalogo_ch_'.$r['Flag'].'" value="'.$r['Flag'].'"> '.$r['Flag'].': '.$r['FlagDesc'].'<br>';
                    $n_flag = $n_flag + 1;
                }
            }else{
                $list_flag = 'NO SE ENCONTRARON DATOS';
            }

            //LISTA DE ORDENAMIENTO DE ARTICULO
            $resul_order = $obj_bdmysql->select("catalogo_order","*","","id","",$mysqli);
            if(!is_array($resul_order)){ 
                $catalogo_order = '<option value=""></option>'; 
            }else{
                foreach ($resul_order as $r_order){
                    $valor = $r_order['id'].'_'.$r_order['columna_tabla'].'_'.$r_order['tipo_tabla'].'_'.$r_order['reverse'];
                    $catalogo_order.= '<option value="'.$valor.'" '.$catalogo_order_selected.'>'.$r_order['descripcion'].'</option>';
                    $catalogo_order_selected = '';
                }
            }
        }
    }
?>