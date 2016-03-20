<?php
    include '../../common/general.php';
    $obj_common = new common();
    $obj_function = new coFunction();
    $dir_act = $obj_function->evalua_array($_REQUEST,'vw');
//    $dir_act = $_SERVER['PHP_SELF'];
//    $e = 'HOLA';
//    $e = $obj_common->body('HOLA');
echo '
<!DOCTYPE html>
<html lang="en">
    '.$obj_common->head().'
    <body>
        <section id="container" >
            <!-- TOP BAR CONTENT & NOTIFICATIONS -->
            '.$obj_common->header().'
            <!-- MAIN SIDEBAR MENU -->
            <aside>'.$obj_common->left_sidebar($dir_act).'</aside>
            <!-- MAIN CONTENT -->
            '.$obj_common->body($dir_act).'
            <!--FOOTER-->
            '.$obj_common->footer().'
        
        </section>
        <!--JAVASCRIPT GENERAL-->
        '.$obj_common->script().'
    </body>
</html>
';