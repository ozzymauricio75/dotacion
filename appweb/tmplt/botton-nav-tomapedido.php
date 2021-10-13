<?php 
$catalogo = "";
$cliente = "";
if(isset($actiSecc) && $actiSecc != ""){
    switch($actiSecc){
        case "catalogo":
            $catalogo = "activade";
        break;
        case "cliente":
            $cliente = "activade";
        break;
    }
}

$bootNav ="<section>";
$bootNav .="<nav class='navbar-fixed-bottom bottonnav'>";
$bootNav .="<div class='links-mm-bar-justified'>";
$bootNav .="<a href='".$pathmm ."takeorder/browse/' class='".$catalogo."'>
                <i class='fa fa-th-list'></i>
                <span>Catalogo</span>                        
            </a>";
                        
$bootNav .="<a href='".$pathmm ."takeorder/client/' class='".$cliente."'>
                <i class='fa fa-user'></i>
                <span>Tercero</span>                     
            </a>";
$bootNav .="<a href='#' data-toggle='control-sidebar'>
                <i class='fa fa-file'></i>
                <span>Pedido</span>                     
            </a>";                        
$bootNav .="</div>";      
$bootNav .="</nav>";
$bootNav .="</section>";
echo $bootNav;