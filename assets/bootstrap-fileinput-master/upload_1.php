<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// upload.php
// 'images' refers to your file input name attribute
//if (empty($_FILES['images'])) {
if (empty($_FILES['catalogo_portada'])) {
    echo json_encode(['error'=>'No files found for upload...fff']);
    // or you can throw an exception
    return; // terminate
}
 
// get the files posted
$images = $_FILES['catalogo_portada'];
 
// get user id posted
//$userid = empty($_POST['userid']) ? '' : $_POST['userid'];
// 
//// get user name posted
//$username = empty($_POST['username']) ? '' : $_POST['username'];
 
// a flag to see if everything is ok
$success = null;
 
// file paths to store
$paths= [];
 
// get file names
$filenames = $images['name'];
 
// loop and process files
//for($i=0; $i < count($filenames); $i++){
//    $ext = explode('.', basename($filenames[$i]));
//    $target = "uploads" . DIRECTORY_SEPARATOR . md5(uniqid()) . "." . array_pop($ext);
    $target = "uploads/".$filenames;
    if(!file_exists('uploads/')){ echo json_encode(['error'=>'No files exists']); return; }
    if(move_uploaded_file($images['tmp_name'], $target)) {
        $success = true;
        $paths[] = $target;
    } else {
        $success = false;
//        break;
    }
//}
 
// check and process based on successful status
if ($success === true) {
    // call the function to save all data to database
    // code for the following function `save_data` is not
    // mentioned in this example
//    save_data($userid, $username, $paths);
 
    // store a successful response (default at least an empty array). You
    // could return any additional response info you need to the plugin for
    // advanced implementations.
    $output = [];
    // for example you can get the list of files uploaded this way
    // $output = ['uploaded' => $paths];
} elseif ($success === false) {
    $output = ['error'=>'Error while uploading images. Contact the system administrator. '.$images['tmp_name'].' => '.$target];
    // delete any uploaded files
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = ['error'=>'No files were processed.'];
}
 
// return a json encoded response for plugin to process successfully
echo json_encode($output);