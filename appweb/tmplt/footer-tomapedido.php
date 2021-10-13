<?php
/*$footerTakeOrder ="<footer class='main-footer' style='padding-bottom:50px;'>
    <div class='pull-right hidden-xs'>
        <b>Version</b> 2.3.6
    </div>
    <strong>Copyright &copy; 2014-2016 <a href='http://almsaeedstudio.com'>Almsaeed Studio</a>.</strong> All rights reserved.
</footer>";
echo $footerTakeOrder;*/

$footerTakeOrder ="<footer class='main-footer' style=''>";            
$footerTakeOrder .="<div class='row wrapsm maxwidth-layout'>";
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smabout'>
                    <div class='header-smap'>
                        <h3>Sobre Quest</h3>
                    </div>
                    <p><i class='fa fa-quote-left fa-3x padd-right-xs'></i>Somos una de las principales compañías de moda en Colombia y contamos con un reconocido prestigio nacional, pues gracias a su vertiginoso crecimiento y posicionamiento comercial, la capacidad operativa y generación de empleo ha contribuido al desarrollo económico de la industria textil en los últimos años. La sede principal, ubicada en la ciudad de Cali en Colombia, alberga el centro de diseño y operaciones de la Compañía.</p>
                </div><!--//SOBRE-->";
                
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smcata'>                    
                    <div class='header-smap'>
                        <h3>Catálogo</h3>
                    </div>
                    <ul>";

                    //ARRAY PRINT SITE MAP USER
                    $sitMapCat = array();
                    
                    //CATEGORIAS
                    $smPackDot = $db->subQuery ('pd');        
                    $smPackDot->where('id_account_user', $idSSUser);                                                     
                    $smPackDot->where('kit', 'adicional', '!=');
                    $smPackDot->get('pack_dotacion_user');

                    $db->join($smPackDot, 'pd.kit=cp.tipo_kit_4user');        
                    $db->where('id_depart_prod', $typeColection);
                    $db->orderBy('cp.tipo_kit_4user','asc');
                    $smCatProd = $db->get ('categorias_productos cp', null, 'cp.id_catego_product, cp.nome_catego_product, cp.descri_catego_prod, pd.id_subcatego_producto, cp.tipo_kit_4user'); 
                                            
                    if(is_array($smCatProd)){
                        foreach($smCatProd as $dmcpKey){
                            $varL2Prod = $dmcpKey['id_catego_product'];

                            //SUBCATEGORIAS
                            $smCatDot = $db->subQuery ('cd');        
                            $smCatDot->where('id_catego_product', $varL2Prod);                
                            $smCatDot->get('categorias_productos');

                            $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
                            $db->orderBy('scd.nome_subcatego_producto','asc');
                            $sitMapCat[] = $db->get ('sub_categorias_productos scd', null, 'cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); 

                        }
                    }

                    //SI EXISTE ADICIONAL
                    $smPackDotADD = $db->subQuery ('pd2');        
                    $smPackDotADD->where('id_account_user', $idSSUser);                                                     
                    $smPackDotADD->where('kit', 'adicional');
                    $smPackDotADD->get('pack_dotacion_user');

                    $db->join($smPackDotADD, 'pd2.kit=cp2.tipo_kit_4user');        
                    $db->where('id_depart_prod', $typeColection);
                    $db->orderBy('cp2.tipo_kit_4user','asc');
                    $smCatProdADD = $db->get ('categorias_productos cp2', null, 'cp2.id_catego_product, cp2.nome_catego_product, cp2.descri_catego_prod, pd2.id_subcatego_producto, cp2.tipo_kit_4user'); 
                        
                    
                    if(is_array($smCatProdADD)){
                        foreach($smCatProdADD as $dmcpADDKey){
                            $varL2ProdADD = $dmcpADDKey['id_catego_product'];
                            $varL3ADDProd = $dmcpADDKey['id_subcatego_producto'];  

                            //SUBCATEGORIAS
                            $smCatDotADD = $db->subQuery ('cd');        
                            $smCatDotADD->where('id_catego_product', $varL2ProdADD);                
                            $smCatDotADD->get('categorias_productos');

                            $db->join($smCatDotADD, 'scd.id_catego_product=cd.id_catego_product');        
                            $db->where('id_subcatego_producto', $varL3ADDProd);
                            $db->orderBy('scd.nome_subcatego_producto','asc');
                            $sitMapCat[] = $db->get('sub_categorias_productos scd', null, 'cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user');


                        }
                    }
                                                                                                                                                        
                    $prevVarItemKit = "";
                    $prevVarItemCat = "";
                    $prevVarItemSub = "";

                    $layoutSMCATA = "";     

                    if(is_array($sitMapCat)){

                        foreach($sitMapCat as $smcKey){

                            foreach($smcKey as $smcVal){
                                $nameItemKit = $smcVal['tipo_kit_4user'];

                                $varItemCate = $smcVal['id_catego_product'];
                                $nameItemCate = $smcVal['nome_catego_product'];

                                $varItemSubCate = $smcVal['id_subcatego_producto'];
                                $nameItemSubCate = $smcVal['nome_subcatego_producto'];
                                
                                //======IMPRIME LAYOUT ITEM KIT
                                if($prevVarItemCat != $varItemCate){
                                    if($prevVarItemCat != ""){
                                        $layoutSMCATA .= "</li>";//////CIERRA ITEM KIT DOTACION
                                        $layoutSMCATA .= "</ul>";////CIERRA wrap KIT DOTACION   
                                    }                                                                                                                   

                                    //======IMPRIME LAYOUT ITEM PACK DOTACION
                                    if($prevVarItemKit != $nameItemKit){

                                        if($prevVarItemKit != ""){
                                            $layoutSMCATA .= "</li>";//CIERRA ITEM PACK DOTACION
                                            $layoutSMCATA .= "</ul>";//CIERRA wrap PACK DOTACION
                                        }//CIERRA ITEM PACK DOTACION
                                        
                                        //======IMPRIME ITEM PACK
                                        $layoutSMCATA .= "<li>";//ITEM PACK DOTACION             
                                        $layoutSMCATA .= "<strong class='titupackdot'>".$nameItemKit."</strong>";
                                        $layoutSMCATA .= "<ul>";////wrap KIT DOTACION                                        
                                        $prevVarItemKit = $nameItemKit;
                                    }
                                    
                                    //======IMPRIME ITEM KIT
                                    $layoutSMCATA .= "<li><strong>".$nameItemCate."</strong><ul>";//////ITEM KIT DOTACION ////////WRAP ITEM PRENDA
                                    $prevVarItemCat = $varItemCate;
                                }//CIERRA ITEM ITEM KIT
                                
                                //======IMPRIME LAYOUT ITEM PRENDA
                                $layoutSMCATA .= "<li><strong>".$nameItemSubCate."</strong></li>";////////ITEM PRENDA

                            }//FIN FOREACH SITE MAP CATAGO ARR VAL
                        }//FIN FOREACH SITE MAP CATAGO ARR

                    }//FIN IS ARRAY SITE MAP CATAGO ARR

                    $layoutSMCATA .= "</li>";//////ITEM KIT DOTACION
                    $layoutSMCATA .= "</ul>";////////WRAP ITEM PRENDA
                    $layoutSMCATA .= "</li>";//////CIERRA ITEM KIT DOTACION                
                    $layoutSMCATA .= "</ul>";////wrap KIT DOTACION 
                    $layoutSMCATA .= "</li>";//ITEM PACK DOTACION  

                    $footerTakeOrder .= $layoutSMCATA;                            
                                                                                                                       
$footerTakeOrder .="</ul>";
$footerTakeOrder .="</div><!--//CATALOGO-->";
                
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smcto'>                    
                    <div class='header-smap'>
                        <h3>Servicio al cliente</h3>
                    </div>
                    <p><a href=''>Politicas de devolución</a></p>
                    <p><i class='fa fa-fax margin-right-xs'></i>  (2) 489 5000</p>
                    <p><i class='fa fa-envelope  margin-right-xs'></i> licitaciones@quest.com.co</p> 
                    <p><i class='fa fa-map-marker margin-right-xs'></i> Calle 24N No. 5AN-30 Cali, Colombia</p>  

                </div><!--//AYUDA-->";
                
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smcopy'>
                    <div class='header-smap'>
                        <img src='../../appweb/img/logo_final2.png' class='img-responsive'>
                    </div>
                    <p>Razón Social: QUEST S.A.S.</p>
                    <p>Nit: 805022296-8</p>
                    <p><i class='fa fa-copyright margin-right-xs'></i>Todos los derechos reservados</p>
                    <p>Diseñado por <a href='http://massin.co/' target='_blank'>MASSIN</a></p>
                </div><!--//COPY-->";
                                                                
$footerTakeOrder .="</div> <!--//WRAP SITEMAP-->";
            
$footerTakeOrder .="<div class='row wrapautor maxwidth-layout'>
                <div class='col-xs-12'>
                    <p>Hecho con <i class='fa fa-heart fa-2x text-red'></i> por Global Service World S.A.S</p>                    
                </div>
            </div><!--//AUTOR-->";
$footerTakeOrder .="</footer>";
echo $footerTakeOrder;