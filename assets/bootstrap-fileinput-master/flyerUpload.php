<?php 



if (!empty($_FILES['flyer_fondo']) || !empty($_FILES['productFlyer_img'])) {
    
$cod_img = uniqid();

if (!empty($_FILES['flyer_fondo'])) {
    $nombre_carpeta = "../img/fondoFlyer/";
    $file = "flyer_fondo";
} else {
    $nombre_carpeta = "../img/imageProductFlyer/";
    $file = "productFlyer_img";
}
//$nombre_archivo = $nombre_carpeta.$_FILES['catalogo_portada']['name'];

$tipo_archivo = $_FILES[$file]['type'];
$tamano_archivo = $_FILES[$file]['size'];
$temp_archivo = $_FILES[$file]['tmp_name'];
$nom_archivo = $_FILES[$file]['name'];
$ext = pathinfo($nom_archivo, PATHINFO_EXTENSION);
$nombre_imagen = 'fondoTemp.'.$ext;
$nombre_archivo = $nombre_carpeta.$nombre_imagen;
//$r = '22';
//$output = ['error'=>'COD: '.$cod_img.','.$r];
//compruebo si las características del archivo son las que deseo
if (file_exists($nombre_carpeta)){
//    if (!((strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png")) && ($tamano_archivo < 100000000))) {
    if (($tamano_archivo > 100000000)) {
//        $output = ['error'=>'La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .gif o .jpg se permiten archivos de 100 Kb máximo. '.$nombre_archivo];
        $output = ['error'=>'La extensión o el tamaño de los archivos no es correcta. Se permiten archivos .jpg se permiten archivos de 100 Kb máximo. '.$nombre_archivo];
    }else{
        if (move_uploaded_file($temp_archivo, $nombre_archivo)){
            $_SESSION['cod_img'] = $nombre_imagen;
            $output = ['success'=>'El archivo ha sido cargado correctamente.'];
        }else{
           $output = ['error'=>'Ocurrió algún error al subir el fichero. No pudo guardarse.'.$temp_archivo.' => '.$nombre_archivo];
        }
    }
}else{ $output = ['error'=>'NO ESXISTE CARPETA.'.$nombre_carpeta]; }
// return a json encoded response for plugin to process successfully
echo json_encode($output);


} else {

    echo json_encode(['error'=>'No files found for upload.']);
    // or you can throw an exception
    return; // terminate

}