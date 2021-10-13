<?php
if (!isset($_SESSION)) {
  session_start();
}
//////////////////////////////////////
//DEFINE PATH SERVIDOR
//////////////////////////////////////
$protocol = "http://";
$httphost  = $_SERVER["HTTP_HOST"];
$servername = $_SERVER["SERVER_NAME"];
$uriFILE = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
//$uriDIR = "/projects/questso/";
$uriDIR = "/";  

//path global
$pathsite = $protocol.$httphost;

//path main menu
$pathmm = $protocol.$httphost.$uriDIR;

//path this file
$pathFile = $protocol.$httphost.$uriFILE;

//directorys name section web
$takeOrderDir = "order";
$bossDir = "boss";
//$admiDir = "admiquest";
$admiDir = "admisite";

//////////////////////////////////////
//PERSONALIZE  OPTIONS
//////////////////////////////////////

//USER OPTIONS -> CURRENCY | LANG | DATE
define('LANG',"es_419");  // es_419 | pt_BR | en_US
date_default_timezone_set('America/Bogota'); // 
setlocale (LC_ALL,'es_419');
$defMoneda = "$"; //$ peso | U$ dollar | R$ Real | &pound; libra esterlina  | &euro; Euro  
define('CURRENCYSITE', $defMoneda);	

//DEFINE 
$dateTime = new DateTime();
$timeStamp = $dateTime->getTimestamp();
$dateFormatDB = $dateTime->format('Y-m-d');
$horaFormatDB = $dateTime->format('H:i:s');
$dateFormatHuman = $dateTime->format('d/m/Y');
$dateFormatPost = $dateTime->format('YmdHis');


//METATAGS
define('METATITLE', 'Admi - Dotaciones Quest');

//LAYOUT OPTIONS SKYN OPTION
//BOXED - FIXED - TOGLE SIDEBAR
$bodyLayoutCustom = "<body class='";
$bodyLayoutCustom .= "hold-transition";
$bodyLayoutCustom .= " skin-blue";
$bodyLayoutCustom .= " sidebar-mini";
$bodyLayoutCustom .= "'>";
define('LAYOUTOPTION', $bodyLayoutCustom);

// Fav and touch icons 
$favicon_touch="<link rel='icon' type='image/png' href='".$pathmm.$admiDir."/img/favicon.png'>";
//$favicon_touch.="<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$pathmm.$admiDir ."img/apple-touch-icon-144-precomposed.png'>";
//$favicon_touch.="<link rel='apple-touch-icon-precomposed' sizes='114x114' href='".$pathmm.$admiDir ."img/apple-touch-icon-114-precomposed.png'>";
//$favicon_touch.="<link rel='apple-touch-icon-precomposed' sizes='72x72' href='".$pathmm.$admiDir ."img/apple-touch-icon-72-precomposed.png'>";
//$favicon_touch.="<link rel='apple-touch-icon-precomposed' href='".$pathmm.$admiDir ."img/apple-touch-icon-57-precomposed.png'>";
define('_FAVICON_TOUCH_', $favicon_touch);


//////////////////////////////////////
//DEFINE RECURSOS
//////////////////////////////////////
$fileCssLayout = "";
$fileJSLayout = "";

$fileCssPlugin_name = "";
$fileJSPlugin_name = "";

//ARCHIVOS CSS LAYOUT

//<!-- Bootstrap 3.3.6 -->
$fileCssLayout .= "<link rel='stylesheet' href='".$pathmm.$admiDir."/appweb/css/bootstrap.css'>";
//<!-- Font Awesome -->
$fileCssLayout .= "<link rel='stylesheet' href='".$pathmm.$admiDir."/appweb/css/font-awesome.min.css'>";
//<!-- Ionicons -->
//$fileCssLayout .= "<link rel='stylesheet' href='".$pathmm.$admiDir."appweb/css/ionicons.min.css'>";
//<!-- Theme style -->
$fileCssLayout .= "<link href='".$pathmm.$admiDir."/appweb/css/styles-site.css' rel='stylesheet' type='text/css' />";
//<!-- AdminLTE Skins. Choose a skin from the css/skins
//folder instead of downloading all of them to reduce the load. -->
$fileCssLayout .= "<link href='".$pathmm.$admiDir."/appweb/css/skin-blue.css' rel='stylesheet' type='text/css' />";
$fileCssLayout .= "<link href='".$pathmm.$admiDir."/appweb/css/applayouts.css' rel='stylesheet' type='text/css' />";
//sweet alert
$fileCssLayout .= "<link href='".$pathmm.$admiDir."/appweb/plugins/sweetalert/sweetalert.css' rel='stylesheet' type='text/css' />";



//<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
//<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
$fileCssLayout .= "<!--[if lt IE 9]>
    <script src='".$pathmm.$admiDir."/appweb/plugins/misc/html5shiv.js'></script>
    <script src='".$pathmm.$admiDir."/appweb/plugins/misc/respond.min.js'></script>
    <![endif]-->";

//ARCHIVOS CSS PLUGIN

//////////////////////////////////////////////////////////////////////////////////////////////

//ARCHIVOS JS LAYOUT

//<!-- jQuery 2.2.3 -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/plugins/jQuery/jquery-2.2.3.min.js'></script>";
//<!-- Bootstrap 3.3.6 -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/js/bootstrap.min.js'></script>";
//<!-- SlimScroll -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/plugins/slimScroll/jquery.slimscroll.min.js'></script>";
//<!-- FastClick -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/plugins/fastclick/fastclick.js'></script>";
//<!-- main App -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/js/app.js'></script>";
//<!-- sweet alert -->
$fileJSLayout .= "<script src='".$pathmm.$admiDir."/appweb/plugins/sweetalert/sweetalert.min.js'></script>";
//<!-- acti submit searbox -->
$fileJSLayout .= "<script type='text/javascript'>
    $(document).ready(function() {        
        $('#btn-search').on('click',function(e){
            e.preventDefault();
            var search_key = $('#txtkey').val(),
                formsb = $('#searchbox');
            if(search_key != ''){			  
              formsb.submit();
            }
        });        
    });                        
</script>";


$fileJSLayout .= "<script>
    $('a.trashtobtn').click(function(e) {
        e.preventDefault(); 
        var linkURL = $(this).attr('href');
        var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        var reMsjProd = $(this).attr('data-remsj');
        confiElimiProd(linkURL, nameProd, titleEv, msjProd, reMsjProd);
      });

    function confiElimiProd(linkURL, nameProd, titleEv, msjProd, reMsjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold;>' +nameProd + '</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: true,
          closeOnConfirm: false,
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

    </script>";
$fileJSLayout .= "<script>    
$(document).ready(function(){  
	jQuery('img').each(function(){  
		jQuery(this).attr('src',jQuery(this).attr('src')+ '?' + (new Date()).getTime());  
	});  
}); 
</script>";   

//ARCHIVOS JS PLUGIN

define('_CSSFILESLAYOUT_', $fileCssLayout);
define('_JSFILESLAYOUT_', $fileJSLayout);