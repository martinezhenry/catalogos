/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function preloader(){
    $('body').append('  <div id="modal" style="width:100%; height:100%; position:fixed; top:0; left:0; right:0; bottom:0; margin:auto; padding:10px;background:rgba(0,0,0,0.6); z-index:9000; text-align:center;display:none;">&nbsp;</div>'+
                     '  <div id="preloader" style="width:100%; height:100%; position:fixed; top:0; left:0; right:0; bottom:0; margin:auto; background:#FFF; z-index:10000; text-align:center;">'+
                     '      <div id="loader" style="width:128px; height:128px; position:absolute; top:50%; left:50%; margin:-50px 0 0 -50px;background:url(../../assets/img/loader.gif) center no-repeat;">&nbsp;</div>'+
                     '  </div>');
//    $('#loader').css("background","url(bin/preloader/loader.gif) center no-repeat");
//    desactiva_preloader();
    $('#preloader').fadeOut('fast');
//    $('body').css({'overflow':'visible'});
}

function activa_preloader(){
    //ACTIVA PRELOADER
    $('#preloader').fadeIn('fast');
    $('body').css({'overflow':'hidden'});
}

function desactiva_preloader(){
    $('#preloader').fadeOut('fast');
    $('body').css({'overflow':'visible'});
}

function abrir_modal(html){
    $('#modal').html(html);
    $('#modal').fadeIn('fast');
    $('body').css({'overflow':'hidden'});
}

function cerrar_modal(){
    $('#modal').html('');
    $('#modal').fadeOut('fast');
    $('body').css({'overflow':'visible'});
}