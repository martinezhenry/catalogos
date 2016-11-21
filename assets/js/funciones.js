function ir_a(url,tipo){
    if(tipo === ''){ tipo = '_self'; }
    window.open (url,tipo,"status=1");
}
//LIMPIA CADENA
function forma_cad(cad){
    return cad.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'').replace(/#/gi,'').replace(/nbsp;/gi,"\u00a0");
}
//CARGA DATOS DEL CAMPO INDICADO
function carga_dato1(valor,campo){
    i = 0;
    cadena = '';
    valor = valor.split('|');
    campo = campo.split('|');
    nvalor = valor.length;
    ncampo = campo.length;
    if(nvalor == ncampo){
        while( i < nvalor){
            if(document.getElementById(campo[i])){
//                alert(campo[i]+' = .'+valor[i].replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'')+'.');
                document.getElementById(campo[i]).value = valor[i].replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'');
    //            cadena = cadena+campo[i]+' = '+valor[i]+'   |   ';
            }
            i++;
        }
//        alert('cadenas:'+cadena);
    }else{alert('Error en funcion carga_datos: numero de valores es disinto al numero de campos.'+nvalor+' != '+ncampo);}
}

//CARGA DATOS DEL PADRE INDICADO
function carga_dato2(idPadre,valor){
    padre = document.getElementById(idPadre);
    if(padre){
        valor = valor.split('|');
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='text' || elemento[i].type=='textarea' || elemento[i].type=='select-one'){
                //alert(elemento[i].id);
                elemento[i].value = valor[j].replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'');
                //alert(elemento[i].id+' = '+valor[j]);
                j++;   
            }
        }
    }
}

//CAPTURA DATOS DEL CAMPO INDICADO
function captura_datos(campo){
    i = 0;
    cadena = '';
    campo = campo.split('|');
    ncampo = campo.length;
    while( i < ncampo){
        if(document.getElementById(campo[i])){
            valor = document.getElementById(campo[i]).value.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'');
            cadena = cadena+'|'+valor;
        }
        i++;
    }
//    alert(cadena);
    return cadena;
}

function captura_datos_padre_conca(idPadre){
//    var idElemento = new Array();
    var cadena = '';
    padre = document.getElementById(idPadre);
    var elemento = padre.getElementsByTagName('*');
    var n = elemento.length;
    var j=0;
    for (var i=0; i<elemento.length; i++) {
        if(elemento[i].type === 'text' || elemento[i].type === 'textarea' || elemento[i].type === 'select-one' || elemento[i].type === 'file'  || elemento[i].type === 'hidden'){
            cadena = cadena+'|'+elemento[i].value.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'').replace(/#/gi,'');
            j++;
        }
    }
    //alert(cadena);
    return cadena;
}

//CAPTURA DATOS DEL CAMPO INDICADO
function captura_datos_padre(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var cadena = '';
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='hidden' || elemento[i].type=='text' || elemento[i].type=='textarea' || elemento[i].type=='select-one' || elemento[i].type=='password' || elemento[i].type=='file'){
                cadena = cadena+'&'+elemento[i].id+'='+elemento[i].value.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'').replace(/#/gi,'');
    //            cadena = cadena+'|'+elemento[i].value;
                j++;
            }
        }
        return cadena;
    }
}

//CAPTURA DATOS DEL CAMPO INDICADO Y MUESTRA UN PREVIEW
function captura_datos_padre_preview(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var html = '';
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<n; i++) {
            if(elemento[i].type=='text' || elemento[i].type=='textarea' || elemento[i].type=='select-one' || elemento[i].type=='password'){
                html = html+'<div class="controls col-md-4">'+
                       '    <label>'+elemento[i].title+':</label>'+
                       '    <input type="text" class="form-control" readonly value="'+elemento[i].value+'">'+
                       '</div>';
                j++;
            }
        }
        return html;
    }
}

function preview(idPadre,cont){
    padre = document.getElementById(idPadre);
    if(padre){
        resp = '<div id="'+cont+'">'+padre.innerHTML+'</div>';
    }else{ resp = ''; }
    return resp;
}

function captura_datos_hidden_padre(idPadre){
    var cadena = '';
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='hidden'){
                cadena = cadena+'&'+elemento[i].id+'='+elemento[i].value.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'');
                j++;
            }
        }
        return cadena;
    }
}

function captura_datos_conca_hidden_padre(idPadre){
//    var idElemento = new Array();
    var cadena = '';
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='hidden'){
    //            cadena = cadena+'&'+elemento[i].id+'='+elemento[i].value;
                cadena = cadena+'|'+elemento[i].value.replace(/[|¬°&]/gi,'').replace(/\/\*/gi,'').replace(/"/gi,'').replace(/'/gi,'');
                j++;
            }
        }
        return cadena;
    }
}

function captura_datos_div(idPadre){
//    var idElemento = new Array();
    var cadena = '';
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('div');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<n; i++) {
            cadena = cadena+'|'+elemento[i].id;
        }
        return cadena;
    }
}

function limpia_datos_padre(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='text' || elemento[i].type=='textarea' || elemento[i].type=='select-one' || elemento[i].type=='password'){
                elemento[i].value = '';
                j++;
            }
        }
    }
}


function captura_valor_ch(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var cadena = '';
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
            var j=0;
            for (var i=0; i<elemento.length; i++) {
                if(elemento[i].type=='checkbox'){
                    if(elemento[i].checked == true){
                        cadena = cadena+'/*'+document.getElementById(elemento[i].id).value;
                    }
                j++;
                }
            }
        return cadena;
    }
}

function captura_valor_ch3(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var cadena = [];
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
            var j=0;
            for (var i=0; i<elemento.length; i++) {
                if(elemento[i].type=='checkbox'){
                    if(elemento[i].checked == true){
                        cadena[i] = elemento[i];
                    }
                j++;
                }
            }
        return cadena;
    }
}



function captura_valor_ch2(idPadre){
    padre = document.getElementById(idPadre);
    if(padre){
        var cadena = '';
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
            var j=0;
            for (var i=0; i<elemento.length; i++) {
                if(elemento[i].type=='checkbox'){
                    if(elemento[i].checked == true){
                        valor_ch = elemento[i].value;
                    }else{
                        valor_ch = 0;
                    }
                    cadena = cadena+'&'+elemento[i].id+'='+valor_ch;
                j++;
                }
            }
        return cadena;
    }
}

function carga_ch(idPadre,valor,separador){
    padre = document.getElementById(idPadre);
    if(padre){
        valor = valor.split(separador);
        var elemento = padre.getElementsByTagName('*');
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='checkbox'){
                //alert(elemento[i].value);
                for(k in valor){if(elemento[i].value == valor[k]){ 
                        //alert(elemento[i].value+' == '+valor[k]);
                        elemento[i].checked = 1;}}
                //alert(elemento[i].id);
                //elemento[i].value = valor[j];
                //alert(elemento[i].id+' = '+valor[j]);
                j++;   
            }
        }
    }
}

//ACTIVA O DESACTIVA CAMPO
function readonly(campo,accion){
    if(accion){
        //DESACTIVA CAMPO
        if(document.getElementById(campo).type != 'select-one'){
            document.getElementById(campo).readOnly = true;
            document.getElementById(campo).style.background = '#cdcdcd';
        }else{
            document.getElementById(campo).disabled = true;
            document.getElementById(campo).style.background = '#cdcdcd';
        }
    }else{
        //ACTIVA CAMPO
        if(document.getElementById(campo).type != 'select-one'){
            document.getElementById(campo).readOnly = false;
            document.getElementById(campo).style.background = '#ffffff';
        }else{
            document.getElementById(campo).disabled = false;
            document.getElementById(campo).style.background = '#ffffff';
        }
    }
}

//ACTIVA O DESACTIVA CAMPOS DE UN FORMULARIO
function readonly_form(idPadre,accion){
//    alert('alll');
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type=='text' || elemento[i].type=='textarea' || elemento[i].type=='password'){
                readonly(elemento[i].id,accion);
            }else if(elemento[i].type=='select-one'){
                readonly(elemento[i].id,accion);
            }
            j++;
        }
    }
}

//ELIMINA ESPACIOS EN BLANCO EN STRING
function jTrim(cadena){
    return cadena.replace(/ /g,'');
}

function camp_no_aplica_padre(idPadre){
    readonly_form(idPadre,true);
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var j=0;
        for (var i=0; i<elemento.length; i++) {
            if(elemento[i].type === 'text' || elemento[i].type === 'textarea' || elemento[i].type === 'password'){
                elemento[i].value = 'NO APLICA';
            }else if(elemento[i].type === 'select-one'){
               elemento[i].value = ''; 
            }
            j++;
        }
    }
}

function captura_ch_valor_class(idPadre,clase){ 
    var cadena = '';
    padre = document.getElementById(idPadre);
    var elemento = padre.getElementsByTagName('*');
    var n = elemento.length;
    var j = 0;
    for (var i = 0; i < elemento.length; i++) {
        if (elemento[i].type === 'checkbox' && elemento[i].className === clase && elemento[i].checked === true) {
            cadena = cadena + '|' + elemento[i].value;
            j++;
        }
    }
    return cadena;
}

function compara_valor_class(idPadre,clase,valor){ 
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var existe = 0;
        for (var i = 0; i < n; i++) {
            if(elemento[i].className === clase){
                if(elemento[i].type === 'text' || elemento[i].type === 'textarea' || elemento[i].type === 'select-one'  || elemento[i].type === 'hidden'){
                    if(elemento[i].value === valor) existe = 1;
                }else{
                    if(elemento[i].innerHTML === valor) existe = 1;
                }
            }
        }
    }else{ alert('ERROR EN FUNCION INTERNA DE CLASES. NO EXISTE EL PADRE.'); return;}
    return existe;
}

function captura_valor_class(idPadre,clase){ 
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var cadena = '';
        for (var i = 0; i < n; i++) {
            if(elemento[i].className === clase){
                if(elemento[i].type === 'text' || elemento[i].type === 'textarea' || elemento[i].type === 'select-one'  || elemento[i].type === 'hidden'){
                    cadena = cadena + '|' + elemento[i].value;
                }else{
                    cadena = cadena + '|' + elemento[i].innerHTML;
                }
            }
        }
    }else{ alert('ERROR EN FUNCION INTERNA DE VALOR CLASES. NO EXISTE EL PADRE.'); return;}
    return cadena;
}

function captura_valor_class_hijos(idPadre,clase){ 
    padre = document.getElementById(idPadre);
    if(padre){
        var elemento = padre.getElementsByTagName('*');
        var n = elemento.length;
        var cadena = '';
        for (var i = 0; i < n; i++) {
            if(elemento[i].className === clase){
                cadena = cadena+'/*'+captura_datos_padre_conca(elemento[i].id);
            }
        }
    }else{ alert('ERROR EN FUNCION INTERNA DE VALOR CLASES. NO EXISTE EL PADRE.'); return;}
    return cadena;
}

//MASCARA DE CAMPOS CON CONDICIONES ESPECIALES
var patron = new Array(2,2,4);
var patron2 = new Array(2,2);
var patron3 = new Array(2,3,3);
var patron4 = new Array(3,3,3);
var patron5 = new Array(9);
var patron6 = new Array(3,4);
var patron7 = new Array(9,1);
var patron8 = new Array(5,5);
var patron9 = new Array(1,10);
var patron10 = new Array(4,7);
var patron11 = new Array(20,1);
var patron12 = new Array(2,4);
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
    val = d.value
    largo = val.length
    val = val.split(sep)
    val2 = ''
    for(r=0;r<val.length;r++){
        val2 += val[r]
    }
    if(nums){
        for(z=0;z<val2.length;z++){
            if(isNaN(val2.charAt(z))){
                letra = new RegExp(val2.charAt(z),"g")
                val2 = val2.replace(letra,"")
            }
        }
    }
    val = ''
    val3 = new Array()
    for(s=0; s<pat.length; s++){
        val3[s] = val2.substring(0,pat[s])
        val2 = val2.substr(pat[s])
    }
    for(q=0;q<val3.length; q++){
        if(q ==0){
            val = val3[q]
        }
        else{
            if(val3[q] != ""){
                val += sep + val3[q]
                }
        }
    }
    d.value = val
    d.valant = val
    }
}
//FIN MASCARA DE CAMPOS CON CONDICIONES ESPECIALES