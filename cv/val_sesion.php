<?php

//VALIDA SESSION
session_start();
if (isset($_SESSION['valida_sesion'])){
    if(!$_SESSION["valida_sesion"]==1111){
        header("location:../../common/stop_sesion.php"); 
//        echo realpath('stop_sesion.php');
    }
}else{ 
    header("location:../../common/stop_sesion.php"); 
//    echo realpath('stop_sesion.php');
}