<?php 
$headerTakeOrder = "<header class='main-header'>";
    
    //<!-- Header Navbar: style can be found in header.less -->
$headerTakeOrder .= "<nav class='navbar navbar-static-top'>";
        
            //<!-- Logo -->
            //<a href='".$pathmm.$takeOrderDir."/inicio/' class='logo'>
$headerTakeOrder .= "<div class='logo'>      
            <!-- logo for regular state and mobile devices -->
            <!--<span class='logo-lg'>QUEST</span>-->
            <img src='".$pathmm."appweb/img/logo_final3.png' class='img-responsive'>
            </div> ";
        
            //<!-- search form -->
/*$headerTakeOrder .= "<form action='".$pathmm."takeorder/browse/' method='get' class='searchtop' id='searchbox'>
                <div class='input-group '>
                  <input type='text' name='search' class='form-control' placeholder='Nombre producto, referencia' id='txtkey'>
                      <span class='input-group-btn'>
                        <button type='submit' class='btn btn-flat' id='btn-search'><i class='fa fa-search'></i>
                        </button>
                      </span>
                </div>
                <input type='hidden' name='sb' value='ok'>
            </form>";  */  
//$headerTakeOrder .= "<img src='".$pathmm."appweb/img/logo_final3.png' class='logomob'>";
$headerTakeOrder .= "<div class='logomob padd-hori-xs'>";
$headerTakeOrder .= "<p class='no-padmarg infoctohead'>";
$headerTakeOrder .= "<span class='ichtel'><i class='fa fa-phone margin-right-xs'></i>(2) 489 5000</span>";
$headerTakeOrder .= "<span class='ichdive'> | </span>";
$headerTakeOrder .= "<span class='ichmail'><i class='fa fa-envelope-o margin-right-xs'></i>licitaciones@quest.com.co</span>";
$headerTakeOrder .= "</p>";
$headerTakeOrder .= "<span class='ichnit'>Nit. 805022296-8</span>";
$headerTakeOrder .= "</div>";
        
$headerTakeOrder .= "<div class='navbar-custom-menu'>";
$headerTakeOrder .= "<ul class='nav navbar-nav'>";
$headerTakeOrder .= "<li>";
$headerTakeOrder .= "<a href='#' data-toggle='control-sidebar'>
                        <i class='fa fa-shopping-cart'></i>                     
                    </a>";
$headerTakeOrder .= "</li>";            
               /* //<!-- Notifications: style can be found in dropdown.less --> printOrderListTmp()
$headerTakeOrder .= "<li class='dropdown notifications-menu'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                      <i class='fa fa-file-o'></i>
                      <span class='label label-warning'>".$totalCantOrderTmp."</span>
                    </a>";
$headerTakeOrder .= "<ul class='dropdown-menu'>";
$headerTakeOrder .= "<li class='header'>Tienes ".$totalCantOrderTmp." pedidos en proceso</li>";
$headerTakeOrder .= "<li>";//wrap pedidos notificaciones
                        //<!-- inner menu: contains the actual data -->
$headerTakeOrder .= "<ul class='menu'>";
$headerTakeOrder .= printOrderListTmp();                          
$headerTakeOrder .= "</ul>";//menu
$headerTakeOrder .= "</li>";//fin wrap pedidos notificaciones
//$headerTakeOrder .= "<li class='footer'><a href='#'>Ver todos</a></li>";
$headerTakeOrder .= "</ul>";//dropdown-menu
$headerTakeOrder .= "</li>";//dropdown notifications-menu*/
                  //<!-- User Account: style can be found in dropdown.less -->
$headerTakeOrder .= "<li class='dropdown user user-menu'>
                    <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                      <!--<img src='../../dist/img/user2-160x160.jpg' class='user-image' alt='User Image'>-->
                        <span class='fa-stack user-image'>
                          <i class='fa fa-circle fa-stack-2x'></i>
                          <i class='fa fa-user fa-stack-1x fa-inverse'></i>
                        </span>
                        <!--<i class='fa fa-user fa-lg '></i>-->
                      <span class='hidden-xs'>".$pseudoSSUser."</span>
                    </a>
                    <ul class='dropdown-menu'>
                      <!-- User image -->
                      <li class='user-header'>
                        <!--<img src='../../dist/img/user2-160x160.jpg' class='img-circle' alt='User Image'>-->
                          <span class='fa-stack fa-4x'>
                              <i class='fa fa-circle fa-stack-2x'></i>
                              <i class='fa fa-user fa-stack-1x fa-inverse'></i>
                            </span>

                        <p>
                          ".$nameSSUser."
                           <small>".$emailSSUser."</small> 
                        </p>
                      </li>
                      <!-- Menu Body
                      <li class='user-body'>
                        <div class='row'>
                          <div class='col-xs-4 text-center'>
                            <a href='#'>Followers</a>
                          </div>
                          <div class='col-xs-4 text-center'>
                            <a href='#'>Sales</a>
                          </div>
                          <div class='col-xs-4 text-center'>
                            <a href='#'>Friends</a>
                          </div>
                        </div>
                       
                      </li> -->
                      <!-- Menu Footer-->
                      <li class='user-footer'>
                        <!--<div class='pull-left'>
                          <a href='#' class='btn btn-default btn-flat'>Profile</a>
                        </div>-->
                        <div class='text-center'>
                          <a href='".$pathmm.$takeOrderDir."/logout/' class='btn btn-default btn-flat'>Salir</a>
                        </div>
                      </li>
                    </ul>
                  </li>";
                  
$headerTakeOrder .= "</ul>";
$headerTakeOrder .= "</div>";
$headerTakeOrder .= "</nav>";
$headerTakeOrder .= "</header>";

echo $headerTakeOrder;