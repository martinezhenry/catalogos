<?php
error_reporting(E_ALL);
ini_set('display_errors','1');
include 'general.php';
$obj_bdmysql = new coBdmysql();
session_start();
$_SESSION["auten_web"]=0;
$usuario = $_POST['usuario'];
$clave = md5($_POST['clave']);
$id_catalogo = $_POST['cod'];
$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNOM);
if (!$mysqli->connect_error){
//        $r = $obj_bdmysql->select("pnlUsuario","*","usuario = '".$usuario."' AND clave = '".$clave."'", "", "",$mysqli);
//        if (is_array($r)){
//            if ($r[0]['activo'] == '1'){
            $_SESSION['valida_sesion_cat'] = '1';
 //           $_SESSION["user_cat"]=$r['nombre'];
 //           $_SESSION["cod_usuario_cat"]=$r['id'];
            $_SESSION["cod_cat"]=$id_catalogo;
            header("location:init.php");
//            }else{ header("location:../index.php?salida=inactivo");}
//        }else{ header("location:../index.php?salida=fallida");}
}else{ header("location:index.php?cd=".$id_catalogo);}
?>