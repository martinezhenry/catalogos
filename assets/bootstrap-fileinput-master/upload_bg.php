<?php
include '../../common/general.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// upload.php
// 'images' refers to your file input name attribute
//if (empty($_FILES['images'])) {
if (empty($_FILES['catalogo_fondo'])) {
    echo json_encode(['error'=>'No files found for upload.']);
    // or you can throw an exception
    return; // terminate
}
$cod_img = uniqid();
$nombre_carpeta = "fondo_temp/";
//$nombre_archivo = $nombre_carpeta.$_FILES['catalogo_portada']['name'];

$tipo_archivo = $_FILES['catalogo_fondo']['type'];
$tamano_archivo = $_FILES['catalogo_fondo']['size'];
$temp_archivo = $_FILES['catalogo_fondo']['tmp_name'];
$nom_archivo = $_FILES['catalogo_fondo']['name'];
$ext = pathinfo($nom_archivo, PATHINFO_EXTENSION);
$nombre_imagen = 'fd_'.$cod_img.'.'.$ext;
$nombre_archivo = $nombre_carpeta.$nombre_imagen;
//$r = '22';
//$output = ['error'=>'COD: '.$cod_img.','.$r];
//compruebo si las características del archivo son las que deseo
if (file_exists($nombre_carpeta)){
//    if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 100000000))) {
    if (!(strpos($tipo_archivo, "jpeg") && ($tamano_archivo < 100000000))) {
//        $output = ['error'=>'La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif o .jpg se permiten archivos de 100 Kb máximo. '.$nombre_archivo];
        $output = ['error'=>'La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .jpg se permiten archivos de 100 Kb máximo. '.$nombre_archivo];
    }else{
        if (move_uploaded_file($temp_archivo, $nombre_archivo)){
            $_SESSION['cod_img_fd'] = $nombre_imagen;
            $output = ['success'=>'El archivo ha sido cargado correctamente.'];
        }else{
           $output = ['error'=>'Ocurrió algún error al subir el fichero. No pudo guardarse.'.$temp_archivo.' => '.$nombre_archivo];
        }
    }
}else{ $output = ['error'=>'NO ESXISTE CARPETA.'.$nombre_carpeta]; }
// return a json encoded response for plugin to process successfully
echo json_encode($output);



/*
// upload.php de http://webtips.krajee.com/ajax-based-file-uploads-using-fileinput-plugin/
if (empty($_FILES['ticket'])) {
    return; // or process or throw an exception
}

// get the files posted
$ticket = $_FILES['ticket'];

// get server posted
$server = empty($_POST['server']) ? '' : $_POST['server'];

// get user name posted
$user = empty($_POST['user']) ? '' : $_POST['user'];

// a flag to see if everything is ok
$success = null;

// file paths to store
$paths= [];

// loop and process files
for($i=0; $i < count($ticket); $i++){
    $ext = explode('.', basename($ticket['name'][$i]));
    $target = "tickets/" . md5(uniqid()) . "." . array_pop($ext);
    if(move_uploaded_file($ticket['tmp_name'][$i], $target)) {
        $success = true;
        $paths[] = $target;
    } else{
        $success = false;
        break;
    }
}
*/