<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class common{
    //
    //HEAD
    //
    function head(){
       include 'head.php';
    }
    //
    //ACCIONES DEL ENCABEZADO
    //
    function header(){
        $resp = '
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>TEXTRONIC</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <!--<li class="dropdown" style>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme-baged">4</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 4 pending tasks</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">DashGum Admin Panel</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Database Update</div>
                                        <div class="percent">60%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Product Development</div>
                                        <div class="percent">80%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">Payments Sent</div>
                                        <div class="percent">70%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                            <span class="sr-only">70% Complete (Important)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="external">
                                <a href="#">See All Tasks</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- settings end -->
                    <!-- inbox dropdown start-->
                    <!--<li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-theme-baged">5</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 5 new messages</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Zac Snider</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hi mate, how is everything?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-divya.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Divya Manian</span>
                                    <span class="time">40 mins.</span>
                                    </span>
                                    <span class="message">
                                     Hi, I need your help with this.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-danro.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dan Rogers</span>
                                    <span class="time">2 hrs.</span>
                                    </span>
                                    <span class="message">
                                        Love your new Dashboard.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-sherman.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dj Sherman</span>
                                    <span class="time">4 hrs.</span>
                                    </span>
                                    <span class="message">
                                        Please, answer asap.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">See all messages</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="/cat/common/stop_sesion.php">Logout</a></li>
                </ul>
            </div>
        </header>
        ';
        echo $resp;
    }
    //
    //MENU
    //
    function left_sidebar($act){
        include ('nav.php');
//        $opc_nav = $this->opc_nav();
        $resp = '
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <div class="centered"><a href="profile.html"><img src="../../assets/img/logo.png"  width="200px"></a></div>
                    <h5 class="centered"></h5>';
        foreach($opc_nav as $on){
            if(basename($act) == $on['1']){ $class_act = 'class="active"'; }else{ $class_act = ''; }
//            $link = 'init.php?vw='.$on['1'];
            $link = $on['1'];
        $resp.= '            
                    <li class="sub-menu ">
                        <a '.$class_act.' href="'.$link.'">
                            <i class="'.$on['2'].'"></i>
                            <span>'.$on['0'].'</span>
                        </a>
                    </li>';
        }
        $resp.= '
                </ul>
            </div>
        </aside>
        ';
        echo $resp;
    }
    //
    //CONTENIDO HTML
    //
    function body($dir){
        if($dir ==''){
            echo '
            <section id="main-content">
                <section class="wrapper">
                    <div class="row"><div class="col-sm-12">NADA</div></div>
                </section>
            </section>';
        }else{
            if($dir != 'init.php'){
                include $dir;
            }
        }
            
    }
    //
    //NOTIFICACIONES
    //
    function right_sidebar($val = TRUE){
        if($val){
            $resp = '
            <div class="col-lg-3 ds">
                <!--COMPLETED ACTIONS DONUTS CHART-->
                <h3>NOTIFICATIONS</h3>

                <!-- First Action -->
                <div class="desc">
                  <div class="thumb">
                          <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                          <p><muted>2 Minutes Ago</muted><br/>
                             <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                          </p>
                  </div>
                </div>
                <!-- Second Action -->
                <div class="desc">
                  <div class="thumb">
                          <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                          <p><muted>3 Hours Ago</muted><br/>
                             <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                          </p>
                  </div>
                </div>
                <!-- Third Action -->
                <div class="desc">
                  <div class="thumb">
                          <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                          <p><muted>7 Hours Ago</muted><br/>
                             <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                          </p>
                  </div>
                </div>
                <!-- Fourth Action -->
                <div class="desc">
                  <div class="thumb">
                          <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                          <p><muted>11 Hours Ago</muted><br/>
                             <a href="#">Mark Twain</a> commented your post.<br/>
                          </p>
                  </div>
                </div>
                <!-- Fifth Action -->
                <div class="desc">
                  <div class="thumb">
                          <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                          <p><muted>18 Hours Ago</muted><br/>
                             <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                          </p>
                  </div>
                </div>

                 <!-- USERS ONLINE SECTION -->

                <!-- CALENDAR-->
                <div id="calendar" class="mb">
                    <div class="panel green-panel no-margin">
                        <div class="panel-body">
                            <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                                <div class="arrow"></div>
                                <h3 class="popover-title" style="disadding: none;"></h3>
                                <div id="date-popover-content" class="popover-content"></div>
                            </div>
                            <div id="my-calendar"></div>
                        </div>
                    </div>
                </div><!-- / calendar -->
            </div>
            ';
            echo $resp;
        }
    }
    //
    //INCLUYE ARCHIVOS JAVASCRIT GENERALES
    //
    function script(){
        include 'script.php';
    }
    //
    //FOOTER
    //
    function footer(){
        $resp = '
            <footer class="site-footer">
            <div class="text-center">
                <a href="#" class="go-top">
                    <i class="fa fa-angle-up"></i>
                </a>
            </div>
        </footer>
        ';
        echo $resp;
    }
}