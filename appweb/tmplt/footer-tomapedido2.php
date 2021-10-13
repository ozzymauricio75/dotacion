<?php 
$sitMapCat = array();
$sitMapCat = defUserPackDot();

$footerTakeOrder ="";
$footerTakeOrder .="<footer class='main-footer'>";    
$footerTakeOrder .="<div class='wrapsm'>";        
$footerTakeOrder .="<div class='row maxwidth-layout'>";
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
                    <p><a href='".$pathmm."sitemap/' >Ver mapa del sitio</a></p>";
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

$footerTakeOrder .="<div class='row wrapactualizacion maxwidth-layout'>
                <div class='col-xs-12'>
                    <p style='text-align:center;'>La última actualización del aplicativo fue: Enero 11 de 2017 / 23:35</p>                    
                </div>
            </div><!--//ACTUALIZACION-->";

$footerTakeOrder .="</div> <!--//wrapsm-->";
            
$footerTakeOrder .="<div class='row wrapautor maxwidth-layout'>
                <div class='col-xs-12'>
                    <p>Hecho con <a href='http://massin.co/' target='_blank'><i class='fa fa-heart fa-2x text-red'></i></a> en Global Service World S.A.S</p>                    
                </div>
            </div><!--//AUTOR-->";
$footerTakeOrder .="</footer>";
echo $footerTakeOrder;