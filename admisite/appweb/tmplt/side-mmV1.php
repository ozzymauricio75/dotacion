<?php //<!-- Left side column. contains the sidebar -->

$catalogo_root = "";
$catalogo_new = "";
$catalogo_list = "";

$pedido_root = "";

$empresa_root = "";

$user_root = "";
$user_new = "";
$user_list = "";

$custom_root = "";
$custom_level_prod = "";
$custom_feactures_prod = "";
$custom_sublevel_feacturesprod = "";
$custom_sublevel_levelsprod = "";

$custom_account = "";

switch($rootLevel){
    case "tienda":
        $catalogo_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="level"){
                $catalogo_list = "active";    
            }            
            if($sectionLevel=="new"){
                $catalogo_new = "active";    
            }            
        }
    break;
    case "pedidos":
        $pedido_root = "active";        
    break;
    case "empresa":
        $empresa_root = "active";    
    break;
    case "usuarios":
        $user_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="new"){
                $user_new = "active";    
            }
            if($sectionLevel=="lista"){
                $user_list = "active";    
            }            
        }
    break;
    case "usuarios":
        $user_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="new"){
                $user_new = "active";    
            }
            if($sectionLevel=="lista"){
                $user_list = "active";    
            }            
        }
    break;
    
    case "especificaciones":
        $custom_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="productos"){
                $custom_feactures_prod = "active";
                if(!empty($subSectionLevel)){
                    if($subSectionLevel == "customprod"){
                        $custom_sublevel_feacturesprod = "active";    
                    }
                    if($subSectionLevel == "customlevels"){
                        $custom_sublevel_levelsprod = "active";    
                    }
                    
                }
            }
            
        }
    break;
        
}

switch($rootLevel){
    case "tienda":
        $catalogo_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="list"){
                $catalogo_list = "active";    
            }
            if($sectionLevel=="new"){
                $catalogo_new = "active";    
            }
            if($sectionLevel=="itemedit"){
                $catalogo_itemedit = "active";    
            }
            if($sectionLevel=="listref"){
                $catalogo_ref = "active";    
            }
            if($sectionLevel=="ediref"){
                $catalogo_refedit = "active";    
            }
        }
    break;
    case "pedidos":
        $pedido_root = "active";
        if(!empty($sectionLevel)){
            if($sectionLevel=="lista"){
                $pedido_list = "active";    
            }
            if($sectionLevel=="orderdetalle"){
                $pedido_detalle = "active";    
            }
        }
    break;
        
}

$tmplSideAS = '<aside class="main-sidebar">';
    
$tmplSideAS .= '<section class="sidebar">';    
/*$tmplSideAS .= '<div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>';
      
$tmplSideAS .= '<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>';*/
      
$tmplSideAS .= '<ul class="sidebar-menu">';
//$tmplSideAS .= '<li class="header">MAIN NAVIGATION</li>';
/*$tmplSideAS .= '<li>
          <a href="../widgets.html">
            <i class="fa fa-home"></i> 
            <span>Home</span>            
          </a>
        </li>';*/
$tmplSideAS .= '<li class="treeview '.$catalogo_root.'">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> 
            <span>Catalogo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="'.$catalogo_new.'"><a href="'.$pathmm.$admiDir.'/tienda/new.php"><i class="fa fa-chevron-circle-right"></i> Publicar</a></li>
            <li class="'.$catalogo_list.'"><a href="'.$pathmm.$admiDir.'/tienda/"><i class="fa fa-chevron-circle-right"></i> Lista</a></li>
          </ul>
        </li>';
$tmplSideAS .= '<li class="treeview '.$pedido_root.'">
          <a href="'.$pathmm.$admiDir.'/orders/">
            <i class="fa fa-file"></i> 
            <span>Pedidos</span>            
          </a>
        </li>';

$tmplSideAS .= '<li class="treeview '.$empresa_root.'">
          <a href="'.$pathmm.$admiDir.'/company/">
            <i class="fa fa-file"></i> 
            <span>Empresas</span>            
          </a>
        </li>';

/*$tmplSideAS .= '<li class="treeview">
          <a href="#">
            <i class="fa fa-industry"></i>
            <span>Empresas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../charts/chartjs.html"><i class="fa fa-chevron-circle-right"></i> Publicar</a></li>
            <li><a href="../charts/morris.html"><i class="fa fa-chevron-circle-right"></i> Lista</a></li>            
          </ul>
        </li>';*/
$tmplSideAS .= '<li class="treeview '.$user_root.'">
          <a href="#">
            <i class="fa fa-user-circle-o"></i>
            <span>Funcionarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="'.$user_new.'"><a href="'.$pathmm.$admiDir.'/users/new.php"><i class="fa fa-chevron-circle-right"></i> Publicar</a></li>
            <li class="'.$user_list.'"><a href="'.$pathmm.$admiDir.'/users/"><i class="fa fa-chevron-circle-right"></i> Lista</a></li>            
          </ul>
        </li>';
/*$tmplSideAS .= '<li class="treeview">
          <a href="../widgets.html">
            <i class="fa fa-picture-o"></i> 
            <span>Albumes</span>            
          </a>
        </li>';
$tmplSideAS .= '<li class="treeview">
          <a href="#">
            <i class="fa fa-area-chart"></i>
            <span>Informes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../UI/general.html"><i class="fa fa-chevron-circle-right"></i> Pedidos</a></li>
            <li><a href="../UI/icons.html"><i class="fa fa-chevron-circle-right"></i> Clientes</a></li>            
          </ul>
        </li>';*/
$tmplSideAS .= '<li class="treeview '.$custom_root.'">
          <a href="#">
            <i class="fa fa-cog"></i>
            <span>Personalizar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="'.$custom_level_prod.'">
                <a href="">
                    <i class="fa fa-chevron-circle-right"></i> Productos
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                
                <ul class="treeview-menu">
                    
                    <li class="'.$custom_sublevel_prod.'"><a href="'.$pathmm.$admiDir.'/custom/prods/features/"><i class="fa fa-chevron-circle-right"></i> Especificaciones</a></li>
                    <li class="'.$custom_sublevel_levelsprod.'"><a href="'.$pathmm.$admiDir.'/custom/prods/levels/"><i class="fa fa-chevron-circle-right"></i> Categorías</a></li>
                </ul>
            </li>
                                    
            <!----<li class="'.$custom_level_prod.'"><a href="../UI/icons.html"><i class="fa fa-chevron-circle-right"></i> Cuenta</a></li>---
          </ul>
        </li>';

$tmplSideAS .= '</ul>';
$tmplSideAS .= '</section>';    
$tmplSideAS .= '</aside>';
echo $tmplSideAS;
/*
<li class="'.custom_sublevel_prod.'"><a href="'.$pathmm.$admiDir.'/custom/prods/levels/"><i class="fa fa-chevron-circle-right"></i> Categorías</a></li>
*/