<?php 
$sitMapCat = array();
$sitMapCat = defUserPackDot();

$footerTakeOrder ="";
$footerTakeOrder .="<footer class='main-footer'>";            
$footerTakeOrder .="<div class='row wrapsm maxwidth-layout'>";
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smabout'>
                    <div class='header-smap'>
                        <h3>Sobre Quest</h3>
                    </div>
                    <p><i class='fa fa-quote-left fa-3x padd-right-xs'></i>Somos una de las principales compañías de moda en Colombia y contamos con un reconocido prestigio nacional, pues gracias a su vertiginoso crecimiento y posicionamiento comercial, la capacidad operativa y generación de empleo ha contribuido al desarrollo económico de la industria textil en los últimos años. </p>
                </div><!--//SOBRE-->";
                
$footerTakeOrder .="<div class='col-xs-12 col-sm-3 smcata'>                    
                    <div class='header-smap'>
                        <h3>Mapa del sitio</h3>
                    </div>
                    <ul>";
                                                                                                                                                        
                    $prevVarItemKit = "";
                    $prevVarItemCat = "";
                    $prevVarItemSub = "";

                    $layoutSMCATA = "";     

                    if(is_array($sitMapCat)){

                        foreach($sitMapCat as $smcKey){
                            
                            if(is_array($smcKey)){

                            foreach($smcKey as $smcVal){
                                
                                //$deptoLevel = empty($smcVal['id_depart_prod'])? "" : $smcVal['id_depart_prod'];
                                
                                /*if(isset($deptoLevel) && $deptoLevel != ""){
                                    if($deptoLevel == 1){
                                        $nameItemKit = "Masculino";      
                                    }else if($deptoLevel == 2){
                                        $nameItemKit = "Femenino";      
                                    }
                                }else{
                                    if(!empty($smcVal['tipo_kit_4user'])){
                                        $nameItemKit = $smcVal['tipo_kit_4user'];    
                                    }else{
                                        $nameItemKit = "unitario";    
                                    }    
                                }*/
                                
                                if(!empty($smcVal['tipo_kit_4user'])){
                                    $nameItemKit = $smcVal['tipo_kit_4user'];    
                                }else{
                                    $nameItemKit = "unitario";    
                                } 
                                
                                

                                $varItemCate = $smcVal['id_catego_product'];
                                $nameItemCate = $smcVal['nome_catego_product'];

                                $varItemSubCate = $smcVal['id_subcatego_producto'];
                                $nameItemSubCate = $smcVal['nome_subcatego_producto'];
                                
                                //if($nameItemKit == ""){ $nameItemKit = "unitario"; }
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
                                        $layoutSMCATA .= "<strong class='titupackdot'>Kit ".$nameItemKit."</strong>";
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
                            }
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
                    <p><a href='#!' type='button' data-toggle='modal' data-target='#polidev'>Politicas de devolución</a></p>
                    <p><a href='../../userguia/' target='_black' type='button'>Guía de usuario</a></p>
                    <p><i class='fa fa-fax margin-right-xs'></i>  (2) 489 5000</p>
                    <p><i class='fa fa-mobile fa-lg margin-right-xs'></i><i class='fa fa-whatsapp fa-lg margin-right-xs'></i>  +57 (312) 758 8111</p>
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
                    <!--<p>Diseñado por <a href='' target='_blank'>MASSIN</a></p>-->
                </div><!--//COPY-->";
                                                                
$footerTakeOrder .="</div> <!--//WRAP SITEMAP-->";
            
$footerTakeOrder .="<div class='row wrapautor maxwidth-layout'>
                <div class='col-xs-12'>
                    <p>Hecho con <a href='http://massin.co/' target='_blank'><i class='fa fa-heart fa-2x text-red'></i></a> en Global Service World S.A.S</p>                    
                </div>
            </div><!--//AUTOR-->";
$footerTakeOrder .="</footer>";
echo $footerTakeOrder;