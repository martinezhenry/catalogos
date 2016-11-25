<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//VISTA DE ERRORES
//error_reporting(E_ALL);
//ini_set('display_errors','1');

//VALIDA SESSION
if(basename($_SERVER['PHP_SELF']) != 'start_sesion.php'){
    session_start();
    
    if (isset($_SESSION['valida_sesion'])){
        if($_SESSION["valida_sesion"]!=1){ header("location:/cat/common/stop_sesion.php"); }
    }else{ header("location:/cat/common/stop_sesion.php"); }
}
//CONSTANTES
define('FOOTER_DES', 'GADMIN');
define('EXP_REG_RGB', "/^rgb\(\s{0,1}[0-9]{0,3},\s{0,1}[0-9]{0,3},\s{0,1}[0-9]{0,3}\)/");
define('CANT_ART_PDF', '200');
//BD
/*define('DBHOST', 'localhost'); 
define('DBUSER', 'v1131055_cat_us'); 
define('DBPASS', 'Clave123'); 
define('DBNOM', 'v1131055_cat');*/

define('DBHOST', 'localhost'); 
define('DBUSER', 'root'); 
define('DBPASS', ''); 
define('DBNOM', 'catalogo');

//BD2
define('DBHOST2', '50.196.74.121');
define('DBUSER2', 'vzla');
define('DBPASS2', 'vzla5740tex');
define('DBNOM2', 'autodatasystem');



//INCLUDES
//CONEXION BD
include 'bdMysql.php';
//FUNCIONES AUX
include 'function.php';
//ARCHIVOS COMUNES
include 'common.php';