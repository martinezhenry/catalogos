<?php
include 'general.php';
$id_catalogo = $_SESSION["cod_cat"];
//echo 'SS: '.$id_catalogo.', '.$_SESSION["cod_cat"];
session_start();
session_destroy();
header("location:index.php?cd=".$id_catalogo);