<?php

//SEGUIMIENTO PASOS COMPRA
/*
//
uno -> define ciudad
dos -> muestra packetes dotacion    
tres -> explora los paquetes ->KITS (catego)
    | kit ropa 
    | kit zapatos
cuatro -> explora los paquetes -> PRENDAS (subcatego)
    | prendas ropa 
    | prendas zapatos
    | prendas adicional
cinco -> explora los paquetes -> ITEMS - filtros (producto)
//
*/

$stepShopArr = array("uno", "dos", "tres", "cuatro", "cinco");
//recibe paso
if(isset($_GET['steps']) && $_GET['steps'] != ""){
    $ssGET = (string)$_GET['steps'];
}else{
    $ssGET = "uno"; 
}

foreach($stepShopArr as $ssKey){
    if($ssGET == $ssKey){
        $ssDef = $ssKey;
    }
    
}


//DEFINE OPCIONES DOTACION USUARIO
$tipoKitArr = array();
$packDotUser = array();
$db->where('id_account_user',$idSSUser);
$packDotacion = $db->get('pack_dotacion_user');
$itemPackDotacion = count($packDotacion);

/*if($itemPackDotacion > 0){
    foreach($packDotacion as $pdKey){
        $tipoKitArr[] = $pdKey;
        //$tipoKit = $pdKey['kit'];
        //$ifGIFTtipoKit = $pdKey['prenda'];
    }
}*/
//print_r($tipoKitArr);

//CUANTAS OPCIONES DOTACION
//PACK DOTACION = 1
//if($itemPackDotacion == 1){
    //muestra los kits FORMAL CLASICO SPORT
//}

$urlPrint = "";
$icoPrint = "";
$tituPrint  = "";

//PACK DOTACION > 1
if($itemPackDotacion > 0){
    //muestra los kits ROPA | ZAPATOS | ADICIONAL
        
    $layoutPackDotHome = "";    
    //$layoutPackDotHome .= "<div class='main'>";
    $layoutPackDotHome .= "<ul class='cbp-ig-grid'>";  
    $layoutPackDotHome .= "<li class='wrapbackbtn'>";
    $layoutPackDotHome .= "<div class='backbtn'>";
    $layoutPackDotHome .= "<a href='".$pathmm."order/inicio/?steps=dos' class='' type='button'>";
    $layoutPackDotHome .= "<i class='fa fa-th-large'></i>";
    $layoutPackDotHome .= "<span>KITs Disponibles</span>";
    $layoutPackDotHome .= "</a>";
    $layoutPackDotHome .= "</div>";
    $layoutPackDotHome .= "</li>";
    
    if($itemPackDotacion > 0){
        
        //ico item kit
        if($genderSSUser == 1){
            $imgKitRopa = $pathmm."appweb/img/ropa-masculino.png";
            $imgZapatos = $pathmm."appweb/img/zapatos-masculino.png";
        }
        if($genderSSUser == 2){
            $imgKitRopa = $pathmm."appweb/img/ropa-femenino.png";
            $imgZapatos = $pathmm."appweb/img/zapatos-femenino.png";
        }
        
        $imgAdicional = $pathmm."appweb/img/adional-kit.png";
        
        //titu item kit
        $tituKDRopa = "Kit de Ropa";
        $tituKDZapatos = "Kit de Zapatos";
        $tituKDAdicional = "Kit Unitario";
        
        //url item kit
        $utlKDRopa = $pathmm.$takeOrderDir."/inicio/?steps=tres";
        $utlKDZapatos = $pathmm.$takeOrderDir."/browse/?steps=cuatro&l2=";
        $utlKDAdicional = $pathmm.$takeOrderDir."/browse/?steps=cuatro&l2=";

        $tkC = "calido";
        $tkF = "frio";
        $tkZ = "zapatos";
        $tkA = "adicional";
        
        $prendasArr = array();
        $totalPzKit = 0;
        foreach($packDotacion as $pdKey){
            //$tipoKitArr[] = $pdKey;
            $tipoKit = $pdKey['kit'];
            $ifGIFTtipoKit = $pdKey['id_subcatego_producto'];
            //$ifSHOEStipoKit = $pdKey['id_subcatego_producto'];
            $pzsKit = $pdKey['cant_pz_kit'];
            
            $totalPzKit += $pzsKit;
            //$totalPzKit += $totalPzKit;
            
            //consulta las prendas disponibles
            $prendasArr[] = prendasUserQuery($tipoKit, $typeColection);
            
            if(is_array($prendasArr)){
                foreach($prendasArr as $paKey => $paVall){
                if(is_array($paVall)){
                    foreach($paVall as $paVal){
                        $idCategoBrowse = $paVal['id_catego_product'];
                        $kit4UserBrowse = $paVal['tipo_kit_4user']; 
                        //$kit4UserBrowse = $paVal['id_subcatego_producto'];
                        
                        //pacKit Activado
                        $PacKitActiveClass = "";
                        if(isset($idCategoProd)){
                            $PacKitActiveClass = ($idCategoProd == $idCategoBrowse)? "active": "" ;    
                        }
                        
                        
                        if($kit4UserBrowse == $tkC){
                            $urlPrint = $utlKDRopa."&k4u=".$tkC;
                        }
                        if($kit4UserBrowse == $tkF){
                            $urlPrint = $utlKDRopa."&k4u=".$tkF;
                        }
                        if($kit4UserBrowse == $tkZ){
                            $urlPrint = $utlKDZapatos.$idCategoBrowse."&addl3=".$ifGIFTtipoKit;
                        }
                        if($kit4UserBrowse == $tkA){
                            $urlPrint = $utlKDAdicional.$idCategoBrowse."&addl3=".$ifGIFTtipoKit;
                        }                       
                    }
                }                                                            
                }
            }
            
            //define interaccion - print datas de cada pack dotacion            
            switch($tipoKit){
                case"calido";
                    $tituPrint = $tituKDRopa;
                    $icoPrint = $imgKitRopa;
                break;
                case"frio";
                    $tituPrint = $tituKDRopa;
                    $icoPrint = $imgKitRopa;
                break;
                case"zapatos";
                    $tituPrint = $tituKDZapatos;
                    $icoPrint = $imgZapatos;
                break;
                case"adicional";
                    $tituPrint = $tituKDAdicional;
                    $icoPrint = $imgAdicional;
                break;
            }
            
            
            $layoutPackDotHome .= "<li>";// class='".$PacKitActiveClass."'
            $layoutPackDotHome .= "<span class='badge bg-red'>".$pzsKit." PZs</span>";
            $layoutPackDotHome .= "<a href='".$urlPrint."'>";
            $layoutPackDotHome .= "<span class='cbp-ig-icon'>";
            $layoutPackDotHome .= "<img src='".$icoPrint."' class='img-responsive printicon' style='margin:0px auto;' />";// style='margin:0px auto; height:195px;'
            $layoutPackDotHome .= "</span>";
            $layoutPackDotHome .= "<h3 class='cbp-ig-title'>".$tituPrint."</h3>";
            $layoutPackDotHome .= "</a>";
            $layoutPackDotHome .= "</li>";
        }
    }
    $layoutPackDotHome .= "</ul>";//cbp-ig-grid
    //$layoutPackDotHome .= "</div>";//main
    
}
//echo "<pre>";
//print_r($prendasArr);
//echo "</pre>";



//VALIDA CATEGORIAS (KITS) SELECCIONADAS EN EL PEDIDO


//OBTENER EL PEDIDO ACTUAL REALIZADO POR EL USUARIO
//function queryOrderKit($idOrderTmp_, $idCategoProd_){
function queryOrderKit(){
    global $db;
    global $sellerID;
    global $otNOW;

    $db->where ("id_solici_promo", $otNOW);//$otNOW);
    
    $listprodTmp = $db->get ("especifica_prod_pedido", null, "id_espci_prod_pedido, id_solici_promo, id_catego_prod, id_subcatego_producto");
    
    $resuListProdTmp = count($listprodTmp);
    if ($resuListProdTmp > 0){
        foreach ($listprodTmp as $lptkey) {             
            $orderTmp_actiOne[] = $lptkey;            
        }
        return $orderTmp_actiOne;
    }  
}


//$idOrderTmpvar = "366";
//$idCategoProdvar = "6";
//$pedidoActual= queryOrderKit($idOrderTmpvar, $idCategoProdvar);



/*$packDotUser = $packDotacion;

function infoCATDOT($idCATDOT_){
    global $db;
    $datalaDOT = array();
    //$db->where ("id_catego_product", $idCATDOT_);    
    //$listCAT = $db->get ("categorias_productos", null, "id_catego_product, nome_catego_product, descri_catego_prod, tipo_kit_4user");
    $qlcat = "SELECT categorias_productos.id_catego_product, categorias_productos.nome_catego_product, categorias_productos.descri_catego_prod, categorias_productos.tipo_kit_4user, sub_categorias_productos.id_subcatego_producto, sub_categorias_productos.id_catego_product FROM sub_categorias_productos, categorias_productos WHERE sub_categorias_productos.id_catego_product = categorias_productos.id_catego_product AND categorias_productos.id_catego_product = ".$idCATDOT_;
    $listCAT = $db->rawQuery($qlcat);
    $resuListCAT = count($listCAT);
    if ($resuListCAT > 0){
        foreach ($listCAT as $lckey) {             
            $datalaDOT[] = $lckey;            
        }
        return $datalaDOT;
    } 
    
}

if(is_array($pedidoActual)){
    $getDataCatDot = array();      
    //ARRAY PEDIDO ACTUAL
    foreach($pedidoActual as $paKey){
        $idCATEDOT = $paKey['id_catego_prod'];
        //$idSubCATEDOT = $paKey['id_subcatego_producto'];
        
        $getDataCatDot[] = infoCATDOT($idCATEDOT);
        
        //ARRAY DATAS CATEGORIA 
        foreach($getDataCatDot as $gcdKey){
            foreach($gcdKey as $gcdVal){
            $idDataCAT = $gcdVal['id_catego_product'];
            $kitDataCAT = (empty($gcdVal['tipo_kit_4user']))? "adicional" : $gcdVal['tipo_kit_4user'];
            $nameDataCAT = $gcdVal['nome_catego_product'];
            //ARRAY PAQUETE DOTACION ASIGNADO AL USUARIO
            if(is_array($packDotUser)){
                foreach($packDotUser as $pduKey){
                    $dataPDU = $pduKey['kit'];  
                    
                    //COMPARA EL PAQUETE ASIGNADO CON LA INFO DE LA CATEGORIA
                    if($kitDataCAT == $dataPDU){
                        if($idCATEDOT == $idDataCAT){
                            echo "la categoria ".$nameDataCAT." esta en el pedido<br>";
                        }
                    }
                    
                }
            }
                   
            }
        }
    }
}*/

//OBTENER CADA ELEMENTO DEL KIT ACTUAL ASIGNADO AL USUARIO                
function getAdicionalKit($varL2Prod_, $SubCateADDKIT_){
    global $db;
    $dataAddKit = array();
    $smPackDotADD = $db->subQuery("cp2");        
    //$smPackDotADD->where("id_catego_product", '6');                                                     
    //$smPackDotADD->where('tipo_kit_4user', $prendaAdicional);
    $smPackDotADD->get("categorias_productos");

    //SUBCATEGORIAS
    $db->join($smPackDotADD,"cp2.id_catego_product = sc2.id_catego_product", 'RIGHT');
    $db->where ("id_subcatego_producto", $SubCateADDKIT_);    
    //$db->orderBy("posi_sub_cate_prod","asc");    
    $resuAK = $db->get ("sub_categorias_productos sc2",null,"sc2.nome_subcatego_producto,sc2.id_subcatego_producto, cp2.id_catego_product, cp2.nome_catego_product, cp2.descri_catego_prod, cp2.id_catego_product");
    //$resuAK[]['tipo_kit_4user'] = "adicional";
    if(count($resuAK)>0){
    foreach($resuAK as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}

function getZapatosKit($varL2Prod_, $SubCateADDKIT_){
    global $db;
    $dataAddKit = array();
    $smPackDotADD = $db->subQuery("cp2");        
    $smPackDotADD->where("id_catego_product", $varL2Prod_); 
    //$smPackDotADD->where('tipo_kit_4user', $prendaAdicional);
    $smPackDotADD->get("categorias_productos");

    //SUBCATEGORIAS
    $db->join($smPackDotADD,"cp2.id_catego_product = sc2.id_catego_product", 'RIGHT');
    $db->where ("id_subcatego_producto", $SubCateADDKIT_);    
    //$db->orderBy("posi_sub_cate_prod","asc");    
    $resuAK = $db->get ("sub_categorias_productos sc2",null,"sc2.nome_subcatego_producto,sc2.id_subcatego_producto, cp2.id_catego_product, cp2.nome_catego_product, cp2.descri_catego_prod, cp2.id_catego_product, cp2.tipo_kit_4user");
    //$resuAK[]['tipo_kit_4user'] = "adicional";
    if(count($resuAK)>0){
    foreach($resuAK as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}
    
function  defUserPackDot(){
    global $db;
    global $idSSUser;
    global $typeColection;
    
    //ARRAY PRINT SITE MAP USER    
    $dataDefUserPackDot = array();
    //CATEGORIAS
    $smPackDot = $db->subQuery ('pd');        
    $smPackDot->where('id_account_user', $idSSUser);                                                     
    //$smPackDot->where('kit', 'adicional', '!=');
    $smPackDot->get('pack_dotacion_user');


    $db->join($smPackDot, 'pd.kit=cp.tipo_kit_4user');        
    $db->where('id_depart_prod', $typeColection);
    $db->orderBy('cp.tipo_kit_4user','asc');
    $smCatProd = $db->get ('categorias_productos cp', null, 'cp.id_catego_product, cp.nome_catego_product, cp.descri_catego_prod, pd.id_subcatego_producto, cp.tipo_kit_4user, pd.kit'); 

    if(is_array($smCatProd)){

        foreach($smCatProd as $dmcpKey){
            $varL2Prod = $dmcpKey['id_catego_product'];
            $ifADDKIT = $dmcpKey['tipo_kit_4user'];
            $SubCateADDKIT = $dmcpKey['id_subcatego_producto'];


            //SUBCATEGORIAS
            $smCatDot = $db->subQuery ('cd');        
            $smCatDot->where('id_catego_product', $varL2Prod);
            $smCatDot->where('tipo_kit_4user', 'adicional', '!=');
            $smCatDot->where('tipo_kit_4user', 'zapatos', '!=');
            $smCatDot->get('categorias_productos');

            $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
            $db->orderBy('scd.nome_subcatego_producto','asc');
            $dataDefUserPackDot[] = $db->get ('sub_categorias_productos scd', null, 'cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); 

            if($ifADDKIT == "adicional"){        
                $dataDefUserPackDot[] = getAdicionalKit($varL2Prod, $SubCateADDKIT);    
            }

            if($ifADDKIT == "zapatos"){
                $dataDefUserPackDot[] =  getZapatosKit($varL2Prod, $SubCateADDKIT);
            }                    
        }
    }
    return $dataDefUserPackDot;
}//fin function defUserPackDot

                          
$userPDActiArr = array();
$userPDActiArr = defUserPackDot();

$pedidoActual = array();
$pedidoActual = queryOrderKit();                
                
//COMPARA EL PEDIDO CON LOS ITEMS ASIGNADOS

/*if(is_array($userPDActiArr)){

    foreach($userPDActiArr as $updaKey){

        foreach($updaKey as $updaVal){
            
            $varItemSubCate = $updaVal['id_subcatego_producto'];
            
            
            foreach($pedidoActual as $pauKey){
                $varKitPAU = $pauKey['id_catego_prod'];
                $varItemPAU = $pauKey['id_subcatego_producto'];
                
                echo $varItemPAU."<br>";
                
                if($varItemSubCate === $varItemPAU){
                    
                    $varKitDesabled[] = $varKitPAU; //(CATEGORIAS)
                    $varItemDesabled[] = $varItemPAU;//(SUB-CATEGORIAS)
                }
                
            }
            
        }
    }
}

                
echo "<pre>";
print_r($pedidoActual);
echo "</pre>";*/

