<?php
    include 'general.php';
    $obj_bdmysql = new coBdmysql();
//    $navegador = ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
//    if($navegador == 'Mozilla' || $navegador == 'Mozilla Firefox'){
        session_start();
        $_SESSION["auten"]=0;
        $usuario = $_POST['usuario'];
        $clave = md5($_POST['clave']);
//        $clave = md5('lklk');
//        $clave = 'e10adc3949ba59abbe56e057f20f883e';
        $mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
        if (!$mysqli->connect_error){
            $r = $obj_bdmysql->select("pnlUsuario","*","usuario = '".$usuario."' AND clave = '".$clave."'", "", "",$mysqli);
//            echo $r;
            if (is_array($r)){
                if ($r[0]['activo'] == '1'){
                    $_SESSION['valida_sesion'] = '1';
                    $_SESSION["user"]=$r['nombre'];
                    $_SESSION["cod_usuario"]=$r['id'];
//                    $_SESSION["perfil"]=$r['perfil'];
                    header("location:../app/view/init.php");
                }else{ header("location:../index.php?salida=inactivo");}
            }else{ header("location:../index.php?salida=fallida");}
        }else{ header("location:../index.php?salida=interno");}
//    }else{ header("location:navegadores.php"); }
        
    /*
    function ObtenerNavegador($user_agent) {
         $navegadores = array(
              'Opera' => 'Opera',
              'Mozilla Firefox'=> '(Firebird)|(Firefox)',
              'Galeon' => 'Galeon',
              'Mozilla'=>'Gecko',
              'MyIE'=>'MyIE',
              'Lynx' => 'Lynx',
              'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
              'Konqueror'=>'Konqueror',
              'Internet Explorer 9' => '(MSIE 9\.[0-9]+)',
              'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
              'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
              'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
              'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
    );

    foreach($navegadores as $navegador=>$pattern){
           if (preg_match($pattern, $user_agent))
           return $navegador;
        }
    return 'Desconocido';
    }
     * 
     */
?>