<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-users.php'; ?>
<?php require_once '../appweb/inc/query-levels.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>
<?php 

//***********
//DEFINE CANCEL - TRASH EVENT
//***********
$statusCancel = "";
if(isset($_GET['trash']) && $_GET['trash'] == "ok"){ 
    
    if(isset($_GET['coditemget'])){
        
        $itemVarGET = (int)$_GET['coditemget'];
        $itemVarGET = $db->escape($itemVarGET);

        /*//ELIMINAR ESPECIFICACIONES COLOR    
        $fieldColorTBL = "id_producto";  
        $tblColorTBL = "especifica_product_tipo_color";      
        $trashColorItem = deleteFieldDB($itemVarGET, $fieldColorTBL, $tblColorTBL);

        //ELIMINAR ESPECIFICACIONES TALLAS    
        $fieldTallaTBL = "id_producto";  
        $tblTallaTBL = "especifica_grupo_talla";      
        $trashTallaItem = deleteFieldDB($itemVarGET, $fieldTallaTBL, $tblTallaTBL);

        //ELIMINAR ESPECIFICACIONES MATERIALES    
        $fieldMaterTBL = "id_producto";  
        $tblMaterTBL = "especifica_prod_material";     
        $trashMaterItem = deleteFieldDB($itemVarGET, $fieldMaterTBL, $tblMaterTBL);*/

        //ELIMINAR ITEM
        $fieldItemTBL = "id_account_empre";  
        $tblItemTBL = "account_empresa";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
                
}


//***********
//ESPECIFICACIONES ITEM REFERENCIA
//***********
$itemVarGET = "";
if(isset($_GET['coditemget'])){

    $itemVarGET = (int)$_GET['coditemget'];
    $itemVarGET = $db->escape($itemVarGET);
            
}

//***********
//INFO ITEM
//***********
$detallesItem = array();
$detallesItem = queryUsersEdit($itemVarGET);

if(is_array($detallesItem)){
    foreach($detallesItem as $diKey){   
        
        
        /*
        *SOBRE EL SUSUARIO
        */
        $colectionUser = $diKey['colectionuser'];
        $idCompany = $diKey['id_account_empre'];
        $idItem = $diKey['id_account_user'];
        $statusItem = $diKey['estado_cuenta'];               
        $nameItem = $diKey['nombre_account_user'];
        $nitItem = $diKey['cedula_user'];        
        $emailItem = $diKey['mail_account_user'];
        $tel1Item = $diKey['tel_account_user'];
        $tel2Item = $diKey['tel_account_user2'];
        $dirItem  = $diKey['dir_account_user'];
        $cityItem  = $diKey['ciudad_account_user'];
        $fotoItem = $diKey['foto_user']; 
            
        $dateRegisItem  = $diKey['fecha_alta_account_user'];
        
        $userItem  = $diKey['account_pseudo_user'];
        $passItem  = $diKey['pass_human'];
        
        $dataStore  = $diKey['datastore'];
        $dataPacKitUser  = $diKey['datapackit'];
        
        
        /*
        *INFO EMPRESA
        */
        $companyLayout = "";
        if(is_array($dataStore) && count($dataStore)>0){
            foreach($dataStore as $dsKey){
                //id_account_empre, nombre_account_empre, nit_empresa, logo_account_empre, mail_account_empre, tel_account_empre1, dir_account_empre, ciudad_account_empre
                $nameCompany = $dsKey['nombre_account_empre'];                
                $emailCompany = $dsKey['mail_account_empre'];
                $telCompany = $dsKey['tel_account_empre1'];
                $dirCompany = $dsKey['dir_account_empre'];
                $cityCompany = $dsKey['ciudad_account_empre'];
                
                
                $companyLayout .= "<div class=' well well-sm'>";
                $companyLayout .= "<strong>".$nameCompany."</strong>";
                $companyLayout .= "<p>".$emailCompany." | ".$telCompany."</p>";
                $companyLayout .= "<p>".$dirCompany." | ".$cityCompany."</p>";
                $companyLayout .= "</div>";
                
            }
        }
        
        /*
        *INFO DOTACIONES
        */
        
        $dpKitLayout = "";
        /*$nameCategoKit ="";
        $nameSubCategoKit = "";
        $colectionKit = "";
        if(is_array($dataPacKitUser) && count($dataPacKitUser)>0){
            foreach($dataPacKitUser as $duKey){
                $nameKit = $duKey['kit'];
                $cantPzasKit = $duKey['cant_pz_kit'];
                $colectionKit = $duKey['tags_depatament_produsts'];                
                $nameCat = $duKey['nome_catego_product'];
                $dataCatKit= $duKey['datacategos'];
                $dataSubCatKit = $duKey['datasubcategos'];
                
                if(is_array($dataCatKit)){
                    foreach($dataCatKit as $dckKey){
                        $nameCategoKit = $dckKey['nome_catego_product'];                        
                    }
                }
                
                if(is_array($dataSubCatKit)){
                    foreach($dataSubCatKit as $dsckKey){
                        $nameSubCategoKit = $dataSubCatKit['nome_subcatego_producto'];                        
                    }
                }
                
                
                $dpKitLayout .= "<div class='img-thumbnail padd-verti-xs padd-hori-xs'>";
                $dpKitLayout .= "<strong class='txtCapitalice'>".$nameKit."<span class='badge bg-red margin-left-xs'>".$cantPzasKit."Pza</span></strong>";
                $dpKitLayout .= "<p class='txtCapitalice'>".$colectionKit;                
                if($nameCategoKit != ""){
                    $dpKitLayout .= " > ".$nameCategoKit;                    
                }else{
                    $dpKitLayout .= " > ".$nameCat;                    
                }
                if($nameSubCategoKit  != ""){
                    $dpKitLayout .= " > ".$nameSubCategoKit;                    
                }
                
                $dpKitLayout .= "</p>";                                
                $dpKitLayout .= "</div>";
                
            }
        }*/
                                    
    }//fin foreach
    
    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathPortada = "../../appweb/files-display/users/".$fotoItem;

    if (file_exists($pathPortada)) {
    $portadaFile = $pathPortada;
        } else {
    $portadaFile = $pathFileDefault;
    }    
    
}
//echo "<pre>";
//print_r($dataPacKitUser);
//***********
//KITS DOTACIONES REGISTRADAS PARA EL USUARIO
//***********

//$printDOT = array();
//$printDOT = $dataPacKitUser;//getLevelsList();


//***********
//ESQUEMA CATGEGORIAS DOTACION ROPA
//***********

$lyBrowseCatDOT = "";

if(is_array($dataPacKitUser) && !empty($dataPacKitUser)){

$lyBrowseCatDOT .="<div class='box box50 padd-hori-md '>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul class='categoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     

        foreach($dataPacKitUser as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $nombrekitcatalogo = $pllKey['nombrekitcatalogo'];
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $lyBrowseCatDOT .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $lyBrowseCatDOT .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $lyBrowseCatDOT .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $lyBrowseCatDOT .= "<li style='margin-bottom:15px;'>";////wrap PACK DPTO      
                                    $lyBrowseCatDOT .= "<div class='row'><div class='col-xs-9'>";
                                    $lyBrowseCatDOT .= "<h3 class='no-padmarg' >";
                                    $lyBrowseCatDOT .= "<span >".$nameLevel1."</span>";
                                    $lyBrowseCatDOT .= "<small style='display:block;'>".$descriLevel1."</small>";
                                    $lyBrowseCatDOT .= "</h3>";
                                    $lyBrowseCatDOT .= "</div>";
                                    $lyBrowseCatDOT .= "<div class='col-xs-3 text-right'>";
                                    $lyBrowseCatDOT .= "</div></div>";                                    
                                    $lyBrowseCatDOT .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT   
                            
                            $nombreKitDot = "";
                            if($tagCC == "adicional"){
                                $nombreKitDot = $tagCC;
                            }else{
                                $nombreKitDot = $kitLevel2;    
                            }
                            
                            $lyBrowseCatDOT .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$nombrekitcatalogo."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $lyBrowseCatDOT .= "<li>";
                        $lyBrowseCatDOT .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $lyBrowseCatDOT .= "<div class='col-xs-7'>";
                        $lyBrowseCatDOT .= "<p class='no-padmarg'>";
                        $lyBrowseCatDOT .= "<strong>".$nameLevel2."</strong>";
                        $lyBrowseCatDOT .= "<span style='display:block;'>".$descriLevel2."</span>";
                        $lyBrowseCatDOT .= "</p>";
                        $lyBrowseCatDOT .= "</div>";//col-xs-7
                        
                        $lyBrowseCatDOT .= "<div class='col-xs-2'>";
                        $lyBrowseCatDOT .= "<span>".$pzsLevel2."</span>&nbsp;Pzs";
                        $lyBrowseCatDOT .= "</div>";//col-xs-2
                        
                        $lyBrowseCatDOT .= "<div class='col-xs-3 text-right'>";
                        $lyBrowseCatDOT .= "</div>";//col-xs-3
                                                                        
                        $lyBrowseCatDOT .= "</div>";//wpeditl2_
                        $lyBrowseCatDOT .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $lyBrowseCatDOT .= "<li style='margin-top:10px; margin-bottom:10px;' >";
                            
                            $lyBrowseCatDOT .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $lyBrowseCatDOT .= "<div class='col-xs-9'>";
                            
                            $lyBrowseCatDOT .= "<div class='media no-padmarg'>";                                                                                    
                            $lyBrowseCatDOT .= "<div class='media-left'>";                            
                            $lyBrowseCatDOT .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $lyBrowseCatDOT .= "</div>";
                            $lyBrowseCatDOT .= "<div class='media-body'>";
                            $lyBrowseCatDOT .= "<h4 class='media-heading' >".$nameLevel3."</h4>";
                            $lyBrowseCatDOT .= "<span>".$descriLevel3."</span>";
                            $lyBrowseCatDOT .= "</div>";
                            $lyBrowseCatDOT .= "</div>";//wrap media
                            
                            $lyBrowseCatDOT .= "</div>";//col-xs-9
                            
                            $lyBrowseCatDOT .= "<div class='col-xs-3 text-right'>";
                            $lyBrowseCatDOT .= "</div>";//col-xs-3
                                                                                    
                            $lyBrowseCatDOT .= "</div>";//wpeditl3_                      
                                                                                    
                            $lyBrowseCatDOT .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
      

$lyBrowseCatDOT .="</ul>";
$lyBrowseCatDOT .="</div><!--//body-->";
$lyBrowseCatDOT .="</div><!--//CATALOGO-->";   
    
} 
                
///////////////////////////////////////////////////

//***********
//ESQUEMA CATGEGORIAS DOTACION ADICIONAL
//***********

$printDOT_add = array();
$printDOT_add = $dataPacKitUser;//getLevelsList();

$layoutAdicionalDOT = "";
$layoutAdicionalDOT .="<div class='box box75 padd-hori-md'>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul id='addcategoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     
    if(is_array($printDOT_add)){
        foreach($printDOT_add as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $layoutAdicionalDOT .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $layoutAdicionalDOT .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $layoutAdicionalDOT .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $layoutAdicionalDOT .= "<li style='margin-bottom:15px;'>";////wrap PACK DPTO
                                    $layoutAdicionalDOT .= "<div class='row'><div class='col-xs-9'>";                 
                                    $layoutAdicionalDOT .= "<h3 class='no-padmarg ' >";
                                    $layoutAdicionalDOT .= "<span >".$nameLevel1."</span>";
                                    $layoutAdicionalDOT .= "<small style='display:block;'>".$descriLevel1."</small>";
                                    $layoutAdicionalDOT .= "</h3>"; 
                                    $layoutAdicionalDOT .= "</div>";//col-9
                                    $layoutAdicionalDOT .= "<div class='col-xs-3 text-right'>";
                                    $layoutAdicionalDOT .= "</div></div>";//col-3
                                    $layoutAdicionalDOT .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $layoutAdicionalDOT .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $layoutAdicionalDOT .= "<li >";
                        $layoutAdicionalDOT .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $layoutAdicionalDOT .= "<div class='col-xs-7'>";
                        $layoutAdicionalDOT .= "<p class='no-padmarg'>";
                        $layoutAdicionalDOT .= "<strong >".$nameLevel2."</strong>";
                        $layoutAdicionalDOT .= "<span style='display:block;' >".$descriLevel2."</span>";
                        $layoutAdicionalDOT .= "</p>";
                        $layoutAdicionalDOT .= "</div>";
                        $layoutAdicionalDOT .= "<div class='col-xs-2'>";
                        $layoutAdicionalDOT .= "<span >1</span>&nbsp;Pzs";
                        $layoutAdicionalDOT .= "</div>";//col-xs-2
                        $layoutAdicionalDOT .= "<div class='col-xs-3 text-right'>";                  
                        $layoutAdicionalDOT .= "</div>";//col-xs-3
                                                                        
                        $layoutAdicionalDOT .= "</div>";//wpeditl2_
                                            
                        $layoutAdicionalDOT .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                           
                            
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $layoutAdicionalDOT .= "<li style='margin-top:10px; margin-bottom:10px;' >";
                            
                            $layoutAdicionalDOT .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $layoutAdicionalDOT .= "<div class='col-xs-9'>";
                            
                            $layoutAdicionalDOT .= "<div class='media no-padmarg'>";                                                                                    
                            $layoutAdicionalDOT .= "<div class='media-left'>";                            
                            $layoutAdicionalDOT .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $layoutAdicionalDOT .= "</div>";
                            $layoutAdicionalDOT .= "<div class='media-body'>";
                            $layoutAdicionalDOT .= "<h4 class='media-heading' >".$nameLevel3."</h4>";
                            $layoutAdicionalDOT .= "<span >".$descriLevel3."</span>";
                            $layoutAdicionalDOT .= "</div>";
                            $layoutAdicionalDOT .= "</div>";//wrap media
                            
                            $layoutAdicionalDOT .= "</div>";//col-xs-9
                            
                            $layoutAdicionalDOT .= "<div class='col-xs-3 text-right'>";
                            $layoutAdicionalDOT .= "</div>";//col-xs-3
                                                                                    
                            $layoutAdicionalDOT .= "</div>";//wpeditl3_                      
                                                                                    
                            $layoutAdicionalDOT .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
    }   

$layoutAdicionalDOT .="</ul>";
$layoutAdicionalDOT .="</div><!--//body-->";
$layoutAdicionalDOT .="</div><!--//CATALOGO-->";




///////////////////////////////////////////////////
//////////////////////////////////////////////////

//***********
//KITS DOTACION DISPONIBLES PARA USUARIO
//***********

//***********
//ESQUEMA CATGEGORIAS DOTACION ROPA
//***********
$printLevelList = array();
$printLevelList = queryLevelsFull();//getLevelsList();

$lyBrowseCat = "";
$lyBrowseCat .="<div class='box box75 padd-hori-md '>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul class='categoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     
    if(is_array($printLevelList)){
        foreach($printLevelList as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $lyBrowseCat .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $lyBrowseCat .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $lyBrowseCat .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $lyBrowseCat .= "<li style='margin-bottom:15px;' id='wrapplevel1".$idLevel1."'>";////wrap PACK DPTO      
                                    $lyBrowseCat .= "<div class='row'><div class='col-xs-9'>";
                                    $lyBrowseCat .= "<h3 class='no-padmarg' id='wpeditl1_".$idLevel1."'>";
                                    $lyBrowseCat .= "<span id='wrappupdatenamel1".$idLevel1."'>".$nameLevel1."</span>";
                                    $lyBrowseCat .= "<small id='wrappupdatedescril1".$idLevel1."' style='display:block;'>".$descriLevel1."</small>";
                                    $lyBrowseCat .= "</h3>";
                                    $lyBrowseCat .= "</div>";
                                    $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                                    $lyBrowseCat .= "<input type='checkbox' value='root' class='simple boxnivel' id='box_dep_".$idLevel1 ."' /><label for='box_dep_".$idLevel1 ."'></label>";
                                    $lyBrowseCat .= "</div></div>";                                    
                                    $lyBrowseCat .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $lyBrowseCat .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $lyBrowseCat .= "<li id='wrapplevel2".$idLevel2."'>";
                        $lyBrowseCat .= "<div id='wpeditl2_".$idLevel2."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $lyBrowseCat .= "<div class='col-xs-7'>";
                        $lyBrowseCat .= "<p class='no-padmarg'>";
                        $lyBrowseCat .= "<strong id='wrappupdatenamel2".$idLevel2."'>".$nameLevel2."</strong>";
                        $lyBrowseCat .= "<span style='display:block;' id='wrappupdatesubnamel2".$idLevel2."'>".$descriLevel2."</span>";
                        $lyBrowseCat .= "</p>";
                        $lyBrowseCat .= "</div>";//col-xs-7
                        
                        $lyBrowseCat .= "<div class='col-xs-2'>";
                        $lyBrowseCat .= "<span id='wrappupdatepzsl2".$idLevel2."'>".$pzsLevel2."</span>&nbsp;Pzs";
                        $lyBrowseCat .= "</div>";//col-xs-2
                        
                        $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                        $lyBrowseCat .= "<input type='checkbox' value='' class='simple boxnivel' id='box_kit_".$idLevel2."' /><label for='box_kit_".$idLevel2."'></label>";
                        $lyBrowseCat .= "</div>";//col-xs-3
                                                                        
                        $lyBrowseCat .= "</div>";//wpeditl2_
                        $lyBrowseCat .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $lyBrowseCat .= "<li style='margin-top:10px; margin-bottom:10px;' id='wrapplevel3".$idLevel3."'>";
                            
                            $lyBrowseCat .= "<div id='wpeditl3_".$idLevel3."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $lyBrowseCat .= "<div class='col-xs-9'>";
                            
                            $lyBrowseCat .= "<div class='media no-padmarg'>";                                                                                    
                            $lyBrowseCat .= "<div class='media-left'>";                            
                            $lyBrowseCat .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $lyBrowseCat .= "</div>";
                            $lyBrowseCat .= "<div class='media-body'>";
                            $lyBrowseCat .= "<h4 class='media-heading' id='wrappupdatenamel3".$idLevel3."'>".$nameLevel3."</h4>";
                            $lyBrowseCat .= "<span id='wrappupdatedescril3".$idLevel3."'>".$descriLevel3."</span>";
                            $lyBrowseCat .= "</div>";
                            $lyBrowseCat .= "</div>";//wrap media
                            
                            $lyBrowseCat .= "</div>";//col-xs-9
                            
                            $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                            $lyBrowseCat .= "<input type='checkbox' name='' value='".$idLevel3."' class='simple boxnivel ropuserkit' id='box_prenda_".$idLevel3."' data-l2='".$idLevel2."' data-tagl1='".$tagLevel1."' data-idkit='".$idCC."' data-tkit='".$tagCC."' data-numepzs='".$pzsLevel2."' /><label for='box_prenda_".$idLevel3."'></label>";
                            $lyBrowseCat .= "</div>";//col-xs-3
                                                                                    
                            $lyBrowseCat .= "</div>";//wpeditl3_                      
                                                                                    
                            $lyBrowseCat .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
    }   

$lyBrowseCat .="</ul>";
$lyBrowseCat .="</div><!--//body-->";
$lyBrowseCat .="</div><!--//CATALOGO-->";
                
///////////////////////////////////////////////////

//***********
//ESQUEMA CATGEGORIAS DOTACION ADICIONAL
//***********


$printLevelList_add = array();
$printLevelList_add = queryLevelsFull();//getLevelsList();

$layoutAdicional = "";
$layoutAdicional .="<div class='box box75 padd-hori-md'>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul id='addcategoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     
    if(is_array($printLevelList_add)){
        foreach($printLevelList_add as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $layoutAdicional .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $layoutAdicional .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $layoutAdicional .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $layoutAdicional .= "<li style='margin-bottom:15px;' id='wrappadd1".$idLevel1."'>";////wrap PACK DPTO
                                    $layoutAdicional .= "<div class='row'><div class='col-xs-9'>";                 
                                    $layoutAdicional .= "<h3 class='no-padmarg ' id='wpeditl1_".$idLevel1."'>";
                                    $layoutAdicional .= "<span >".$nameLevel1."</span>";
                                    $layoutAdicional .= "<small style='display:block;'>".$descriLevel1."</small>";
                                    $layoutAdicional .= "</h3>"; 
                                    $layoutAdicional .= "</div>";//col-9
                                    $layoutAdicional .= "<div class='col-xs-3 text-right'>";
                                    //$layoutAdicional .= "<input type='checkbox' value='root' class='simple boxnivel' id='box_add_dep_".$idLevel1 ."' /><label for='box_add_dep_".$idLevel1 ."'></label>";
                                    $layoutAdicional .= "</div></div>";//col-3
                                    $layoutAdicional .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $layoutAdicional .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $layoutAdicional .= "<li id='wrappadd2".$idLevel2."'>";
                        $layoutAdicional .= "<div id='wpeditl2_".$idLevel2."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $layoutAdicional .= "<div class='col-xs-7'>";
                        $layoutAdicional .= "<p class='no-padmarg'>";
                        $layoutAdicional .= "<strong >".$nameLevel2."</strong>";
                        $layoutAdicional .= "<span style='display:block;' >".$descriLevel2."</span>";
                        $layoutAdicional .= "</p>";
                        $layoutAdicional .= "</div>";
                        $layoutAdicional .= "<div class='col-xs-2'>";
                        $layoutAdicional .= "<span >1</span>&nbsp;Pzs";
                        $layoutAdicional .= "</div>";//col-xs-2
                        $layoutAdicional .= "<div class='col-xs-3 text-right'>";
                        //$layoutAdicional .= "<input type='checkbox' value='' class='simple boxnivel' id='box_add_kit_".$idLevel2."' /><label for='box_add_kit_".$idLevel2."'></label>";                        
                        $layoutAdicional .= "</div>";//col-xs-3
                                                                        
                        $layoutAdicional .= "</div>";//wpeditl2_
                                            
                        $layoutAdicional .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                             $tipoColeccioinL1_add = $l3Key['tags_depatament_produsts'];
                            //DEFINE TIPO DE KIT ADICIONAL
                            $idAdicionalHM = "";
                            if($tipoColeccioinL1_add == "masculino"){
                            	$idAdicionalHM = "4";
                            }else if($tipoColeccioinL1_add == "femenino"){
                            	$idAdicionalHM = "10";
                            }
                            
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $layoutAdicional .= "<li style='margin-top:10px; margin-bottom:10px;' id='wrappadd3".$idLevel3."'>";
                            
                            $layoutAdicional .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $layoutAdicional .= "<div class='col-xs-9'>";
                            
                            $layoutAdicional .= "<div class='media no-padmarg'>";                                                                                    
                            $layoutAdicional .= "<div class='media-left'>";                            
                            $layoutAdicional .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $layoutAdicional .= "</div>";
                            $layoutAdicional .= "<div class='media-body'>";
                            $layoutAdicional .= "<h4 class='media-heading' >".$nameLevel3."</h4>";
                            $layoutAdicional .= "<span >".$descriLevel3."</span>";
                            $layoutAdicional .= "</div>";
                            $layoutAdicional .= "</div>";//wrap media
                            
                            $layoutAdicional .= "</div>";//col-xs-9
                            
                            $layoutAdicional .= "<div class='col-xs-3 text-right'><input type='checkbox' name='' value='".$idLevel3."' class='simple boxnivel adduserkit' id='box_add_prenda_".$idLevel3."' data-l2='".$idLevel2."' data-tagl1='".$tagLevel1."' data-idkit='".$idAdicionalHM."' data-tkit='adicional' data-numepzs='1' /><label for='box_add_prenda_".$idLevel3."' ></label>";
                            $layoutAdicional .= "</div>";//col-xs-3
                                                                                    
                            $layoutAdicional .= "</div>";//wpeditl3_                      
                                                                                    
                            $layoutAdicional .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
    }   

$layoutAdicional .="</ul>";
$layoutAdicional .="</div><!--//body-->";
$layoutAdicional .="</div><!--//CATALOGO-->";


//$layoutAdicional = $lyBrowseCat;


//***********
//SITE MAP
//***********

$rootLevel = "usuarios";
$sectionLevel = "lista";
$subSectionLevel = "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo METATITLE ?></title>    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>        
    <?php echo _FAVICON_TOUCH_ ?>    
        
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../appweb/plugins/iCheck/all.css">   
    <!---switchmaster--->    
    <link rel="stylesheet" href="../appweb/plugins/switchmaster/css/bootstrap3/bootstrap-switch.min.css">
    <!--jquery bonsai--->
    <link rel="stylesheet" href="../appweb/plugins/jquery-bonsai/jquery.bonsai.css">
    <style type="text/css">
        /*** custom checkboxes http://codepen.io/jamesbarnett/pen/yILjk ***/

        input[type=checkbox].boxnivel { display:none; } /* to hide the checkbox itself */
        input[type=checkbox].boxnivel + label:before {
          font-family: FontAwesome;
          font-size:15px;
          color:#444;
          display: inline-block;
        }

        input[type=checkbox].boxnivel + label:before { content: "\f096"; } /* unchecked icon */
        input[type=checkbox].boxnivel + label:before { letter-spacing: 10px; } /* space between checkbox and label */

        input[type=checkbox].boxnivel:checked + label:before { content: "\f046"; } /* checked icon */
        input[type=checkbox].boxnivel:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */

    </style>
    
</head>
    
<?php echo LAYOUTOPTION ?><!---//print body tag--->    

    
<div class="wrapper">            
    <?php
    /*
    /
    ////HEADER
    /
    */
    ?>
    <?php include '../appweb/tmplt/header.php';  ?>           
    <?php
    /*
    /
    ////SIDEBAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/side-mm.php';  ?>
    <?php
    /*
    /
    ////WRAP CONTENT
    /
    */
    ?>        
    <div class="content-wrapper">
        <?php
        /*
        /*****************************//*****************************
        /HEADER CONTENT
        /*****************************//*****************************
        */
        ?>
        <section class="content-header bg-content-header">
                                    
            <h1>
            <small>Usuarios </small> / Detalles
            </h1>
            <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de empresas
            </a>                                    
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        <?php if(!$statusCancel){ ?>
        <section class="content ">

            <div class="box75 padd-bottom-lg">
                <?php
                /*
                /*
                /*EMPRESA - TIPO CATALOGO
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Generalidades</h4>
                        <p class="help-block">Valida la empresa a la que pertenece este usuario, y define el tipo de catálogo al que accederá el usuario (CATALOGO MASCULINO - CATALOGO FEMENINO)</p>
                    </div>
                    <div class="col-xs-12 col-sm-8 ">
                        
                        <?php
                        /*
                        /*
                        /*EMPRESA USUARIO
                        /*
                        */
                        ?>
                        <div class="form-group">
                            <?php echo $companyLayout; ?>
                        </div>
                        
                        <?php
                        /*
                        /*
                        /*COLECCION USUARIO
                        /*
                        */
                        ?>
                        <div class="form-group">
                            <h4>Tipo Colección</h4> 
                            
                            <select class="form-control infoedit" name="colectionuser" data-post="<?php echo $itemVarGET; ?>" data-field="colectionuserform">
                                <option value="" selected>Selecciona una opcion</option> 
                                <?php 
                                //SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1
                                $colectionLyt = "";
                                $db->orderBy("nome_clean_depa_prod","Asc");			
                                $coleccionQuery = $db->get('departamento_prods');                        
                                if(is_array($coleccionQuery)) {
                                    foreach($coleccionQuery as $cqKey){
                                        $idColeccionTbl = $cqKey['id_depart_prod'];
                                        $nameColeccionTbl = $cqKey['nome_depart_prod'];                                

                                        $actiColeccion = "";
                                        if($idColeccionTbl === $colectionUser)
                                            $actiColeccion = "selected";

                                        //$statusLayaout .= "<p>";
                                        //$statusLayaout .= "<label>";
                                        $colectionLyt .= "<option value='".$idColeccionTbl."' class='flat-red coleccionuser' ".$actiColeccion."> ";
                                        //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                        $colectionLyt .= $nameColeccionTbl;
                                        $colectionLyt .= "</option>";
                                        //$statusLayaout .= "</p>";                                                                
                                    }                                                    
                                }   
                                echo $colectionLyt;

                                ?>                                                               
                            </select>  
                            <div id="errcolectionuserform"></div>
                        </div>
                    </div>  
                    <hr class="linesection"/>
                </div>
                                                                              
                <?php
                /*
                /*
                /*INFORMACION PERSONAL
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información personal</h4>
                        <p class="help-block"></p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        
                        <div id="nameitemform" class="form-group">                        
                            <label>Nombre</label>
                            <input type="text" name="namestore" value="<?php echo $nameItem; ?>" class="form-control infoedit" placeholder="Nombre comercial / Razon social" data-post="<?php echo $itemVarGET; ?>" data-field="nameitemform" />
                        </div> 
                        <div id="errnameitemform"></div>                    

                        <div id="ceduitemform" class="form-group">                        
                            <label>Cedula</label>
                            <input type="text" name="nitstore" value="<?php echo $nitItem; ?>" class="form-control infoedit" placeholder="Cedula / Identificación" data-post="<?php echo $itemVarGET; ?>" data-field="ceduitemform" />
                        </div> 
                        <div id="errceduitemform"></div>

                        <div id="tel1itemform" class="form-group">                        
                            <label>Teléfono</label>
                            <input type="text" name="landlinestore" value="<?php echo $tel1Item; ?>" class="form-control infoedit" placeholder="Número teléfono fijo" data-post="<?php echo $itemVarGET; ?>" data-field="tel1itemform" />
                        </div> 
                        <div id="errtel1itemform"></div>

                        <div id="tel2temform" class="form-group">                        
                            <label>Celular / Teléfono</label>
                            <input type="text" name="cellstore" value="<?php echo $tel2Item; ?>" class="form-control infoedit" placeholder="Número teléfono celular" data-post="<?php echo $itemVarGET; ?>" data-field="tel2itemform" />
                        </div> 
                        <div id="errtel2temform"></div>

                        <div id="emailitemform" class="form-group">                        
                            <label>Email</label>
                            <input type="text" name="emailstore" value="<?php echo $emailItem; ?>" class="form-control infoedit" placeholder="Cuenta Email" data-post="<?php echo $itemVarGET; ?>" data-field="emailitemform" />
                        </div> 
                        <div id="erremailitemform"></div>

                        <div class="form-group">                        
                            <label>Dirección</label>
                            <div id="diritemform">
                                <input type="text" name="addressstore" value="<?php echo $dirItem; ?>" class="form-control infoedit" placeholder="Dirección comercial" data-post="<?php echo $itemVarGET; ?>" data-field="diritemform" />
                            </div>
                        </div>
                        <div id="errdiritemform"></div>
                        
                        <div class="form-group">
                            <label>Ciudad</label>
                            <div id="cityitemform">
                                <input type="text" name="citystore" value="<?php echo $cityItem; ?>" class="form-control infoedit" placeholder="Ciudad - Departamento" data-post="<?php echo $itemVarGET; ?>" data-field="cityitemform" />
                            </div>
                        </div>                         
                        <div id="errcityitemform"></div>

                    </div>      
                    <hr class="linesection"/>
                </div>
                                
                <?php
                /*
                /*
                /*INFORMACION CUENTA LOGIN
                /*
                */
                ?>                                                                                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información de cuenta</h4>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-xs-12 col-sm-8  padd-bottom-xs">
                        <div id="useritemform" class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                            <input type="text" name="userstore" value="<?php echo $userItem; ?>" class="form-control infoedit" placeholder="Nombre de usuario" maxlength="12" data-post="<?php echo $itemVarGET; ?>" data-field="useritemform" />                        
                        </div>
                        <div id="erruseritemform"></div>

                        <div id="passitemform" class="input-group">
                            <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                            <input type="text" name="passstore" value="<?php echo $passItem; ?>" class="form-control infoedit" placeholder="Contraseña" maxlength="12" data-post="<?php echo $itemVarGET; ?>" data-field="passitemform"  />                        
                        </div>
                        <div id="errpassitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>
                
                <?php
                /*
                /*
                /*INFORMACION SOBRE KITS DOTACION
                /*
                */
                ?>
                <div class="form-group wefield" id="wpkdfield">
                    <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="kdfield"> 
                        <i class="fa fa-pencil"></i>
                    </button>
                    <?php if($lyBrowseCatDOT == ""){ ?> 
                    <div class="row">
                    <div class="form-group">
                        <div class="alert no-padmarg box25">
                            <div class="media">
                                <div class=" media-left">
                                    <i class="fa fa-bell-o fa-3x text-blue"></i>
                                </div>
                                <div class="media-body">                                        
                                    <p style="font-size:1.232em;">No se ha definido kits de dotación para este usuario</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <?php }else{ ?>
                    <div class="row  margin-bottom-md">
                    <?php echo $lyBrowseCatDOT; ?>
                    </div>
                    <?php } ?>
                    <hr class="linesection"/>
                </div>
                <div class="form-group wefield" id="wekdfield">
                    <form method="post" enctype="text/plain" id="newitem" autocomplete="off"> 
                    <div id="colectionuserform">
                        <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn catecancelbtn" data-this="kdfield"> 
                            <i class="fa fa-times"></i> Cerrar
                        </button>

                        <?php
                        /*
                        /*
                        /*OPCIONES KITS  DOTACION   ***ROPA
                        /*
                        */
                        ?>
                        <div class="row wrapdivsection">
                            <div class="col-xs-2 col-sm-3">
                                <input id="switchropa" type="checkbox" name="" data-switch-value="mini" class="opcikit">
                            </div>
                            <div class="col-xs-10 col-sm-9">
                                <h3 class="no-padmarg">
                                    Kit dotación                            
                                </h3>
                                <span class="help-block  margin-bottom-md">Asignarle este kit al usuario</span>

                                <div id="wrapkitropa" class="row margin-bottom-md"><?php echo $lyBrowseCat; ?></div><!---/FIN WRAPP KIT ROPA--->
                            </div>
                            <hr class="linesection"/>
                        </div>
                        
                        <?php
                        /*
                        /*
                        /*OPCIONES KITS  DOTACION   ***UNITARIO
                        /*
                        */
                        ?>
                        <div class="row wrapdivsection">
                            <div class="col-xs-2 col-sm-3">
                                <input id="switchadd" type="checkbox" name="" data-switch-value="mini" class="opcikit">
                            </div>
                            <div class="col-xs-10 col-sm-9">
                                <h3 class="no-padmarg">
                                    Kit Unitario                            
                                </h3>
                                <span class="help-block  margin-bottom-md">Asignarle este kit al usuario</span>

                                <div id="wrapkitadd" class="row margin-bottom-md"><?php echo $layoutAdicional; ?></div><!---/FIN WRAPP KIT ADICIONAL--->
                            </div>
                            <hr class="linesection"/>
                        </div>


                        <div class="row wrapdivsection">
                            <div id="wrapadditem"></div>
                            <div id="erradditem"></div> 
                            <div class="col-xs-12 text-right padd-bottom-xs">
                                <button type="button" class="btn btn-info margin-hori-xs" id="additembtn">
                                    <i class='fa fa-save fa-lg margin-right-xs'></i>
                                    <span>Guardar kit</span>                     
                                </button>  
                            </div>
                            <input name="newprod" type="hidden" value="ok">
                            
                            <input type="hidden" name="colectioncheck" id="colectioncheck" value="<?php echo $colectionUser; ?>"> 
                            <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>"> 
                            <hr class="linesection"/>
                        </div>
                        
                    </div>
                    </form>
                </div>
                
                
                <?php
                /*
                /*
                /*STATUS USUARIO
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Status</h4>                        
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="statusitemform" class="form-group">
                            <select class="form-control infoedit" name="categoitem" data-post="<?php echo $itemVarGET; ?>" data-field="statusitemform">
                                    <option value="" selected>Selecciona una opcion</option> 
                        <?php 
                                
                        $statusLayaout = "";
                        
                        $db->where ('id_estado_contrato', '3', '!=');
                        $db->where ('id_estado_contrato', '4', '!=');
                        $db->where ('id_estado_contrato', '6', '!=');
                        $db->orderBy("nome_estado_contrato","Asc");			
                        $statusQuedy = $db->get('estado_contrato');                        
                        if(is_array($statusQuedy)) {
                            foreach($statusQuedy as $sqKey){
                                $idStatusTbl = $sqKey['id_estado_contrato'];
                                $nameStatusTbl = $sqKey['nome_estado_contrato'];                                
                                
                                $actiStatus = "";
                                if($idStatusTbl === $statusItem)
                                    $actiStatus = "selected";
                                
                                //$statusLayaout .= "<p>";
                                //$statusLayaout .= "<label>";
                                $statusLayaout .= "<option value='".$idStatusTbl."' class='flat-red statusprod' ".$actiStatus."> ";
                                //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= $nameStatusTbl;
                                $statusLayaout .= "</option>";
                                //$statusLayaout .= "</p>";                                                                
                            }                                                    
                        }   
                        echo $statusLayaout;
                        
                        ?>                                                               
                        </div>  
                        <div id="errstatusitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">
                    <input type="hidden" name="labelitemform" id="labelitemform" value="<?php echo $fotoItem; ?>">
                    
                </div>
                            
            </div>

        </section>    
                        
        <?php
        /*
        /*****************************//*****************************
        /FOOTER CONTENT - BOTTOM NAV
        /*****************************//*****************************
        */
        ?>
        <section class="main-footer navbar-fixed-bottom bottonnav">
            <div id="wrapadditem"></div>
            <div id="erradditem"></div>       
            <nav class="">
                <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs">
                    <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" type="button" class="btn btn-default">
                        <i class='fa fa-th-list fa-lg'></i>
                        <span>lista de usuarios</span>                        
                    </a>                                         
                </div>
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">                    
                    <a href="<?php echo $pathmm.$admiDir."/users/item-edit.php?trash=ok&coditemget=".$itemVarGET; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para esta empresa, incluyendo usuarios registrados y pedidos realizados. Deseas continuar?" data-remsj="">
                        <i class='fa fa-trash fa-lg'></i>
                        <span>Eliminar</span>                        
                    </a>                                                                                                       
                </div>
            </nav>
        </section>
        
        
        <?php }else{ ?>
            
        <section class="content ">                    
            <div class="box50  padd-verti-lg">
                <div class="alert alert-dismissible bg-gray">
                    <div class="media">
                        <div class=" media-left">
                            <i class="fa fa-bell-o fa-4x text-blue"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="no-padmarg">Hola!</h3>
                            <p style="font-size:1.232em; line-height:1;">
                                Este item fue eliminado correctamente, que deseas hacer ahora?
                            </p>                            
                        </div>

                    </div>                    
                </div>
                <div class="margin-verti-xs">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group text-center">
                            <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" type="button" class="btn btn-default">
                                <i class='fa fa-th-list fa-lg'></i>
                                <span>lista de empresas</span>                        
                            </a> 
                        </div>
                    
                        <div class="btn-group text-center">                            
                            <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" type="button" class="btn btn-info ">
                                <i class='fa fa-plus fa-lg'></i>
                                <span>Nuevo empresa</span>                     
                            </a>                                                               
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        
        <?php } ?>
        
    </div>
    <?php
    /*
    /
    ////FOOTER
    /
    */
    ?>
    <?php //include 'appweb/tmplt/footer.php';  ?>
    
            
    <?php
    /*
    /
    ////RIGHT BAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/right-side.php';  ?>
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    <?php echo "<input id='typecolection' type='hidden' value='".$colectionKit."'/>"; ?>
        
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<script type="text/javascript" src="edit-item-functions.js"></script>    
<script type="text/javascript" src="edit-kits-functions.js"></script>    
    
<!--jquery bonsai--->
<script src="../appweb/plugins/jquery-bonsai/jquery.bonsai.js" type="text/javascript"></script>
<script src="../appweb/plugins/jquery-bonsai/jquery.qubit.js" type="text/javascript"></script>
    
<!---switchmaster---> 
<script src="../appweb/plugins/switchmaster/js/bootstrap-switch.min.js" type="text/javascript"></script> 

<!-- InputMask -->
<script src="../appweb/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {   
    /*var editlabel = $("#editlabel").hide();
    var wraplabel = $("#wraplabel").show();    
    
    $("#editlabelbtn").click(function(){
        wraplabel.hide();
        editlabel.show();        
    });
    
    $("#canceleditlabelbtn").click(function(){
        wraplabel.show();
        editlabel.hide();        
    });*/
    
    $(".wefield").hide();
    
    $('button.editfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.hide();
            wrapedit.show();
        });
        
        
    });
    
    $('button.canceleditfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.show();
            wrapedit.hide();
        });
        
        
    });
    
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
    //CARGA TIPO COLECCION USUARIO
    var tipoColection = $("#typecolection").val();
    $(".usercolection").find("input[type='radio'], input[type='checkbox']").attr('disabled',true); //usercolection' data-colection    
    $('.usercolection').each(function(k,v1) { 
        var dcolection = $(v1).attr("data-colection");

        if(tipoColection == dcolection){                
            $(".usercolection[data-colection='"+tipoColection+"']").find("input[type='radio'], input[type='checkbox']").attr('disabled',false);
        }
    });
    
        
});       
    
    
//checktree
    jQuery(function() {
        $('ul.categoesquema').bonsai({
            expandAll: false,
            checkboxes: true,
        });
    });

    //checktree
    jQuery(function() {
        $('ul#addcategoesquema').bonsai({
            expandAll: false,
            checkboxes: true,
        });
    });
    
    //GESTIONA KITS USUARIO
    //========switchmaster
    $(".opcikit").bootstrapSwitch();

    //========KIT DE ROPA 
    $("#wrapkitropa").hide();
    //$("#wrapkitropa").find("input[type='radio']").attr('disabled',true);
    $("#switchropa").on('switchChange.bootstrapSwitch', function(event, state) {
        if($(this).is(':checked')) {
            $("#wrapkitropa").show();            
        }else{
            $("#wrapkitropa").hide();            
        }
    });
    
    //========KIT DE ZAPATOS
    $("#wrapkitzapato").hide();     
    $("#switchzapato").on('switchChange.bootstrapSwitch', function(event, state) {
        if($(this).is(':checked')) {
            $("#wrapkitzapato").show();            
        }else{
            $("#wrapkitzapato").hide();            
        }
    });
    
    //========KIT ADICIONAL
    $("#wrapkitadd").hide();     
    $("#switchadd").on('switchChange.bootstrapSwitch', function(event, state) {
        if($(this).is(':checked')) {
            $("#wrapkitadd").show();            
        }else{
            $("#wrapkitadd").hide();            
        }
    });
</script>     
</body>
</html>

