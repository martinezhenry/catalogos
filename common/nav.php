<?php

/* 
 * OPCIONES DEL MENU.
 */
global $opc_nav;
$opc_nav = array(
    'index' => array('Inicio','init.php','fa fa-home')
   ,'catalogos' => array('Catalogos','catalogoIndex.php','fa fa-book')
   ,'flayers' => array('Flayers','flayer.php','fa fa-image')
);
//    function opc_nav(){
//        $opc_nav = array(
//             'index' => array('Inicio','init.php','fa fa-home')
//            ,'catalogos' => array('Catalogos','catalogoIndex.php','fa fa-book')
//        );
//        return $opc_nav;
//    }