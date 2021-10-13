<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php //require_once '../../appweb/inc/sessionvars.php'; ?>

<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/sessionvars-boss.php'; ?>
<?php require_once '../../appweb/inc/query-prods-boss.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp-boss.php'; ?>


<?php 
/*
///////////////////////////////////////////////////
//////////////////////////////////////////////////
++++++++++++++++++++++++++++++++++++++++++++++++++++
CRUD CATALOGO - PEDIDO
++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////////////////////////
//////////////////////////////////////////////////
*/

//DEFINE VARS
$printCatalogo = array();
$subCateArr = array();
$printSubCate = array();
$printPzasOrder = array();


//$idCategoProd = $_GET['l2'];

//IMPRIME CATEGORIAS - CATALOGO ->[[[KITS]]]
/*
$printCatalogo = categoSelectQuery($idCategoProd);
foreach($printCatalogo as $printCatKey){
    $idCategoProd = $printCatKey['id_catego_product'];
    $nomeCategoProd = $printCatKey['nome_catego_product'];
    $subNomeCategoProd = $printCatKey['descri_catego_prod'];
}*/




//IMPRIME SUBCATEGOS

/*$printSubCate = subCateCatalogoQuery();
echo "<pre>";
print_r($printSubCate);
echo "</pre>";*/


$adicionalVar = "";
$input_l3 ="";
if(isset($_GET['addl3']) && $_GET['addl3'] != ""){
    $adicionalVar = (int)$_GET['addl3'];
    $input_l3 = "<input type='hidden' name='addl3inp' value='".$adicionalVar."' />";
}elseif(isset($_GET['addl3inp']) && $_GET['addl3inp'] != ""){
    $adicionalVar = (int)$_GET['addl3inp'];
    $input_l3 = "<input type='hidden' name='addl3inp' value='".$adicionalVar."' />";
}
//QUERY SUBCATAGORIA DATABASE -> [[[[PRENDAS]]]]
$subCateArr = subCateCatalogoQuery($idCategoProd, $adicionalVar);
$cantPzCatego = count($subCateArr);

/*if(is_array($subCateArr) && $cantPzCatego>0){                                                        
    foreach($subCateArr as $refkey){
        $level2Prod = $refkey['id_catego_product'];
        $printSubCate[] = $refkey;
        $printPzasOrder[] = $refkey;
    }
}*/

//DEFINIR ESTADOS DE PROGRESO POR KIT

$totalPZasOrder = 0;
$totalPzKit=0;
$totalPZasOrderGLOB  = 0;
/*$totalItemsOTNOW = queryOrderTmpItem($otNOW, $idCategoProd);//queryOrderTmpOne($otNOW);
$totalPZasOrder = count($totalItemsOTNOW);

$maxPZAS = $cantPzCatego;
$valueProgresGlobal = ($totalPZasOrder/$maxPZAS)*100;
$valueProgresGlobalFormat = round($valueProgresGlobal, 2, PHP_ROUND_HALF_DOWN);


//DEFINE PROGRESO COMPRA GLOBAL
$totalItemsOTGLOB = queryOrderTmpOne($otNOW);
$totalPZasOrderGLOB = count($totalItemsOTGLOB);


$valueGlobalProgess = ($totalPZasOrderGLOB/$totalPzKit)*100;//$totalPZasOrder
$valueGlobalProgessFormat = round($valueGlobalProgess, 2, PHP_ROUND_HALF_DOWN);


//IMPRIME PRODS
$printProds = array();
$printProds = queryProds();

//$totalItemsProd = count($printProds);

//LAYOUT BTN CONTINUAR COMPRANDO
$btnContinuebuying = "";
if($totalPZasOrder==$maxPZAS){
    $btnContinuebuying = "<div class='row'>";
    $btnContinuebuying .= "<div class='col-xs-12 text-center'>";
    $btnContinuebuying .= "<div class='box25'>";
    $btnContinuebuying .= "<a href='".$pathmm."order/inicio/?steps=dos' type='button' class='btn btn-success btn-lg padd-hori-md'>";
    $btnContinuebuying .= "<i class='fa fa-shopping-cart fa-lg margin-right-md'></i>";
    $btnContinuebuying .= "Continuar comprando";
    $btnContinuebuying .= "</a>";
    $btnContinuebuying .= "</div>";
    $btnContinuebuying .= "</div>";
    $btnContinuebuying .= "</div>";
}
*/
//PATH FOTO DEFAULT
$pathFileDefault = $pathmm."img/nopicture.png";

//IMPRIME FOTOS
//$queryFotosProds = array();

/*
*SITE MAP - ESQUEMA LINKS
*/

$actiSecc = "mapasite";

?>
<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
<head>
    <meta charset="utf-8">
    <title>QUEST - Toma Pedidos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>             
    <?php echo _FAVICON_TOUCH_ ?>                
</head>
<body class="hold-transition skin-black layout-top-nav ">
    <?php echo "<span id='currencysite' class='hidden'>".CURRENCYSITE."</span>"; ?>
    <?php echo "<span id='pathfile' class='hidden'>".$pathmm."</span>"; ?>
    <?php echo "<span id='clientnow' class='hidden'>".$nomeClienteOrder."</span>"; ?>       
    <!-- Site wrapper -->
    <div class="wrapper" id="wrapperbrowse">
        <?php
        /*
            *
            *---------------------------
            *HEADER
            *---------------------------
            *    
        */  
        ?>
        <?php include '../../appweb/tmplt/header-boss.php'; ?>
                               
    <?php
    /*
        *
        *---------------------------
        *CONTAINS PAGE - WRAPER
        *---------------------------
        *    
    */  
    ?>        
    <div class="content-wrapper ">
    <?php
    /*
        *
        *---------------------------
        *PAGE HEADER - BREAD CRUMB
        *---------------------------
        *    
    */  

    ?>                            
    <?php echo $headClienteActi_tmpl; ?>

    <?php 
    /*
        *
        *------------------------------
        *MENSAJES EVENTOS
        *------------------------------
        *
    */
        if(isset($errValidaTrashOrder) && $errValidaTrashOrder !=""){ echo $errValidaTrashOrder; }                
        if(isset($trashOrderOK) && $trashOrderOK !=""){ echo $trashOrderOK; }
        if(isset($errValidaSendOrder) && $errValidaSendOrder !=""){ echo $errValidaSendOrder; }
        if(isset($sendOrderOK) && $sendOrderOK !=""){ echo $sendOrderOK; }            
    ?>                           

    <section class=" row ">
        <div class="col-xs-12 unlateralpadding">
            <div class=" maxwidth-layout">
                <section class="content-header">
                    <ul class="nav nav-tabs  fa-lg">
                        <li role="presentation" class=""><a href="<?php echo $pathmm.$bossDir."/inicio/"; ?>">Inicio</a></li>
                        <li role="presentation" class="active"><a href="#!">Mapa del sitio</a></li>

                    </ul>
                </section>
            </div>
        </div>  
    </section>
        
    <?php
    /*
        *
        *---------------------------
        *MAIN CONTENT
        *---------------------------
        *    
    */
    ?>

        <section class="content bg-gray-light padd-top-xs padd-bottom-lg" >

            <?php
            /*
             *---------------------------
             *ESQUEMA CATEGRIAS
             *---------------------------
            */                
            ?>
            
            <header class="box50 clearfix">                      
                <h1>Mapa del sitio</h1>
                <span>Catalogo dotaciones Quest</span>
            </header>

            <div class="box50 padd-top-xs">
                <div class="box padd-hori-md">
                    <div class="box-header"></div>
                    
                    <div class="box-body">

                        <?php       

                        $navdot ="<ul class='list-unstyled'>";

                            $prevVarGender = "";
                            $prevVarItemKit = "";
                            $prevVarItemCat = "";
                            $prevVarItemSub = "";

                            $lyBrowseCat = "";     

                            if(is_array($userPDActiArr)){

                                foreach($userPDActiArr as $smcKey){

                                    if(is_array($smcKey)){

                                        foreach($smcKey as $smcVal){

                                            $varItemDepto = empty($smcVal['id_depart_prod'])? "" : $smcVal['id_depart_prod'];


                                            if($varItemDepto == 1){
                                                $nameItemDpto = "Masculino";      
                                            }else if($varItemDepto == 2){
                                                $nameItemDpto = "Femenino";      
                                            }


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
                                                    $lyBrowseCat .= "</li>";//////CIERRA ITEM KIT DOTACION
                                                    $lyBrowseCat .= "</ul>";////CIERRA wrap KIT DOTACION   

                                                }                                                                                                                   

                                                //======IMPRIME LAYOUT ITEM PACK DOTACION
                                                if($prevVarItemKit != $nameItemKit){

                                                    if($prevVarItemKit != ""){
                                                        $lyBrowseCat .= "</li>";//CIERRA ITEM PACK DOTACION
                                                        $lyBrowseCat .= "</ul>";//CIERRA wrap PACK DOTACION
                                                    }//CIERRA ITEM PACK DOTACION


                                                    //======IMPRIME LAYOUT MASCULINO FEMENINO
                                                    if($prevVarGender != $varItemDepto){
                                                        if($prevVarItemKit != ""){
                                                            $lyBrowseCat .= "</li>";//CIERRA ITEM DEPTO
                                                            $lyBrowseCat .= "</ul>";//CIERRA wrap DEPTO
                                                        }//CIERRA ITEM PACK DOTACION    

                                                         //======IMPRIME ITEM PACK
                                                        $lyBrowseCat .= "<li class=''>";//ITEM PACK DEPTO
                                                        $lyBrowseCat .= "<a href='#'><strong class='' style='text-transform:uppercase'>".$nameItemDpto."</strong></a>";
                                                        $lyBrowseCat .= "<ul class=''>";////wrap PACK DPTO                                       
                                                        $prevVarGender = $varItemDepto;

                                                    }

                                                    //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                                                    //======IMPRIME ITEM PACK
                                                    $lyBrowseCat .= "<li>";//ITEM PACK DOTACION             
                                                    $lyBrowseCat .= "<a href='#'><strong class='titupackdot'>Kit ".$nameItemKit."</strong></a>";
                                                    $lyBrowseCat .= "<ul class=''>";////wrap KIT DOTACION                                        
                                                    $prevVarItemKit = $nameItemKit;
                                                }

                                                //======IMPRIME ITEM KIT
                                                $lyBrowseCat .= "<li><a href='#'><strong>".$nameItemCate."</strong></a>";
                                                $lyBrowseCat .= "<ul class=''>";//////ITEM KIT DOTACION ////////WRAP ITEM PRENDA
                                                $prevVarItemCat = $varItemCate;
                                            }//CIERRA ITEM ITEM KIT

                                            //======IMPRIME LAYOUT ITEM PRENDA
                                            $lyBrowseCat .= "<li><a href='".$pathFile."?catego=".$varItemSubCate."&l2=".$varItemCate."&addl3=".$varItemSubCate."'><strong>".$nameItemSubCate."</strong></a></li>";////////ITEM PRENDA



                                        }//FIN FOREACH SITE MAP CATAGO ARR VAL
                                    }
                                }//FIN FOREACH SITE MAP CATAGO ARR

                            }//FIN IS ARRAY SITE MAP CATAGO ARR

                            //$lyBrowseCat .= "</li>";//////ITEM KIT DOTACION
                            $lyBrowseCat .= "</ul>";////////WRAP ITEM PRENDA
                            $lyBrowseCat .= "</li>";//////CIERRA ITEM KIT DOTACION                
                            $lyBrowseCat .= "</ul>";////wrap KIT DOTACION 
                            $lyBrowseCat .= "</li>";//////CIERRA ITEM DEPTO                
                            $lyBrowseCat .= "</ul>";////wrap KIT DEPTO
                            $lyBrowseCat .= "</li>";//ITEM PACK DOTACION  

                            $navdot .= $lyBrowseCat;                            

                        $navdot .="</ul>";//sidebar-menu

                        echo $navdot;

                        ?> 

                        </div>

                        
                    </div>
                </div>

            </section>              
        </div><!--/content-wrapper-->

        <?php
        /*
            *
            *---------------------------
            *FOOTER
            *---------------------------
            *    
        */
        ?>
        <?php include "../../appweb/tmplt/footer-boss.php"; ?>

        <div id="respuesta"></div>
        <input type="hidden" name="actionform" id="actionform" value="<?php echo $pathmm.$takeOrderDir."/browse/"; ?>">
        <input type="hidden" name="ordernow" id="ordernow" value="<?php echo $idOrderNow; ?>">
        <input type="hidden" name="tipokit" id="tipokit" value="<?php echo $idCategoProd; ?>">        


    </div><!-- /Site wrapper --> 
    
       
    <?php
    /*
        *
        *---------------------------
        *CONTROL SIDE - LIST ORDER
        *---------------------------
        *    
    */
    ?>
    <?php include '../../appweb/tmplt/order-list-tomapedido-boss.php'; ?>
    
    <div class="modal fade" id="polidev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-body">
                    <div id="showpolidev"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                                
                </div>
            </div>
        </div>
    </div>
    
                     
    <?php echo _JSFILESLAYOUT_ ?>
    <script type="text/javascript" src="../../appweb/plugins/form-validator/jquery.form-validator.min.js"></script>      
    <script type="text/javascript" src="crud-order.js"></script>
    <!-- pdf view -->
    <script type='text/javascript' src='../../appweb/lib/pdfobject.min.js' ></script>            
    <script type='text/javascript'>
        var pathSite = $("#pathfile").html();
        var optionsPDFview = {
            height: "480px",
            pdfOpenParams: { view: 'FitV', page: '1' }
        };
        PDFObject.embed(pathSite+'legal/politicas-devolucion-quest.pdf', '#showpolidev', optionsPDFview);
    </script>
    <script type="text/javascript">   
                                                    
    //validaciones	
    $.validate({
        modules : 'logic, jsconf',            
        onModulesLoaded : function() {                
            var configIdenti = {           
                validate : {
                    '.cantcart' : {
                        validation : 'number required',
                        'error-msg' : 'Escribe la cant. que deseas ordenar'
                    }
                }
              };                
            $.setupValidation(configIdenti);
        }
    });
        
    
    </script>
    
    <script type="text/javascript">
                                    
        $(".colorselect li").click(function(){
            var b=$(this);
            if(!b.hasClass("active")){
                b.siblings().removeClass("active");
                var colorq = b.attr("data-color");
                $("input[name=colorq]").val(colorq);
                $("input[name=colorqinp]").val('');
                
                 
                /*var a=b.closest(".skin"),
                    d=b.attr("class")?"-"+b.attr("class"):"",
                    c=a.data("icheckbox"),
                    g=a.data("iradio"),
                    e="icheckbox_minimal",
                    f="iradio_minimal";
                a.hasClass("skin-square")&&(e="icheckbox_square",f="iradio_square",void 0==c&&(c="icheckbox_square-green",g="iradio_square-green"));
                a.hasClass("skin-flat")&&(e="icheckbox_flat",f="iradio_flat",void 0==c&&(c="icheckbox_flat-red",g="iradio_flat-red"));
                a.hasClass("skin-line")&&(e="icheckbox_line",f="iradio_line",void 0==c&&(c="icheckbox_line-blue",g="iradio_line-blue"));
                void 0==c&&(c=e,g=f);
                a.find("input, .skin-states .state").each(function(){
                    var a=$(this).hasClass("state")$(this):$(this).parent(),
                    b=a.attr("class").replace(c,e+d).replace(g,f+d);
                    a.attr("class",b)
                });
                a.data("icheckbox",e+d);
                a.data("iradio",f+d);*/
                b.addClass("active")
            }
        });
        
        $(".tallaletraselect li").click(function(){
            var t=$(this);
            if(!t.hasClass("active")){
                t.siblings().removeClass("active");
                var tallaq = t.attr("data-tl");
                $("input[name=tallaq]").val(tallaq);
                $("input[name=tallaqinp]").val('');
                t.addClass("active")
            }
        });
           
    </script>

    <script>
    $('a.sendbtn').click(function(e) {
        e.preventDefault(); 
        //var linkURL = $(this).attr('href');
        //var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        confiSendOrder(titleEv, msjProd);
      });

    function confiSendOrder(titleEv, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold;>Oops</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: false,
          closeOnConfirm: false,
          closeOnCancel: false,
          animation: false,
          html: true
        });
      }
        
        
    $('a.pzskit').click(function(e) {
        e.preventDefault(); 
        var linkURL = $(this).attr('href');
        var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        checkPzas(linkURL, titleEv, nameProd, msjProd);
      });

    function checkPzas(linkURL, titleEv, nameProd, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold; font-size:15px;>' + nameProd + '</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: true,
          closeOnConfirm: true,
          closeOnCancel: true,
          animation: false,
          html: true
        }, function(isConfirm){
                  if (isConfirm) {
                    window.location.href = linkURL;
                  } else {
                    return false;	
                  }
                });
      }
        
       
        $('#polidev').modal('hidden');
    </script>
        
</body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/580923a9304e8e7585607da6/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</html>
