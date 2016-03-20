<?php
    include '../../common/general.php';
    $obj_common = new common();
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
    //include '../../common/head.php';
    $obj_common->head();?>
    <body>

        <section id="container" >
            <!-- TOP BAR CONTENT & NOTIFICATIONS -->
            <?php $obj_common->header();?>

            <!-- MAIN SIDEBAR MENU -->
            <?php $obj_common->left_sidebar($_SERVER['PHP_SELF']);?></aside>

            <!-- MAIN CONTENT -->
            <section id="main-content">
                  <section class="wrapper" style="min-height:500px;">
                    <div class="row">
            <!--RIGHT SIDEBAR CONTENT--> 
                        <div class="col-lg-3 ds"><?php $obj_common->right_sidebar(FALSE);?></div>
                    </div>
                </section>
            </section>

            <!--FOOTER-->
            <?php $obj_common->footer();?>
        
        </section>
        <!--JAVASCRIPT GENERAL-->
        <?php $obj_common->script();?>
        
          <!--END SCRIPT-->
    </body>
</html>
